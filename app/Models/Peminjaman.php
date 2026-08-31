<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    // Arahkan model Peminjaman ke tabel 'borrowings'
    protected $table = 'borrowings';

    protected $fillable = [
        'user_id',
        'tool_id',
        'borrow_date', 
        'return_date', 
        'actual_return_date',
        'status',
        'fine_amount',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tool()
    {
        return $this->belongsTo(Tool::class);
    }
}