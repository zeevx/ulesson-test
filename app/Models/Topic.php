<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function subscriptions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Subscription::class);
    }
}
