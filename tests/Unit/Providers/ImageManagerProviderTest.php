<?php

namespace Xefi\Faker\Images\Tests\Unit\Providers;

use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\Drivers\Imagick\Driver as ImagickDriver;
use Intervention\Image\ImageManager;
use ReflectionClass;
use ReflectionMethod;
use Xefi\Faker\Images\Exceptions\NoImageDriverException;
use Xefi\Faker\Images\Providers\ImageManagerProvider;
use Xefi\Faker\Images\Tests\Unit\TestCase;

final class ImageManagerProviderTest extends TestCase
{
    protected static function getMethod(string $methodName): ReflectionMethod
    {
        $class = new ReflectionClass(ImageManagerProvider::class);

        return $class->getMethod($methodName);
    }

    public function testSelectDriver(): void
    {
        if (!extension_loaded('gd') && !extension_loaded('imagick')) {
            $this->expectException(NoImageDriverException::class);
        }

        $method = self::getMethod('selectDriver');
        $driver = $method->invokeArgs(new ImageManagerProvider(), []);

        if (extension_loaded('gd')) {
            $this->assertInstanceOf(GdDriver::class, $driver);
        } elseif (extension_loaded('imagick')) {
            $this->assertInstanceOf(ImagickDriver::class, $driver);
        }
    }

    public function testGetImageManager() {
        if (!extension_loaded('gd') && !extension_loaded('imagick')) {
            $this->expectException(NoImageDriverException::class);
        }

        $provider = new ImageManagerProvider();
        $manager = $provider->getImageManager();

        if (extension_loaded('gd') || extension_loaded('imagick')) {
            $this->assertInstanceOf(ImageManager::class, $manager);
        }
    }
}
