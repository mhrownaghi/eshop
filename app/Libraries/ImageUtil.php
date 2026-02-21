<?php

namespace App\Libraries;

use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use League\Flysystem\UnableToWriteFile;
use Symfony\Component\HttpFoundation\File\Exception\UploadException;

class ImageUtil
{
    public static function save(UploadedFile $file, string $directory): string|false
    {
        $path = $file->store($directory, 'public'); 
        
        return $path ? Storage::url($path) : false;
    }   

    public static function remove(string $file): bool
    {
        if (!$file || !str_starts_with($file, '/storage/')) {
            return false;
        }

        $path = str_replace('/storage/', '', $file);
        
        if (!Storage::disk('public')->exists($path)) {
            return false;
        }
        
        return Storage::disk('public')->delete($path);
    }
}
