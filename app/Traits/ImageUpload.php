<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait ImageUpload
{
    public function uploadImage($file, $folder = 'products')
    {
        if (!$file) {
            return null;
        }

        // Generate clean unique name
        $fileName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
            . '-' . time()
            . '.' . $file->getClientOriginalExtension();

        return $file->storeAs($folder, $fileName, 'public');
    }


    /**
     * Delete image safely
     */
    public function deleteImage($path)
    {
        if ($path && \Storage::disk('public')->exists($path)) {
            \Storage::disk('public')->delete($path);
        }
    }
}