<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class URL extends Model
{
    use HasFactory;

    /**
     * The table name.
     *
     * @var string<int, string>
     */

    protected $table = 'urls';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'redirect_to',
        'custom_slug',
    ];
}
