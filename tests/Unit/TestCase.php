<?php

namespace Xefi\Faker\Images\Tests\Unit;

use Xefi\Faker\Container\Container;
use Xefi\Faker\Images\FakerImagesServiceProvider;

class TestCase extends \PHPUnit\Framework\TestCase
{
    protected function setUp(): void
    {
        Container::packageManifestPath('/tmp/packages.php');

        (new FakerImagesServiceProvider())->boot();
    }

    protected function needImageDriver(): void
    {
        if (!extension_loaded('gd') && !extension_loaded('imagick')) {
            $this->markTestSkipped('GD or Imagick extension is required.');
        }
    }
}