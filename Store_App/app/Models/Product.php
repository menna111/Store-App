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
      return  $this->belongsTo(Category::class,'category_id');
    }

    public function user(){
        return  $this->belongsTo(User::class,'user_id','id')->withDefault();
    }
    public function tags(){
        return $this->belongsToMany(
            Tag::class,                   //related model
            'product_tag',                   // pivot table الجدول الوسيط
            'product_id',           // F.K in pivot table for current model
            'tag_id',               // F.K in pivot table for related model
            'id',                       //P.K in the current model
            'id'                        //P.K in the related model
        );
    }

}
