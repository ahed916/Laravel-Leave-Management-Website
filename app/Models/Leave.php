<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Leave extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 
        'type', 
        'start_date',
        'end_date',
        'comment',
        'status',
        'admin_id',
    ];
   protected $casts = [
    'start_date' => 'date',
    'end_date' => 'date',
    ];
    public function user(){
        return $this->belongsTo(User::class,'user_id');//each leave belongs to one user
    }
    public function admin(){
        return $this->belongsTo(User::class,'admin_id');//each leave belongs to one admin who can reject or approve a request
    }
}
