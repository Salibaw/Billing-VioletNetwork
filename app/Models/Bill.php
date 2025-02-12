<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = ['billNo', 'product_id', 'productMrp', 'productQuantity', 'category'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    
}
