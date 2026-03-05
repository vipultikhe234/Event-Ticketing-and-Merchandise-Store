<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Performer extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'bio', 'image', 'spotify_id'];

    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_performer', 'performer_id', 'event_id');
    }
}
