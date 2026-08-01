<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['doctor_id', 'day_of_week', 'start_time', 'end_time'])]
class Availability extends Model
{
    protected function casts(): array
    {
        return [
            'start_time' => 'datetime:H:i',
            'end_time' => 'datetime:H:i',
        ];
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
}