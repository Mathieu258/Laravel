<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Produit extends Model
{
    protected $fillable = [
        'nom',
        'description',
        'prix',
        'image',
        'stand_id'
    ];

    protected $casts = [
        'prix' => 'decimal:2'
    ];

    public function stand(): BelongsTo
    {
        return $this->belongsTo(Stand::class);
    }
}
