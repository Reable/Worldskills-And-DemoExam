<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlightsModel extends Model
{
    use HasFactory;
    protected $table = 'flights';
    protected $primaryKey = 'id';
}
