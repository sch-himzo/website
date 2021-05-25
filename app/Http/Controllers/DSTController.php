<?php

namespace App\Http\Controllers;

use App\Generator\GeneratorInterface;
use App\Generator\SVGGenerator;
use App\Models\Background;
use App\Models\Design;
use App\Models\Order\Order;
use App\Parser\DSTParser;
use App\Parser\ParserInterface;
use File;
use Illuminate\Support\Facades\Storage;
use Str;

class DSTController extends Controller
{
    public const DESIGN_SVG_VIEW = 'designs.svg';

    /** @var ParserInterface $dstParser */
    private static $dstParser;

    /** @var GeneratorInterface $svgGenerator */
    private static $svgGenerator;

    private static $control_bytes = [
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

    private static $hex2bin = [
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

    public function __construct(
        DSTParser $dstParser,
        SVGGenerator $svgGenerator
    ) {
        self::$dstParser = $dstParser;
        self::$svgGenerator = $svgGenerator;
    }

    public static function parseDST(Design $design)
    {
        $dst = self::$dstParser->parse($design);

        $design->svg = self::$svgGenerator->generate($design, $dst);
        $design->stitch_count = $dst->getStitchCount();
        $design->save();

        return [
            $dst->getStitches(),
            $dst->getCanvasHeight(),
            $dst->getCanvasWidth(),
            $dst->getMinHorizontalPosition(),
            $dst->getMinVerticalPosition()
        ];
    }

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

        $dst = self::$dstParser->parse($design);

        if (($colorCount = $dst->getColorCount()) !== (int)$design->color_count) {
            $colors = $design->colors;

            foreach ($colors as $color) {
                $color->delete();
            }

            $design->color_count = $colorCount;
        }

        $area = $dst->getCanvasWidth() * $dst->getCanvasHeight() / 2500;

        $diameter = sqrt($area / pi());

        $backgrounds = Background::all();
        $current_background = $design->background;

        $design->stitch_count = $dst->getStitchCount();
        $design->save();

        if($design->svg==null){
            $design->svg = self::$svgGenerator->generate($design, $dst);
        }

        return view('designs.draw', [
            'stitches' => $dst->getStitches(),
            'minx' => $dst->getMinHorizontalPosition(),
            'miny' => $dst->getMinVerticalPosition(),
            'maxx' => $dst->getMaxHorizontalPosition(),
            'maxy' => $dst->getMaxVerticalPosition(),
            'backgrounds' => $backgrounds,
            'diameter' => $diameter,
            'height' => $dst->getCanvasHeight(),
            'width' => $dst->getCanvasWidth(),
            'color_count' => $colorCount ,
            'current_background' => $current_background,
            'design' => $design,
            'order' => $order,
            'colors' => $design->getColors(),
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
            $color_pattern = "/(<g id=\"color_$i\" style=\")(stroke:\#[A-Fa-f0-9]{6};)(\">)/";
            $replace = "$1stroke:$color->red;$3";
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
