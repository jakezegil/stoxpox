<?php
 
namespace App;
 
use Illuminate\Database\Eloquent\Model;
 
class Product extends Model
{
    public function inventory() {
        return $this->hasMany(Inventory::class);
    }
    
    protected $fillable = [
        'name', 'price', 'stock_count'
    ];
}