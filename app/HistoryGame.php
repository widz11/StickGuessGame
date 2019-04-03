<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistoryGame extends Model
{
    protected $table = 'history_game';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'player_name', 'score',
    ];
}
