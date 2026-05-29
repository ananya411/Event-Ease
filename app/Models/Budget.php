<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Budget extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'budgets';

    protected $fillable = [
        'event_id',
        'category',
        'amount',
        'expense_date',
        'notes'
    ];

    protected $casts = [
        'amount'       => 'float',
        'expense_date' => 'string',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}