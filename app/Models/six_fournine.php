<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class six_fournine extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'id_string',
        'super_admin',
        'admin',
        'users',
        'draw_date',
        'winning_number_1',
        'winning_number_2',
        'winning_number_3',
        'winning_number_4',
        'winning_number_5',
        'winning_number_6',
        'winning_number_bonus',
        'ball_color',
        'gold_ball_win_num',
        'gb_province_winner',
        'extra',
        'soft_Delete'
    ];
}
