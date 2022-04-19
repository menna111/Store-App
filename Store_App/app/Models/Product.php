<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable=['name','category_id','description',
        'price','sale_price','image','quantity','user_id'];


    public function category(){
      return  $this->belongsTo(Category::class);
    }
}
