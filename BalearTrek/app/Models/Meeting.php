<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Comment;

class Meeting extends Model
{
    protected $fillable = [
    'user_id',    // El guía
    'trek_id',    // La excursión
    'day',
    'time',
    'appDateIni', // Fecha inicio inscripciones
    'appDateEnd', // Fecha fin inscripciones
    'totalScore',
    'countScore',
];


    public function trek()
    {
      return $this->belongsTo(Trek::class);
    }
    public function comments()
    {
      return $this->hasMany(Comment::class);
    }

    public function guide()
    {
      return $this->belongsTo(User::class, 'user_id');
    }

    public function user()
    {
      return $this->belongsTo(User::class, 'user_id');
    }

    public function users()
    {
      return $this->belongsToMany(User::class);
    }

    public function calculaMitjana()
    {
      return $this->hasMany(Comment::class)->where('status', 'y')->avg('score');
    }
}
