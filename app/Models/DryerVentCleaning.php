<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DryerVentCleaning extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "dryer_vent_cleaning";
}
