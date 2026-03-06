<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Performer extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'bio', 'image', 'spotify_id', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_performer');
    }
}
