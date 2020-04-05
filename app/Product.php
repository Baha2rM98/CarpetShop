<?php

namespace App;

use App\Helper\Helper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

/**
 * @property mixed title
 * @property mixed sku
 * @property mixed slug
 * @property mixed status
 * @property mixed price
 * @property mixed discount_price
 * @property mixed description
 * @property mixed brand_id
 * @property mixed user_id
 * @property mixed photos
 */
class Product extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'status', 'price', 'discount_price',
        'description', 'brand_id'
    ];

    /**
     * Bootstrap the model and its traits.(Override)
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        self::deleting(function (Product $product) {
            foreach ($product->photos as $photo) {
                Storage::disk('local')->delete('public/photos/'.Helper::getFileAbsolutePath('photos',
                        $photo->path));
            }
            $product->photos()->delete();
        });
    }

    /**
     * Returns a many-to-many relationship with Category
     * @return Relation
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product', 'product_id', 'category_id');
    }

    /**
     * Returns a one-to-many relationship with Brand
     * @return Relation
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Returns a many-to-many relationship with AttributeValue
     * @return Relation
     */
    public function attributeValues()
    {
        return $this->belongsToMany(AttributeValue::class, 'attributevalue_product', 'product_id',
            'attribute_value_id');
    }

    /**
     * Returns a many-to-many relationship with Photos
     * @return Relation
     */
    public function photos()
    {
        return $this->belongsToMany(Photo::class, 'photo_product', 'product_id',
            'photo_id');
    }
}
