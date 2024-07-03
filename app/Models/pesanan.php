<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'username', 
        'items', 
        'total',
        'student_name',
        'amount_given',
        'change',
        'status'
    ];

    protected $casts = [
        'items' => 'array', // Pastikan items di-cast sebagai array
    ];

     // Accessor to automatically decode the items attribute
     public function getItemsAttribute($value)
     {
         return json_decode($value, true);
     }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
