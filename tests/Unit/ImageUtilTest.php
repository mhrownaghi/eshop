<?php

namespace Tests\Unit;

use App\Libraries\ImageUtil;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ImageUtilTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_save_image_with_valid_file(): void
    {
        Storage::fake('public');
        $directory = 'photos';
        $file = UploadedFile::fake()->image('avatar.jpg');

        /**
         * @var FilesystemAdapter $disk
         */
        $disk = Storage::disk('public');

        $disk->assertMissing("$directory/{$file->hashName()}");
        $disk->assertDirectoryEmpty($directory);

        $result = ImageUtil::save($file, $directory);

        $this->assertIsString($result);
        $this->assertStringContainsString('storage', $result);
        $disk->assertExists("$directory/{$file->hashName()}");
    }

    public function test_dont_save_image_when_directory_has_not_write_permission(): void
    {
        $directory = 'not-writable';
        $file = UploadedFile::fake()->image('avatar.jpg');

        /**
         * @var FilesystemAdapter $disk
         */
        $disk = Storage::disk('public');
        $disk->assertExists($directory);


        $result = ImageUtil::save($file, $directory);

        $this->assertFalse($result);
        $disk->assertMissing("$directory/{$file->hashName()}");
    }

    public function test_remove_image(): void
    {
        $file = __DIR__.'/../../storage/app/public/test.txt';
        $path = file_put_contents($file, 'test');
        $result = ImageUtil::remove('/storage/test.txt');
        $this->assertTrue($result);
        $this->assertFileDoesNotExist($file);
    }

    public function test_remove_image_fail_when_file_not_exist(): void
    {
        $slug = fake()->slug();
        $file = __DIR__."/../../storage/app/public/{$slug}.txt";
        $this->assertFileDoesNotExist($file);
        $result = ImageUtil::remove("/storage/{$slug}.txt");
        $this->assertFalse($result);
    }

    public function test_remove_image_fail_when_url_is_empty(): void
    {
        $result = ImageUtil::remove('');
        $this->assertFalse($result);
    }

    public function test_remove_image_fail_when_url_is_invalid(): void
    {
        $result = ImageUtil::remove('/invalid/url/file.txt');
        $this->assertFalse($result);
    }

    public function test_remove_image_fail_when_directory_has_not_permission(): void
    {
        $directory = __DIR__ . '/../../storage/app/public';
        $file = "$directory/test.txt";
        $path = file_put_contents($file, 'test');
        chmod($directory, 0555);
        $result = ImageUtil::remove('/storage/test.txt');
        $this->assertFalse($result);
        $this->assertFileExists($file);

        chmod($directory, 0775);
        unlink($file);
    }
}
