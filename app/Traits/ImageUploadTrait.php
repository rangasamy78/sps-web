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
     * @param string $folder
     * @param string $disk
     * @return string|null
     */
    public $baseDir = 'app';

    public function uploadImage(UploadedFile $image, $disk = 'images', $folder = null)
    {
        $extension = $image->getClientOriginalExtension();

        $filename = time() . '_' . uniqid() . '.' . $extension;

        $storagePath = $this->getStoragePath($disk, $folder);

        if (!file_exists($storagePath)) {
            mkdir($storagePath, 0755, true); // Create directory with 755 permissions
        }

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

    protected function checkImageExtension(UploadedFile $image)
    {
        $extension = $image->getClientOriginalExtension();
        if (!in_array($extension, $this->allowedExtensions)) {
            throw new InvalidArgumentException("Invalid file extension: $extension. Allowed extensions are: " . implode(', ', $this->allowedExtensions));
        }
    }

    protected function getStoragePath($disk, $folder)
    {
        switch ($disk) {
            case env("FILESYSTEM_DISK"):
                return storage_path($this->baseDir . '/' . $disk . '/' . ($folder ? $folder . '/' : ''));
        }
    }
}
