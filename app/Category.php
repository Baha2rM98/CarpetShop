<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property mixed parent_id
 * @property mixed name
 * @property mixed meta_title
 * @property mixed meta_desc
 * @property mixed meta_keywords
 * @property mixed slug
 */
class Category extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['parent_id', 'name', 'meta_title', 'meta_desc', 'meta_keywords'];

    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope('orderById', function (Builder $builder) {
            $builder->orderBy('categories.id', 'asc');
        });
    }

    /**
     * Returns children of each category recursively
     * @return Relation
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id')->with('children');
    }

    /**
     * Returns a many-to-many relationship with Product
     * @return Relation
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'category_product', 'category_id', 'product_id')->withTimestamps();
    }

    /**
     * Returns a many-to-many relationship with AttributeGroup
     * @return Relation
     */
    public function attributeGroups()
    {
        return $this->belongsToMany(AttributeGroup::class, 'attributegroup_category', 'category_id',
            'attribute_group_id')->withTimestamps();
    }
}
