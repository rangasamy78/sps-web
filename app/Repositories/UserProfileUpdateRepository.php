<?php

namespace App\Repositories;

use App\Models\User;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserProfileUpdateRepository
{
    use ImageUploadTrait;
    public function save(array $data)
    {
        $user = Auth::user();
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            if ($user->image && Storage::disk('public')->exists($user->image)) {
                Storage::disk('public')->delete($user->image);
            }
            $data['image'] = $this->uploadImage($data['image'], 'images');
        }
        User::query()
            ->findOrFail($data['user_id'])
            ->update($data);
        return $data['image'];
    }
}
