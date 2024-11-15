<?php

namespace Xefi\Faker\Images\Providers;

use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\Drivers\Imagick\Driver as ImagickDriver;
use Intervention\Image\ImageManager;
use Xefi\Faker\Images\Exceptions\NoImageDriverException;

class ImageManagerProvider
{
    private ?ImageManager $imageManager = null;

    public function getImageManager(): ImageManager
    {
        if ($this->imageManager === null) {
            $this->imageManager = new ImageManager(self::selectDriver());
        }

        return $this->imageManager;
    }

    /**
     * Ensure a driver is available, and select the right driver for Imagick
     *
     * @return GdDriver|ImagickDriver
     */
    static private function selectDriver(): GdDriver|ImagickDriver
    {
        if (extension_loaded('gd')) {
            return new GdDriver();
        }

        if (extension_loaded('imagick')) {
            return new ImagickDriver();
        }

        throw new NoImageDriverException('Please activate GD or Imagick in your PHP extensions.');
    }
}