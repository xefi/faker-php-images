<?php
namespace Xefi\Faker\Files;

use Xefi\Faker\Files\Extensions\ImagesExtension;
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