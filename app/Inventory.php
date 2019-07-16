<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    public function product() {
        return $this->hasMany(Product::class);
    }

    protected $fillable = [
        'for_sale'
    ];

    protected $table = 'inventory';
}
