<?php

namespace Xefi\Faker\Images\Tests\Unit\Extensions;

use Intervention\Image\Image;
use PHPUnit\Framework\Attributes\RequiresPhpExtension;
use Random\Randomizer;
use Xefi\Faker\Container\Container;
use Xefi\Faker\Images\Tests\Unit\TestCase;

final class ImagesExtensionTest extends TestCase
{
    #[RequiresPhpExtension('gd')]
    public function testImageUsingGd(): void
    {
        $faker = new Container(false);

        $image = $faker->unique()->image();

        $this->assertInstanceOf(Image::class, $image);
        $this->assertEquals(300, $image->width());
        $this->assertEquals(200, $image->height());
    }

    #[RequiresPhpExtension('imagick')]

    public function testImageUsingImagick(): void
    {
        $faker = new Container(false);

        $image = $faker->unique()->image();

        $this->assertInstanceOf(Image::class, $image);
        $this->assertEquals(300, $image->width());
        $this->assertEquals(200, $image->height());
    }

    #[RequiresPhpExtension('gd')]
    public function testImageWithCustomParametersUsingGd(): void
    {
        $faker = new Container(false);
        $randomizer = new Randomizer();

        for ($i = 0; $i < 10; $i++) {
            $width = $randomizer->getInt(1, 2000);
            $height = $randomizer->getInt(1, 2000);

            $image = $faker->unique()->image($width, $height);

            $this->assertInstanceOf(Image::class, $image);
            $this->assertEquals($width, $image->width());
            $this->assertEquals($height, $image->height());
        }
    }

    #[RequiresPhpExtension('imagick')]
    public function testImageWithCustomParametersUsingImagick(): void
    {
        $faker = new Container(false);
        $randomizer = new Randomizer();

        for ($i = 0; $i < 10; $i++) {
            $width = $randomizer->getInt(1, 2000);
            $height = $randomizer->getInt(1, 2000);

            $image = $faker->unique()->image($width, $height);

            $this->assertInstanceOf(Image::class, $image);
            $this->assertEquals($width, $image->width());
            $this->assertEquals($height, $image->height());
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
