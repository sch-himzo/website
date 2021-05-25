<?php

declare(strict_types=1);

namespace App\Generator;

use App\Entity\DSTInterface;
use App\Http\Controllers\DSTController;
use App\Models\Design;
use Str;
use Symfony\Component\HttpFoundation\Response;

class SVGGenerator implements GeneratorInterface
{
    public function generate(
        Design $design,
        DSTInterface $dst
    ): string
    {
        $view = view(
            DSTController::DESIGN_SVG_VIEW,
            [
                'design' => $design,
                'stitches' => $dst->getStitches(),
                'x_offset' => $dst->getMinHorizontalPosition(),
                'y_offset' => $dst->getMinVerticalPosition(),
                'width' => $dst->getCanvasWidth(),
                'height' => $dst->getCanvasHeight(),
                'colors' => $design->getColors(),
            ]
        );

        try {
            $svg = $view->render();
        } catch (\Throwable $exception) {
            abort(Response::HTTP_BAD_REQUEST, $exception->getMessage());
        }

        $name = sprintf('%s%s.svg', time(), Str::random(16));

        \Storage::put(sprintf('public/images/svg/%s', $name), $svg);

        return $name;
    }
}
