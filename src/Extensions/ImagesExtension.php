<?php

namespace Xefi\Faker\Images\Extensions;

use Intervention\Image\Image;
use Random\Randomizer;
use Xefi\Faker\Extensions\Extension;
use Xefi\Faker\Images\Providers\ImageManagerProvider;

class ImagesExtension extends Extension
{
    private ImageManagerProvider $imageManagerProvider;

    public function __construct(Randomizer $randomizer){
        $this->imageManagerProvider = new ImageManagerProvider();

        parent::__construct($randomizer);
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
        $imageManager = $this->imageManagerProvider->getImageManager();

        $image = $imageManager->create($width,$height);
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