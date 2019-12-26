<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{

    protected static $states = [
        1 => 'Fut',
        0 => 'Vége',
        2 => 'Géphiba',
        3 => 'Vége',
        4 => 'Megállítva',
        5 => 'Tervezett stop',
        6 => 'Szálszakadás'
    ];

    protected static $progress_bars = [
        1 => 'progress-bar progress-bar-striped active',
        0 => 'progress-bar-success progress-bar-striped',
        2 => 'progress-bar-danger progress-bar-striped',
        3 => 'progress-bar-success progress-bar-striped',
        4 => 'progress-bar-warning progress-bar-striped',
        5 => 'progress-bar-warning progress-bar-striped',
        6 => 'progress-bar-danger progress-bar-striped'
    ];

    public function getState()
    {
        return static::$states[$this->state];
    }

    public function getProgressBar()
    {
        return static::$progress_bars[$this->state];
    }

    public function design()
    {
        return $this->belongsTo(Design::class);
    }
}
