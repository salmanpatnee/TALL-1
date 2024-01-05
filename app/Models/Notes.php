<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notes extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'body', 'priority'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function getPriorityAttribute($value){
        return ucfirst($value);
    }

    public function getActiveAttribute($value){
        return $value ? 'Yes' : 'No';
    }

    public function scopeActive($query){
        return $query->where('active', 1);
    }
}
