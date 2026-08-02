<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['medical_record_id', 'file_path', 'original_name', 'uploaded_by'])]
class Attachment extends Model
{
    public function medicalRecord()
    {
        return $this->belongsTo(MedicalRecord::class);
    }
}