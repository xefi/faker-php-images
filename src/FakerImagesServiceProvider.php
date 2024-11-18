<?php
namespace Xefi\Faker\Images;

use Xefi\Faker\Images\Extensions\ImagesExtension;
use Xefi\Faker\Providers\Provider;

class FakerImagesServiceProvider extends Provider
{
    public function boot(): void
    {
        $this->extensions([
            ImagesExtension::class
        ]);
    }

}