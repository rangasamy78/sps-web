@extends('layouts.admin')

@section('title', '')

@section('styles')
@endsection
@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Account Settings /</span> Account</h4>
    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
                <li class="nav-item">
                    <a class="nav-link active" href="javascript:void(0);"><i class="bx bx-user me-1"></i> Account</a>
                </li>
            </ul>
            <div class="card mb-4 w-60">
                <h5 class="card-header">Profile Details</h5>
                <!-- Account -->
                <form id="userProfileUpdateForm" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                            <img
                                src="{{ $user->image ? asset('storage/app/public/' . $user->image) : asset('public/assets/img/avatars/1.png') }}"
                                alt="user-avatar"
                                class="d-block rounded"
                                height="100"
                                width="100"
                                id="uploadedAvatar" />
                            <div class="button-wrapper">
                                <label for="image" class="btn btn-primary me-2 mb-4" tabindex="0">
                                    <span class="d-none d-sm-block">Upload new photo</span>
                                    <i class="bx bx-upload d-block d-sm-none"></i>
                                    <input
                                        type="file"
                                        id="image"
                                        name="image"
                                        class="account-file-input"
                                        hidden
                                        accept="image/png, image/jpeg,image/jpg" />
                                </label>
                                <button type="button" class="btn btn-label-secondary account-image-reset mb-4" hidden>
                                    <i class="bx bx-reset d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Reset</span>
                                </button>
                                <p class="text-muted mb-0">Allowed JPG, GIF,JPEG or PNG. Max size of 1024K</p>
                                <span class="text-danger error-text image_error"></span>
                            </div>
                        </div>
                    </div>
                    <hr class="my-0" />
                    <div class="card-body">

                        <div class="row">
                            <input
                                class="form-control"
                                type="text"
                                id="user_id"
                                name="user_id"
                                hidden
                                value="{{ $user->id }}"
                                autofocus />
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="name" class="form-label">Name</label>
                                <input
                                    class="form-control"
                                    type="text"
                                    id="name"
                                    name="name"
                                    value="{{ $user->name }}"
                                    autofocus placeholder="Enter Name" />
                                <span class="text-danger error-text name_error"></span>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="email" class="form-label">E-mail</label>
                                <input
                                    class="form-control"
                                    type="text"
                                    id="email"
                                    name="email"
                                    value="{{ $user->email }}"
                                    placeholder="Enter Password" readonly />
                                <span class="text-danger error-text email_error"></span>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="password" class="form-label">New Password</label>
                                <input
                                    class="form-control"
                                    type="password"
                                    id="password"
                                    name="password"
                                    value="" placeholder="Enter New Password" />
                                <span class="text-danger error-text password_error"></span>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="password_confirmation" class="form-label">Conform Password</label>
                                <input
                                    class="form-control"
                                    type="password"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    value="" placeholder="Enter Conform Password" />
                                <span class="text-danger error-text password_confirmation_error"></span>
                            </div>

                        </div>
                        <div class="mt-2 pb-3 float-end">
                            <button type="submit" class="btn btn-primary me-2" name="savedata" id="savedata">Save changes</button>
                            <button type="button" class="btn btn-label-secondary cancel-button" id="cancelButton">Cancel</button>
                        </div>
                </form>
            </div>
            <!-- /Account -->

        </div>

    </div>
</div>
</div>

<!-- / Content -->
@endsection

@section('scripts')
@include('user_profile_update.__script')
@endsection