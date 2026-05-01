<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Category extends Model
{
    protected $fillable = ['name'];
 
    /**
     * Count of products using this category.
     * Used in the blade via withCount('products').
     */
    public function products()
    {
        // Products store category as a string name, not a foreign key.
        // So we use a raw relationship helper here.
        return $this->hasMany(Product::class, 'category', 'name');
    }
}