<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class task extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'category',
        'due_date',
        'priority',
        'notes',
        'tags',
        'is_completed',
    ];

    //relasi: setiap task dimiliki oleh satu user

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
