<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jenisTraining extends Model
{
    use HasFactory;

    protected $table = 'jenis_training';
    protected $fillable =['namajenis'];
}
