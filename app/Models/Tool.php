<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tool extends Model
{
   
    protected $fillable = [
        'category_id',
        'name',
        'stock',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    
    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class);
    }
}