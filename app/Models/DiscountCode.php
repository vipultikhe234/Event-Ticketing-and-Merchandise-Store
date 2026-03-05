<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountCode extends Model
{
    use HasFactory;
    protected $fillable = ['code', 'percentage', 'usage_limit', 'used_count', 'expires_at', 'single_use'];

    protected $dates = ['expires_at'];

    public function usable()
    {
        if ($this->expires_at && $this->expires_at->isPast()) return false;
        if ($this->usage_limit !== null && $this->used_count >= $this->usage_limit) return false;
        return true;
    }
}
