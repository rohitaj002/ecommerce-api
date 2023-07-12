<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'sku', 'additional_cost', 'stock_count'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
