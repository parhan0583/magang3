<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HrisDatadiriTraininguser extends Model
{
    use HasFactory;
    protected $table = 'hris_datadiris_traininguser';
    protected $fillable = [
        'role', 'jenisTraining',
    ];
    
}
