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
}