<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HrisDatadirisMasteruser extends Model
{
    use HasFactory;
    protected $table = 'hris_datadiris_masteruser';
    protected $fillable = [
        'nik', 'name', 'role',
    ];
}
