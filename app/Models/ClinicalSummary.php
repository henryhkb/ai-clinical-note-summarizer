<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClinicalSummary extends Model
{
    protected $fillable = [
        'note',
        'summary',
    ];
}
