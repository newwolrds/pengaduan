@extends('layouts.landing.master')
<style>
    #mainNav {
        background-color: #212529 !important;
    }
</style>
@section('content')
<section class="vh-100">
    <div class="container-fluid h-custom">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-md-9 col-lg-6 col-xl-5">
          <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp"
            class="img-fluid" alt="Sample image">
        </div>
        <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
          <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
            </div>
            <div class="form-outline mb-4">
              <input type="email" id="email" name="email" class="form-control form-control-lg"
                placeholder="Enter a valid email address" />
              <label class="form-label" for="email">Email address</label>
            </div>
            <div class="form-outline mb-3">
              <input type="password" id="password" name="password" class="form-control form-control-lg"
                placeholder="Enter password" />
              <label class="form-label" for="password">Password</label>
            </div>
  
            <div class="d-flex justify-content-between align-items-center">
              <!-- Checkbox -->
              <div class="form-check mb-0">
                <input class="form-check-input me-2" type="checkbox" value="" id="form2Example3" />
                <label class="form-check-label" for="form2Example3">
                  Remember me
                </label>
              </div>
              {{-- <a href="password/reset" class="text-body">Forgot password?</a> --}}
            </div>
  
            <div class="text-center text-lg-start mt-4 pt-2">
              <button type="submit" class="btn btn-primary btn-lg"
                style="padding-left: 2.5rem; padding-right: 2.5rem;">Login</button>
              <p class="small fw-bold mt-2 pt-1 mb-0">Belum punya akun ? <a href="{{ route('register') }}" class="link-danger">Daftar disini</a></p>
            </div>
  
          </form>
        </div>
      </div>
    </div>
  </section>
@endsection
