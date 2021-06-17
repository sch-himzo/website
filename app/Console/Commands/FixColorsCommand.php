<?php

namespace App\Console\Commands;

use App\Models\Color;
use Illuminate\Console\Command;

class FixColorsCommand extends Command
{
    private const SUCCESS = 0;
    private const FAILURE = 1;

    private const COLOR_WHITE_HEX = '#FFFFFF';
    private const COLOR_WHITE_CODE = '0010';

    private const COLOR_BLACK_HEX = '#000000';
    private const COLOR_BLACK_CODE = '0020';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'himzo:fix-colors';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix black and white color codes in the database.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /** @var Color $color */
        foreach (Color::all() as $color) {
            if (strtoupper($color->red) === self::COLOR_BLACK_HEX) {
                $color->code = self::COLOR_BLACK_CODE;

                $color->save();
            }

            if (strtoupper($color->red) === self::COLOR_WHITE_HEX) {
                $color->code = self::COLOR_WHITE_CODE;

                $color->save();
            }
        }

        return self::SUCCESS;
    }
}
