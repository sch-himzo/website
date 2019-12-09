<?php

namespace App\Http\Controllers;

use App\Models\Background;
use App\Models\Design;
use App\Models\Order\Order;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Str;

class DSTController extends Controller
{
    private $control_bytes = [
        '0' => 'normal',
        '1' => 'normal',
        '2' => 'normal',
        '3' => 'normal',
        '4' => '',
        '5' => '',
        '6' => '',
        '7' => '',
        '8' => 'jump',
        '9' => 'jump',
        'A' => 'jump',
        'B' => 'jump',
        'C' => 'color',
        'D' => 'color',
        'E' => 'color',
        'F' => 'color'
    ];

    private $hex2bin = [
        '0' => '0000',
        '1' => '0001',
        '2' => '0010',
        '3' => '0011',
        '4' => '0100',
        '5' => '0101',
        '6' => '0110',
        '7' => '0111',
        '8' => '1000',
        '9' => '1001',
        'A' => '1010',
        'B' => '1011',
        'C' => '1100',
        'D' => '1101',
        'E' => '1110',
        'F' => '1111'
    ];

    private static function strToHex($string){
        $hex = '';
        for ($i=0; $i<strlen($string); $i++){
            $ord = ord($string[$i]);
            $hexCode = dechex($ord);
            $hex .= substr('0'.$hexCode, -2);
        }
        return strToUpper($hex);
    }

    public function parse(Design $design, Order $order = null)
    {
        if($design->extension()!="dst"){
            abort(400);
        }

        $contents = File::get(storage_path('app/images/uploads/designs/' . $design->image));

        $hex_contents = substr(static::strToHex($contents),1024);
        $stitches = [];
        $color_count = 0;
        $stitch_count = 0;
        $maxx = 0;
        $minx = 0;
        $miny = 0;
        $maxy = 0;
        $pos = [0,0];
        $asd = 0;
        for($i = 0; $i<strlen($hex_contents); $i=$i+6){
            $current = substr($hex_contents,$i,6);
            if(strlen($current)!=6){
                continue;
            }

            $current_array = str_split($current,1);

            $byte1 = $this->hex2bin[$current_array[0]].$this->hex2bin[$current_array[1]];
            $byte2 = $this->hex2bin[$current_array[2]].$this->hex2bin[$current_array[3]];
            $byte3 = $this->hex2bin[$current_array[4]].$this->hex2bin[$current_array[5]];


            if($this->control_bytes[$current_array[4]]=='') {
                $pos = static::posChange($pos[0], $pos[1], $byte1, $byte2, $byte3);

                $asd = 0;
            }

            if($this->control_bytes[$current_array[4]]=='color'){
                $pos = static::posChange($pos[0],$pos[1],$byte1,$byte2,$byte3);
                $color_count++;
                $asd = 0;
            }

            if($this->control_bytes[$current_array[4]]=='normal'){
                if($asd>1){
                    $stitch_count++;
                    $stitches[$color_count][] = [$pos,static::posChange($pos[0],$pos[1],$byte1,$byte2,$byte3)];
                }
                $pos = static::posChange($pos[0],$pos[1],$byte1,$byte2,$byte3);
                $asd++;
                if($pos[0]>$maxx){
                    $maxx = $pos[0];
                }
                if($pos[0]<$minx){
                    $minx = $pos[0];
                }
                if($pos[1]>$maxy){
                    $maxy = $pos[1];
                }
                if($pos[1]<$miny){
                    $miny = $pos[1];
                }
            }

            if($this->control_bytes[$current_array[4]]=='jump'){
                $pos = static::posChange($pos[0],$pos[1],$byte1,$byte2,$byte3);
                $asd = 0;
            }
        }

        $canvas_width = abs($maxx) + abs($minx) + 10;
        $canvas_height = abs($maxy) + abs($miny) + 10;



        if($color_count+1!=$design->color_count){
            $colors = $design->colors;

            foreach($colors as $color){
                $color->delete();
            }

            $design->color_count = $color_count+1;
        }

        $areacm = $canvas_width*$canvas_height/2500;

        $diameter = sqrt($areacm/pi());

        $backgrounds = Background::all();
        $current_background = $design->background;


        if($design->svg==null){
            $design->svg = static::generateSVG($design, $stitches, $canvas_width, $canvas_height, $minx, $miny);
        }
        $design->stitch_count = $stitch_count;
        $design->save();

        return view('designs.draw', [
            'stitches' => $stitches,
            'minx' => $minx,
            'miny' => $miny,
            'maxx' => $maxx,
            'maxy' => $maxy,
            'backgrounds' => $backgrounds,
            'diameter' => $diameter,
            'height' => $canvas_height,
            'width' => $canvas_width,
            'color_count' => $color_count,
            'current_background' => $current_background,
            'design' => $design,
            'order' => $order
        ]);
    }

    public static function posChange($x,$y,$byte1,$byte2,$byte3)
    {
        $div = -2;

        if($byte1[0]){
            $y = $y+1/$div;
        }
        if($byte1[1]){
            $y = $y-1/$div;
        }
        if($byte1[2]){
            $y = $y+9/$div;
        }
        if($byte1[3]){
            $y = $y-9/$div;
        }
        if($byte1[4]){
            $x = $x+9/$div;
        }
        if($byte1[5]){
            $x = $x-9/$div;
        }
        if($byte1[6]){
            $x = $x+1/$div;
        }
        if($byte1[7]){
            $x = $x-1/$div;
        }
        if($byte2[0]){
            $y = $y+3/$div;
        }
        if($byte2[1]){
            $y = $y-3/$div;
        }
        if($byte2[2]){
            $y = $y+27/$div;
        }
        if($byte2[3]){
            $y = $y-27/$div;
        }
        if($byte2[4]){
            $x = $x+27/$div;
        }
        if($byte2[5]){
            $x = $x-27/$div;
        }
        if($byte2[6]){
            $x = $x+3/$div;
        }
        if($byte2[7]){
            $x = $x-3/$div;
        }
        if($byte3[2]){
            $y = $y+81/$div;
        }
        if($byte3[3]){
            $y = $y-81/$div;
        }
        if($byte3[4]){
            $x = $x+81/$div;
        }
        if($byte3[5]){
            $x = $x-81/$div;
        }

        return [$x,$y];
    }

    public static function deleteSVG(Design $design)
    {
        $svg = $design->svg;

        if($svg == null){
            return null;
        }

        Storage::delete('public/images/svg/'.$svg);
        return null;
    }

    public function redraw(Order $order)
    {
        $dst = $order->getDST();

        if($dst==null){
            return redirect()->back();
        }

        static::deleteSVG($dst);
        $dst->svg = null;
        $dst->save();

        return redirect()->route('designs.parse', ['design' => $dst, 'order' => $order]);
    }

    public static function generateSVG(Design $design, $stitches, $width, $height, $x_offset, $y_offset)
    {
        if($design->extension()!="dst"){
            abort(400);
        }


        $view = view('designs.svg', [
            'design' => $design,
            'stitches' => $stitches,
            'x_offset' => $x_offset,
            'y_offset' => $y_offset,
            'width' => $width,
            'height' => $height
        ]);

        $svg = $view->render();

        $name = time().Str::random(16).'.svg';

        Storage::put('public/images/svg/'.$name,$svg);

        return $name;
    }

    public static function updateSVG(Design $design, $colors, $background)
    {
        $name = $design->svg;

        $file = Storage::get('public/images/svg/'.$name);

        $i = 0;
        foreach($colors as $color)
        {
            $color_pattern = "/(<g id=\"color_$i\" style=\")(stroke:rgb\([0-9]{1,3}, [0-9]{1,3}, [0-9]{1,3}\);)(\">)/";
            $replace = "$1stroke:rgb($color->red, $color->green, $color->blue);$3";
            $file = preg_replace($color_pattern,$replace,$file);
            $i++;
        }

        $background_pattern = "/(<rect width=\"[0-9\.]*\" height=\"[0-9\.]*\" style=\")fill:rgb\([0-9]{1,3}, [0-9]{1,3}, [0-9]{1,3}\);(\"><\/rect>)/";
        $background_replace = "$1fill:rgb($background->red, $background->green, $background->blue)$2";
        $file = preg_replace($background_pattern,$background_replace,$file);

        Storage::put('public/images/svg/'.$name,$file);

        return $name;
    }
}
