<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Repositories\UserProfileUpdateRepository;
use App\Http\Requests\UserProfileUpdate\UpdateUserProfileUpdateRequest;

class UserProfileUpdateController extends Controller
{
    private $userProfileUpdateRepository;
    public function __construct(UserProfileUpdateRepository $userProfileUpdateRepository)
    {
        $this->userProfileUpdateRepository = $userProfileUpdateRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        return view('user_profile_update.user_profile_updates', compact(var_name: 'user'));
    }

    public function update(UpdateUserProfileUpdateRequest $request, string $id)
    {
        try {
            $user = Auth::user();
            $user_deetail = $this->userProfileUpdateRepository->save($request->only('image', 'user_id', 'name', 'email', 'password'));
            $newPassword = $request->input('password');
            $passwordChanged = $request->filled('password') && !Hash::check($newPassword, $user->password);
            if ($passwordChanged) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return response()->json([
                    'status' => 'logout',
                    'msg' => " User Profile updated you are now logged out."
                ]);
            }
            return response()->json([
                'status' => 'success',
                'msg' => 'User profile updated successfully.',
                'user_image' => isset($user_deetail) ? $user_deetail : ''
            ]);
        } catch (Exception $e) {
            Log::error('Error saving User Profile Updating: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the User Profile Updating.']);
        }
    }
}
