<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingsModel extends Model
{
    use HasFactory;
    protected $table = 'bookings';
    protected $primaryKey = 'id';
}
