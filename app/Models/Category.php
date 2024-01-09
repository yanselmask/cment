<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use SolutionForest\FilamentTree\Concern\ModelTree;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasFactory, ModelTree, HasSlug, HasTranslations;

    protected $fillable = ["parent_id", "title", "slug", "type", "order", 'description', 'color', 'background', 'x_icon', 'image'];

    protected $table = 'categories';

    public array $translatable = ['title', 'slug'];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function categorizable()
    {
        return $this->morphTo(__FUNCTION__, 'categorizable_type', 'categorizable_id');
    }

    /**
     * Get all attached models of the given class to the category.
     *
     * @param string $class
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function entries(string $class): MorphToMany
    {
        return $this->morphedByMany($class, 'categorizable', 'categorizables');
    }
}
