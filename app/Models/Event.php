<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'date', 'time', 'venue', 'capacity', 'ticket_price', 'performer_id', 'category_id'];

    protected $dates = ['date'];
    protected $casts = [
        'date' => 'date',
        'time' => 'datetime:H:i:s',
        'ticket_price' => 'float',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function performer()
    {
        return $this->belongsTo(Performer::class);
    }

    public function performers()
    {
        return $this->belongsToMany(Performer::class, 'event_performer');
    }
}
