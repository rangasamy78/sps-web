<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use InvalidArgumentException;

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
    public function uploadImage(UploadedFile $image, $disk = 'images', $folder = null)
    {
        // Get the file extension
        $extension = $image->getClientOriginalExtension();

        // Generate a unique filename
        $filename = time() . '_' . uniqid() . '.' . $extension;

        // Ensure the folder exists (use Storage's built-in method)
        if ($folder) {
            if (!Storage::disk($disk)->exists($folder)) {
                Storage::disk($disk)->makeDirectory($folder); // Creates the folder if it doesn't exist
            }
        }

        // Store the file and return the path
        $path = $image->storeAs($folder, $filename, $disk);

        return $path;
    }

    /**
     * Delete an image from the specified folder.
     *
     * @param string $path
     * @param string $disk
     * @return bool
     */
    public function deleteImage($path, $disk = 'images')
    {
        return Storage::disk($disk)->delete($path);
    }

    /**
     * Check if the image extension is allowed.
     *
     * @param \Illuminate\Http\UploadedFile $image
     * @return void
     */
    protected function checkImageExtension(UploadedFile $image)
    {
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif']; // Define allowed extensions
        $extension = $image->getClientOriginalExtension();

        if (!in_array($extension, $allowedExtensions)) {
            throw new InvalidArgumentException("Invalid file extension: $extension. Allowed extensions are: " . implode(', ', $allowedExtensions));
        }
    }
}
