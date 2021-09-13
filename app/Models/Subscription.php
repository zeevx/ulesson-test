<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function topic(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }
}
