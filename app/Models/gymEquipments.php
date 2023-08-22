<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class gymEquipments extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'category', 'image'];
}
