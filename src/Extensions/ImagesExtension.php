<?php

namespace Xefi\Faker\Images\Extensions;

use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\Drivers\Imagick\Driver as ImagickDriver;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;
use Random\Randomizer;
use Xefi\Faker\Images\Exceptions\NoDriverException;
use Xefi\Faker\Extensions\Extension;

class ImagesExtension extends Extension
{
    private ImageManager $imageManager;

    public function __construct(Randomizer $randomizer) {
        $this->imageManager = new ImageManager($this->selectDriver());

        parent::__construct($randomizer);
    }

    /**
     * Ensure a driver is available, and select the right driver for Imagick
     *
     * @return GdDriver|ImagickDriver
     */
    private function selectDriver(): GdDriver|ImagickDriver
    {
        if (extension_loaded('gd')) {
            return new GdDriver();
        }

        if (extension_loaded('imagick')) {
            return new ImagickDriver();
        }

        throw new NoDriverException("Please activate GD or Imagick in your PHP extensions.");
    }

    /**
     * Calculate the best text size from width and height
     *
     * @param int $width
     * @param int $height
     *
     * @return int
     */
    private function calculateTextSize(int $width, int $height): int
    {
        // If the width is 10 times higher than the height, we use width to calculate the text size
        // Else we use the height
        if ($width / 10 < $height) {
            if ($width > 100)
                $size = $width / 10;
            else
                $size = $width / 5;
        } else {
            $size = $height / 5;
        }

        return round($size);
    }

    public function image($width = 300, $height = 200, $backgroundColor = '#cccccc', $textColor = '#333333'): Image
    {
        $image = $this->imageManager->create($width,$height);
        $image->fill($backgroundColor);

        $image->text($width.' x '.$height, round($width / 2), round($height / 2), function($font) use ($textColor, $width, $height) {
            $font->file(__DIR__.'/../../assets/fonts/Roboto-Regular.ttf');
            $font->size($this->calculateTextSize($width, $height));
            $font->color($textColor);
            $font->align('center');
            $font->valign('middle');
        });

        return $image;
    }

    public function imageUrl(int $width = 300, int $height = 200): string
    {
        return "https://placehold.co/".$width."x".$height;
    }
}