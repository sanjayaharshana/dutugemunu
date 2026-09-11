<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait HandlesUploads
{
    /**
     * Store an uploaded image on the public disk and return a web path
     * (relative to the site root, usable with asset()).
     */
    protected function storeImage(UploadedFile $file, string $folder): string
    {
        $name = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $name = ($name ?: 'image') . '-' . Str::lower(Str::random(6)) . '.' . strtolower($file->getClientOriginalExtension() ?: 'jpg');

        $path = $file->storeAs($folder, $name, 'public');

        return 'storage/' . $path;
    }

    /**
     * Delete an image that we previously stored (only touches storage/ uploads).
     */
    protected function deleteImage(?string $webPath): void
    {
        if ($webPath && str_starts_with($webPath, 'storage/')) {
            Storage::disk('public')->delete(Str::after($webPath, 'storage/'));
        }
    }
}
