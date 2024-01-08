<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Meta extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'metables';

    public function metable()
    {
        return $this->morphTo(__FUNCTION__, 'metable_type', 'metable_id');
    }

    /**
     * Get all attached models of the given class to the meta.
     *
     * @param string $class
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function entries(string $class): MorphToMany
    {
        return $this->morphedByMany($class, 'metable', 'metables');
    }
}
