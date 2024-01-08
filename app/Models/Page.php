<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Tags\HasTags;
use Laravel\Scout\Searchable;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use Dotlogics\Grapesjs\App\Traits\EditableTrait;
use Dotlogics\Grapesjs\App\Contracts\Editable;
use Laravel\Scout\Attributes\SearchUsingFullText;

class Page extends Model implements Editable
{
    use HasFactory, HasSlug, HasTags, HasSEO, EditableTrait, Searchable;

    protected $guarded = [];

    protected $casts = [
        'status' => \App\Enums\PageStatus::class,
        'template' => \App\Enums\PageTemplate::class,
        'editorjs_blocks' => 'array'
    ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function metas()
    {
        return $this->morphMany(Meta::class, 'metable');
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array<string, mixed>
     */
    #[SearchUsingFullText(['title', 'content', 'editorjs_blocks', 'gjs_data'])]
    public function toSearchableArray()
    {
        return [
            'title' => (string) $this->title,
            'content' => (string) $this->content,
            'editorjs_blocks' => (string) $this->editorjs_blocks,
            'gjs_data' => (string) $this->gjs_data
        ];
    }
}
