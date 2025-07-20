<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'stand_id',
        'details_commande',
        'date_commande',
    ];

    protected $casts = [
        'details_commande' => 'array',
    ];

    public function stand()
    {
        return $this->belongsTo(Stand::class);
    }
}
