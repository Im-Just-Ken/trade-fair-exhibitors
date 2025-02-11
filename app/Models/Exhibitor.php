<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exhibitor extends Model
{
    use HasFactory;

    protected $table = 'exhibitors'; // Define table name

    protected $fillable = [
        'name',
        'country',
        'category',
        'website',
    ];
}
