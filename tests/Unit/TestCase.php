<?php

namespace Xefi\Faker\Files\Tests\Unit;

use Xefi\Faker\Container\Container;
use Xefi\Faker\Files\FakerImagesServiceProvider;

class TestCase extends \PHPUnit\Framework\TestCase
{
    protected function setUp(): void
    {
        Container::packageManifestPath('/tmp/packages.php');

        (new FakerImagesServiceProvider())->boot();
    }
}