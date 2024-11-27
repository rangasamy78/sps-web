<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait ImageUploadTrait
{
    /**
     * Handle image upload and save it to a specified folder.
     *
     * @param \Illuminate\Http\UploadedFile $image
     * @param string $disk
     * @param string $folder
     * @return string|null
     */
    public function uploadImage(UploadedFile $image, $folder, $disk = 'public')
    {
        // Generate a unique name for the image
        $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

        // Store the image in the specified folder
        $path = $image->storeAs($folder, $filename, $disk);

        // Return the path to the image
        return $path;
    }

    /**
     * Delete an image from the specified folder.
     *
     * @param string $path
     * @param string $disk
     * @return bool
     */
    public function deleteImage($path, $disk = 'public')
    {
        return Storage::disk($disk)->delete($path);
    }
}
