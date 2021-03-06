<?php

use Intervention\Image\Image;

class ImageCacheFromImageTest extends PHPUnit_Framework_Testcase
{
    public function tearDown()
    {
        $this->emptyCacheDirectory();
    }

    public function emptyCacheDirectory()
    {
        $files = glob('storage/cache/*');

        foreach ($files as $file) {

            if (is_file($file)) {

                unlink($file);
            }
        }
    }

    public function testStaticCall()
    {
        $img = Image::cache();
        $this->assertInternalType('string', $img);
    }

    public function testStaticCallReturnObject()
    {
        $img = Image::cache(null, 5, true);

        // must be empty \Intervention\Image\Image
        $this->assertInstanceOf('Intervention\Image\Image', $img);
        $this->assertInternalType('int', $img->width);
        $this->assertInternalType('int', $img->height);
        $this->assertEquals($img->width, 1);
        $this->assertEquals($img->height, 1);
    }

    public function testStaticCallWithCallback()
    {
        $img = Image::cache(function($image) {
            return $image->make('public/test.jpg')->resize(320, 200)->greyscale();
        });

        // must be empty \Intervention\Image\Image
        $this->assertInternalType('string', $img);
    }

    public function testStaticCallWithCallbackReturnObject()
    {
        $img = Image::cache(function($image) {
            return $image->make('public/test.jpg')->resize(320, 200)->greyscale();
        }, 5, true);

        // must be empty \Intervention\Image\Image
        $this->assertInstanceOf('Intervention\Image\Image', $img);
        $this->assertInternalType('int', $img->width);
        $this->assertInternalType('int', $img->height);
        $this->assertEquals($img->width, 320);
        $this->assertEquals($img->height, 200);
    }
}
