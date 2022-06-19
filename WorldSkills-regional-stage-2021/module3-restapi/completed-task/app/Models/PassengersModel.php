<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PassengersModel extends Model
{
    use HasFactory;
    protected $table = 'passengers';
    protected $primaryKey = 'id';
}
