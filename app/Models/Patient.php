<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'first_name',
    'middle_name',
    'last_name',
    'date_of_birth',
    'contact_number',
    'address',
    'email',
    'gender',
    'emergency_contact_name',
    'emergency_contact_relationship',
    'emergency_contact_number',
])]
class Patient extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
        ];
    }

    public function fullName(): string
    {
        return trim("{$this->first_name} {$this->middle_name} {$this->last_name}");
    }
}