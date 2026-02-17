<?php

namespace App\Libraries;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Psy\Util\Str;

class ImageUtil
{
    public static function save(UploadedFile $file, string $directtory): string
    {
        $fileName = basename($file->getClientOriginalName(), '.' . $file->getClientOriginalExtension());
        $imageName = Str::slug($fileName . '-' . time()) . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs($directtory, $imageName, 'public');
        return Storage::url($path);
    }

    public static function remove(?string $file): void
    {
        if (!$file) {
            return;
        }

        $path = str_replace('/storage/', '', $file);
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
