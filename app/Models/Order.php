<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'total_amount', 'status', 'quantity', 'stripe_session_id', 'discount_code', 'discount_code_id', 'event_id', 'merchandise_id'];

    protected $casts = [
        'total_amount' => 'decimal:2',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function merchandise()
    {
        return $this->belongsTo(Merchandise::class);
    }

    public function discountCode()
    {
        return $this->belongsTo(DiscountCode::class, 'discount_code_id');
    }
}
