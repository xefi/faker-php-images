<?php

namespace Xefi\Faker\Images\Tests\Unit\Extensions;

use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\Drivers\Imagick\Driver as ImagickDriver;
use Intervention\Image\Image;
use Random\Randomizer;
use ReflectionClass;
use ReflectionMethod;
use Xefi\Faker\Container\Container;
use Xefi\Faker\Images\Exceptions\NoDriverException;
use Xefi\Faker\Images\Extensions\ImagesExtension;
use Xefi\Faker\Images\Tests\Unit\TestCase;

final class ImagesExtensionTest extends TestCase
{
    protected static function getMethod(string $methodName): ReflectionMethod
    {
        $class = new ReflectionClass(ImagesExtension::class);
        return $class->getMethod($methodName);
    }

    public function testSelectDriver(): void
    {
        if (!extension_loaded('gd') && !extension_loaded('imagick')) {
            $this->expectException(NoDriverException::class);
        }

        $method = self::getMethod('selectDriver');
        $driver = $method->invokeArgs(new ImagesExtension(new Randomizer()), []);

        if (extension_loaded('gd')) {
            $this->assertInstanceOf(GdDriver::class, $driver);
        } elseif (extension_loaded('imagick')) {
            $this->assertInstanceOf(ImagickDriver::class, $driver);
        }
    }

    public function testImage(): void
    {
        $faker = new Container(false);

        if (!extension_loaded('gd') && !extension_loaded('imagick')) {
            $this->expectException(NoDriverException::class);
        }

        $image = $faker->unique()->image();

        if (extension_loaded('gd') || extension_loaded('imagick')) {
            $this->assertInstanceOf(Image::class, $image);
            $this->assertEquals(300, $image->width());
            $this->assertEquals(200, $image->height());
        }
    }

    public function testImageWithCustomParameters(): void
    {
        $faker = new Container(false);
        $randomizer = new Randomizer();

        for ($i = 0; $i < 10; $i++) {
            $width = $randomizer->getInt(1, 2000);
            $height = $randomizer->getInt(1, 2000);

            if (!extension_loaded('gd') && !extension_loaded('imagick')) {
                $this->expectException(NoDriverException::class);
            }

            $image = $faker->unique()->image($width, $height);

            if (extension_loaded('gd') || extension_loaded('imagick')) {
                $this->assertInstanceOf(Image::class, $image);
                $this->assertEquals($width, $image->width());
                $this->assertEquals($height, $image->height());
            }
        }
    }

    public function testImageUrl(): void
    {
        $faker = new Container(false);

        $url = $faker->unique()->imageUrl();

        $this->assertEquals("https://placehold.co/300x200", $url);
    }

    public function testImageUrlWithCustomValues(): void
    {
        $faker = new Container(false);
        $randomizer = new Randomizer();

        for ($i = 0; $i < 100; $i++) {
            $width = $randomizer->getInt(1, 2000);
            $height = $randomizer->getInt(1, 2000);

            $url = $faker->unique()->imageUrl($width, $height);

            $this->assertEquals("https://placehold.co/" . $width . "x" . $height, $url);
        }
    }
}
