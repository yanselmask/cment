<?php

namespace App\Models;

use Spatie\Tags\HasTags;
use Laravel\Scout\Searchable;
use Spatie\Sluggable\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\SlugOptions;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Scout\Attributes\SearchUsingFullText;

class Post extends Model
{
    use HasFactory, HasSlug, HasTags, HasSEO, Searchable;


    protected $guarded = [];

    protected $casts = [
        'status' => \App\Enums\PostStatus::class,
        'template' => \App\Enums\PostTemplate::class,
        'is_featured' => 'boolean',
        'is_sponsored' => 'boolean',
        'allowed_comment' => 'boolean',
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

    public function categories()
    {
        return $this->morphToMany(Category::class, 'categorizable');
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
            'excerpt' => (string) $this->excerpt,
            'content' => (string) $this->content,
            'editorjs_blocks' => (string) $this->editorjs_blocks,
        ];
    }
}
