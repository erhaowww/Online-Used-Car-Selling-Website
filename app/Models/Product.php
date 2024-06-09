<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use app\Repositories\Interfaces\Observable;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'user_id',
        'make',
        'model',
        'year',
        'mileage',
        'color',
        'transmission',
        'product_description',
        'product_image',
        'price',
        'deleted'
    ];

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
    
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function getPrice(): float
    {
        return $this->price;
    }
    
}


