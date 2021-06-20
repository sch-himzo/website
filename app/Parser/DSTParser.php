<?php

declare(strict_types=1);

namespace App\Parser;

use App\Decoder\ControlWordDecoder;
use App\Decoder\ControlWordDecoderInterface;
use App\Entity\DST;
use App\Entity\DSTInterface;
use App\Models\Design as DesignContainer;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\File;

class DSTParser implements ParserInterface
{
    /** @var int $stitchIndicator */
    private $stitchIndicator = 0;

    /** @var ControlWordDecoderInterface $controlWordDecoder */
    private $controlWordDecoder;

    public function __construct(
        ControlWordDecoder $controlWordDecoder
    ) {
        $this->controlWordDecoder = $controlWordDecoder;
    }

    public function parse(DesignContainer $design): ?DSTInterface
    {
        $filePath = storage_path(self::UPLOADED_DESIGN_STORAGE_PATH. $design->image);

        $fileContent = File::get($filePath);

        $fileContentHex = $this->stringToHexadecimal($fileContent);

        if (substr($fileContent, 0, 2) === 'LA') {
            $newFileContent = substr($fileContent, 1024);

            $fileContentHex = $this->stringToHexadecimal($newFileContent);
        }

        $dst = new DST();

        /** @var string $command */
        foreach (str_split($fileContentHex, DSTInterface::COMMAND_LENGTH) as $command) {
            if (strlen($command) !== DSTInterface::COMMAND_LENGTH) {
                continue;
            }

            $bytes = str_split($command, DSTInterface::BYTE_LENGTH);

            foreach ($bytes as & $byte) {
                $byte = $this->hexadecimalToBinary($byte);
            }

            $this->addStitchToDSTWithControlBytes($dst, $bytes);
        }

        return $dst;
    }

    private function stringToHexadecimal(string $string): string
    {
        $hex = '';

        foreach (str_split($string) as $character) {
            $ord = ord($character);

            $hexCode = dechex($ord);

            $hex .= substr('0'.$hexCode, -2);
        }

        return strtoupper($hex);
    }

    private function hexadecimalToBinary(string $hexadecimal): string
    {
        $binary = '';

        foreach (str_split($hexadecimal) as $character) {
            if (array_key_exists(strtolower($character), self::HEXADECIMAL_BINARY_MAP)) {
                $binary .= self::HEXADECIMAL_BINARY_MAP[strtolower($character)];
            }
        }

        return $binary;
    }

    private function getStitchType(string $character): string
    {
        $lol = substr($character, 0, 1);
        $biglopl = !(boolean)substr($character, 0, 1);

        if (!(boolean)substr($character, 0, 1) && !(boolean)substr($character, 1, 1)) {
            return DSTInterface::STITCH_TYPE_NORMAL;
        }


        if (substr($character, 0, 1) && substr($character, 1, 1)) {
            return DSTInterface::STITCH_TYPE_COLOR_CHANGE;
        }

        if (substr($character, 0, 1) && !(boolean)substr($character, 1, 1) ) {
            return DSTInterface::STITCH_TYPE_JUMP;
        }

        return DSTInterface::STITCH_TYPE_OTHER;
    }

    private function getPositionChange(array $position, array $bytes): array
    {
        return $this->controlWordDecoder->decode($bytes, $position);
    }

    private function addStitchToDSTWithControlBytes(DSTInterface $dst, array $controlBytes): void
    {
        $stitchType = $this->getStitchType(substr($controlBytes[2], 0, 2));

        switch ($stitchType) {
            case DSTInterface::STITCH_TYPE_JUMP:
            {
                $this->stitchIndicator = 0;

                $dst->setCurrentPosition($this->getPositionChange(
                    $dst->getCurrentPosition(), $controlBytes
                ));

                break;
            }

            case DSTInterface::STITCH_TYPE_COLOR_CHANGE:
            {
                $this->stitchIndicator = 0;

                $dst->setCurrentPosition($this->getPositionChange(
                    $dst->getCurrentPosition(), $controlBytes
                ));

                $dst->incrementColorCount();

                break;
            }

            case DSTInterface::STITCH_TYPE_OTHER:
            case DSTInterface::STITCH_TYPE_NORMAL:
            {
                $newPosition = $this->getPositionChange($dst->getCurrentPosition(), $controlBytes);

                $this->stitchIndicator++;

                if ($this->stitchIndicator > 1) {
                    $dst->incrementStitchCount();

                    $dst->addStitchByNextPosition($newPosition);
                }

                $dst->setCurrentPosition($newPosition);


                $this->setLimits($dst, $newPosition);

                break;
            }

            default: break;
        }
    }

    private function setLimits(DSTInterface $dst, $newPosition): void
    {
        if ($dst->getMaxVerticalPosition() < $newPosition[1]) {
            $dst->setMaxVerticalPosition($newPosition[1]);
        }

        if ($dst->getMaxHorizontalPosition() < $newPosition[0]) {
            $dst->setMaxHorizontalPosition($newPosition[0]);
        }

        if ($dst->getMinVerticalPosition() > $newPosition[1]) {
            $dst->setMinVerticalPosition($newPosition[1]);
        }

        if ($dst->getMinHorizontalPosition() > $newPosition[0]) {
            $dst->setMinHorizontalPosition($newPosition[0]);
        }
    }
}
