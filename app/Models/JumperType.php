<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JumperType extends Model
{
    protected static $colors = [
        'original' => 'Natúr',
        'black' => 'Fekete',
        'blue' => 'Kék',
        'yellow' => 'Sárga',
        'red' => 'Piros',
        'white' => 'Fehér',
        'green' => 'Zöld',
        'grey' => 'Szürke',
        'black-grey' => 'Fekete-szürke'
    ];

    public function transactions()
    {
        return $this->hasMany(JumperTransaction::class);
    }

    public static function getColor($color)
    {
        return static::$colors[$color];
    }
}
