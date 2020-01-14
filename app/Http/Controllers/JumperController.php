<?php

namespace App\Http\Controllers;

use App\Models\JumperType;
use Illuminate\Http\Request;

class JumperController extends Controller
{
    private static function getJumpers()
    {
        $count = [];

        $jumpers = JumperType::all();
        foreach($jumpers as $jumper) {
            $count[$jumper->color][$jumper->size] = $jumper;
        }
        $size_count = [
            'XS' => 0,
            'S' => 0,
            'M' => 0,
            'L' => 0,
            'XL' => 0,
            'XXL' => 0,
            '3XL' => 0,
            '4XL' => 0,
            '5XL' => 0
        ];

        foreach($count as $key => $color) {
            $color_count = 0;
            foreach($color as $size => $jumper) {
                $size_count[$size] += $jumper->count;
                $color_count += $jumper->count;
            }

            if($color_count==0) {
                unset($count[$key]);
            }
        }

        foreach($size_count as $size => $s_count) {
            if($size == 0) {
                foreach($count as $color) {
                    foreach($color as $s_index => $jumper) {
                        $to_delete = $s_index;
                    }
                    if(isset($to_delete)) {
                        unset($color[$to_delete]);
                    }
                }
            }
        }

        $sizes = [
            'XS','S','M','L','XL','XXL','3XL','4XL','5XL'
        ];

        $colors = [
            'original','black','blue','green','yellow','red','white'
        ];

        return [
            'jumpers' => $count,
            'size_count' => $size_count,
            'sizes' => $sizes,
            'colors' => $colors
        ];
    }

    public function index()
    {
        return view('jumpers.index', static::getJumpers());
    }

    public function edit()
    {
        return view('jumpers.edit',static::getJumpers());
    }

    public function save(Request $request)
    {
        $sizes = [
            'XS','S','M','L','XL','XXL','3XL','4XL','5XL'
        ];

        $colors = [
            'original','black','blue','green','yellow','red','white'
        ];

        foreach($sizes as $size) {
            foreach($colors as $color) {
                $value = $request->input('count_'.$color.'_'.$size);

                $type = JumperType::where('color',$color)->where('size',$size)->first();

                if($type==null) {
                    $type = new JumperType();
                    $type->color = $color;
                    $type->size = $size;
                    $type->count = $value;
                    $type->save();
                }else{
                    $type->count = $value;
                    $type->save();
                }
            }
        }

        return redirect()->back();
    }
}
