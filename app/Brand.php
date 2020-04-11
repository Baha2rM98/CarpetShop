<?php

namespace App;

use App\Helper\CustomSoftDeletes\CustomSoftDeletes;
use App\Helper\Helper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Storage;

/**
 * @property mixed title
 * @property mixed description
 * @property mixed photo_id
 * @property mixed photo
 * @property mixed products
 */
class Brand extends Model
{
    use CustomSoftDeletes;
    use Helper;

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
    protected $fillable = ['title', 'description', 'photo_id'];

    /**
     * Bootstrap the model and its traits.(Override)
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        self::deleting(function (Brand $brand) {
            if (isset($brand->photo)) {
                Storage::disk('local')->delete('public/photos/'.
                    self::getFileAbsolutePath('photos', $brand->photo->path));
                $brand->photo()->delete();
                foreach ($brand->products as $product) {
                    foreach ($product->comments as $comment) {
                        $comment->delete();
                    }
                    $product->delete();
                }
            } else {
                foreach ($brand->products as $product) {
                    foreach ($product->comments as $comment) {
                        $comment->delete();
                    }
                    $product->delete();
                }
            }
        });
    }

    /**
     * Creates a one-to-one relation with Photo
     * @return Relation
     */
    public function photo()
    {
        return $this->belongsTo(Photo::class);
    }

    /**
     * Returns a one-to-many relationship with Product
     * @return Relation
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'brand_id');
    }
}
