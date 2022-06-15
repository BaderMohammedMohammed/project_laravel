<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Filmes extends Model
{
    use HasFactory;
    protected $table = 'filmes';

    public function category(){
        return $this->belongsTo(Categories::class , 'category_id');
    }
}
