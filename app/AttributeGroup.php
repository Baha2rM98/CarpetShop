<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property mixed title
 * @property mixed type
 */
class AttributeGroup extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'type'];

    /**
     * Bootstrap the model and its traits.(Override)
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        self::deleting(function (AttributeGroup $attributeGroup) {
            $attributeGroup->attributeValues()->delete();
        });
    }

    /**
     * Returns a one-to-many relationship with AttributeValue
     * @return Relation
     */
    public function attributeValues()
    {
        return $this->hasMany(AttributeValue::class, 'attribute_group_id');
    }

    /**
     * Returns a many-to-many relationship with Category
     * @return Relation
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'attributegroup_category', 'attribute_group_id', 'category_id');
    }
}
