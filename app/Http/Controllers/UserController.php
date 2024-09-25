<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Department;
use App\Models\Designation;
use Illuminate\Http\Request;
use App\Services\User\userService;
use Illuminate\Support\Facades\Log;
use App\Repositories\UserRepository;
use App\Http\Requests\User\{CreateUserRequest, UpdateUserRequest};

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public $userService;
    public $userRepository;

    public function __construct(UserRepository $userRepository,userService $userService)
    {
        $this->userService = $userService;
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $departments  = Department::query()->get();
        $designations = Designation::query()->get();
        return view('user.users', compact('departments','designations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(CreateUserRequest $request)
    {
        try {
            $this->userRepository->store($request->only('first_name','last_name', 'code', 'email','password','department_id', 'designation_id'));
            return response()->json(['status' => 'success', 'msg' => 'user saved successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error saving user: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the user.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = $this->userRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = $this->userRepository->findOrFail($id);
        return response()->json($model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {       
        try {
            $this->userRepository->update($request->only('first_name','last_name', 'code', 'email','password','department_id', 'designation_id'), $user->id);
            return response()->json(['status' => 'success', 'msg' => 'User updated successfully.']);
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error updating User: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while updating the User.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $user = $this->userRepository->findOrFail($id);
            if ($user) {
                $this->userRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'User deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'User not found.']);
            }
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Error deleting user: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while deleting the user.']);
        }
    }

    public function getUserDataTableList(Request $request)
    {
        return $this->userRepository->dataTable($request);
    }
    
    public function getDesignation(Request $request)
    {
        return $this->userService->getDesignation($request);
    } 
    
}
