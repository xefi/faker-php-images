<?php

namespace Xefi\Faker\Images\Tests\Unit\Providers;

use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\Drivers\Imagick\Driver as ImagickDriver;
use Intervention\Image\ImageManager;
use PHPUnit\Framework\Attributes\RequiresPhpExtension;
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

    public function testSelectDriverWithoutExtension(): void
    {
        $this->needNoImageDriver();

        $this->expectException(NoImageDriverException::class);

        $method = self::getMethod('selectDriver');
        $method->invokeArgs(new ImageManagerProvider(), []);
    }

    #[RequiresPhpExtension('gd')]
    public function testSelectDriverWithGd(): void
    {
        $method = self::getMethod('selectDriver');
        $driver = $method->invokeArgs(new ImageManagerProvider(), []);

        $this->assertInstanceOf(GdDriver::class, $driver);
    }

    #[RequiresPhpExtension('imagick')]
    public function testSelectDriverWithImagick(): void
    {
        $method = self::getMethod('selectDriver');
        $driver = $method->invokeArgs(new ImageManagerProvider(), []);

        $this->assertInstanceOf(ImagickDriver::class, $driver);
    }

    public function testGetImageManagerWithoutDriver() {
        $this->needNoImageDriver();

        $this->expectException(NoImageDriverException::class);

        $provider = new ImageManagerProvider();
        $provider->getImageManager();
    }

    public function testGetImageManager() {
        $this->needImageDriver();

        $provider = new ImageManagerProvider();
        $manager = $provider->getImageManager();

        $this->assertInstanceOf(ImageManager::class, $manager);
    }
}
