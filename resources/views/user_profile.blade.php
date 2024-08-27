@extends('layouts.admin')

@section('title', 'Home Page')

@section('styles')
<link rel="stylesheet" href="{{asset('public/assets/vendor/css/pages/page-profile.css') }}" />
@endsection
@section('content')
<!-- Content -->
<div class="content-wrapper">
  <!-- Content -->

  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">User Profile /</span> Profile</h4>

    <!-- Header -->
    <div class="row">
      <div class="col-12">
        <div class="card mb-4">
          <div class="user-profile-header-banner">
            <img src="{{asset('public/assets/img/pages/profile-banner.png')}}" alt="Banner image" class="rounded-top" />
          </div>
          <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
            <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
              <img
                src="{{asset('public/assets/img/avatars/1.png')}}"
                alt="user image"
                class="d-block h-auto ms-0 ms-sm-4 rounded user-profile-img" />
            </div>
            <div class="flex-grow-1 mt-3 mt-sm-5">
              <div
                class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                <div class="user-profile-info">
                  <h4>{{$user->name}}</h4>
                  <ul
                    class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                    <li class="list-inline-item fw-medium"><i class="bx bx-pen"></i> UX Designer</li>
                    <li class="list-inline-item fw-medium"><i class="bx bx-map"></i> Vatican City</li>
                    <li class="list-inline-item fw-medium">
                      <i class="bx bx-calendar-alt"></i> Joined April 2021
                    </li>
                  </ul>
                </div>
                <a href="javascript:void(0)" class="btn btn-primary text-nowrap">
                  <i class="bx bx-user-check me-1"></i>Connected
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--/ Header -->

    <!-- Navbar pills -->
    <div class="row">
      <div class="col-md-12">
        <ul class="nav nav-pills flex-column flex-sm-row mb-4">
          <li class="nav-item">
            <a class="nav-link active" href="javascript:void(0);"><i class="bx bx-user me-1"></i> Profile</a>
          </li>
        </ul>
      </div>
    </div>
    <!--/ Navbar pills -->

    <!-- User Profile Content -->
    <div class="row">
      <div class="col-xl-4 col-lg-5 col-md-5">
        <!-- About User -->
        <div class="card mb-4">
          <div class="card-body">
            <small class="text-muted text-uppercase">About</small>
            <ul class="list-unstyled mb-4 mt-3">
              <li class="d-flex align-items-center mb-3">
                <i class="bx bx-user"></i><span class="fw-medium mx-2">Full Name:</span> <span>{{$user->name}}</span>
              </li>
              <li class="d-flex align-items-center mb-3">
                <i class="bx bx-check"></i><span class="fw-medium mx-2">Status:</span> <span>Active</span>
              </li>
              <li class="d-flex align-items-center mb-3">
                <i class="bx bx-star"></i><span class="fw-medium mx-2">Role:</span> <span>Developer</span>
              </li>
              <li class="d-flex align-items-center mb-3">
                <i class="bx bx-flag"></i><span class="fw-medium mx-2">Country:</span> <span>USA</span>
              </li>
              <li class="d-flex align-items-center mb-3">
                <i class="bx bx-detail"></i><span class="fw-medium mx-2">Languages:</span>
                <span>English</span>
              </li>
            </ul>
            <small class="text-muted text-uppercase">Contacts</small>
            <ul class="list-unstyled mb-4 mt-3">
              <li class="d-flex align-items-center mb-3">
                <i class="bx bx-phone"></i><span class="fw-medium mx-2">Contact:</span>
                <span>(123) 456-7890</span>
              </li>
              <li class="d-flex align-items-center mb-3">
                <i class="bx bx-chat"></i><span class="fw-medium mx-2">Skype:</span> <span>john.doe</span>
              </li>
              <li class="d-flex align-items-center mb-3">
                <i class="bx bx-envelope"></i><span class="fw-medium mx-2">Email:</span>
                <span>{{$user->email}}</span>
              </li>
            </ul>
            <small class="text-muted text-uppercase">Teams</small>
            <ul class="list-unstyled mt-3 mb-0">
              <li class="d-flex align-items-center mb-3">
                <i class="bx bxl-github text-primary me-2"></i>
                <div class="d-flex flex-wrap">
                  <span class="fw-medium me-2">Backend Developer</span><span>(126 Members)</span>
                </div>
              </li>
              <li class="d-flex align-items-center">
                <i class="bx bxl-react text-info me-2"></i>
                <div class="d-flex flex-wrap">
                  <span class="fw-medium me-2">React Developer</span><span>(98 Members)</span>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <!--/ User Profile Content -->
  </div>
  <!-- / Content -->



  <div class="content-backdrop fade"></div>
</div>

<!-- / Content -->
@endsection

@section('scripts')

@endsection