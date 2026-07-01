<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'parent_id',
        'is_active',
        'position',
    ];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    static function getNested($parentId = null, $depth = 0, $maxDepth = 3)
    {
        if ($depth > $maxDepth) {
            return [];
        }

        $categories = self::where('parent_id', $parentId)->orderBy('position')->get();

        foreach ($categories as $cat) {
            $cat->children_nested = self::getNested($cat->id, $depth + 1, $maxDepth);
        }
        return $categories;
    }
}
