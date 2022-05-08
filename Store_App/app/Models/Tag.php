<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;




    public function products(){
        return $this->belongsToMany(
            Product::class,                   //related model
            'product_tag',                   // pivot table الجدول الوسيط
            'tag_id',           // F.K in pivot table for current model
            'product_id',               // F.K in pivot table for related model
            'id',                       //P.K in the current model
            'id'                        //P.K in the related model
        );
    }
}
