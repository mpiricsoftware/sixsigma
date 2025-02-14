@php
    use Illuminate\Support\Facades\Route;
    $configData = Helper::appClasses();
    $customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/blankLayout')

@section('title', 'Register Pages')

@section('page-style')
    {{-- Page Css files --}}
    @vite('resources/assets/vendor/scss/pages/page-auth.scss')
@endsection

@section('content')
    <div class="authentication-wrapper authentication-cover">
        <!-- Logo -->
        <a href="{{ url('/login') }}" class="auth-cover-brand d-flex align-items-center gap-2">
            <span class="app-brand-logo demo">@include('_partials.macros', ['width' => 25, 'withbg' => 'var(--bs-primary)'])</span>
            <span class="app-brand-text demo text-heading fw-semibold">{{ config('variables.templateName') }}</span>
        </a>
        <!-- /Logo -->
        <div class="authentication-inner row m-0">

            <!-- /Left Text -->
            <div class="d-none d-lg-flex col-lg-7 col-xl-8 align-items-center justify-content-center p-12 pb-2">
                <img src="{{ asset('assets/img/logo/Bg-selfas.png') }}" width="120%" height="100%" alt="auth-illustration"
                    data-app-light-img="logo/Bg-selfas.png" data-app-dark-img="logo/Bg-selfas.png" />
            </div>
            <!-- /Left Text -->

            <!-- Register -->
            <div
                class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg position-relative py-sm-12 px-12 py-6">
                <div class="w-px-400 mx-auto pt-5 pt-lg-0">
                    <h4 class="mb-1">Adventure starts here 🚀</h4>
                    <p class="mb-5">Make your app management easy and fun!</p>

                    <form id="formAuthentication" class="mb-5" action="{{ route('register') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-5">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" placeholder="johndoe" autofocus
                                        value="{{ old('name') }}">
                                    <label for="firstname">First Name</label>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <span class="fw-medium">{{ $message }}</span>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-5">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="add-user-lastname" name="lastname" placeholder="johndoe" autofocus
                                        value="{{ old('lastname') }}">
                                    <label for="lastname">Last Name</label>
                                    @error('lastname')
                                        <span class="invalid-feedback" role="alert">
                                            <span class="fw-medium">{{ $message }}</span>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-floating form-floating-outline mb-5">
                                    <input type="text" class="form-control @error('company') is-invalid @enderror"
                                        id="company" name="company" placeholder="johndoe" autofocus
                                        value="{{ old('company') }}">
                                    <label for="company">Company</label>
                                    @error('company')
                                        <span class="invalid-feedback" role="alert">
                                            <span class="fw-medium">{{ $message }}</span>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                        <div class="form-floating form-floating-outline mb-5">
                            <input type="text" class="form-control @error('designation') is-invalid @enderror" id="designation"
                                name="designation"  value="{{ old('designation') }}" placeholder="Your Designation" autofocus>
                            <label for="designation">Designation</label>
                            @error('designation')
                                <span class="invalid-feedback" role="alert">
                                    <span class="fw-medium">{{ $message }}</span>
                                </span>
                            @enderror
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-floating form-floating-outline mb-5">
                            <input type="text" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" placeholder="john@example.com" value="{{ old('email') }}">
                            <label for="email">Email</label>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <span class="fw-medium">{{ $message }}</span>
                                </span>
                            @enderror
                        </div>
                      </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-floating form-floating-outline mb-5">
                              {{-- <input type="text" class="form-control @error('company_size') is-invalid @enderror"
                                  id="company_size" name="company_size" placeholder="1234567890" value="{{ old('company_size') }}">
                              <label for="company_size">Company Size</label> --}}
                              <select name="company_size" id="company_size" class="form-control" class="form-control @error('company_size') is-invalid @enderror">
                                <option value="Select Size">Select Size</option>
                                <option value="0-100">0-100</option>
                                <option value="100-500">100-500</option>
                                <option value="500-2000">500-2000</option>
                                <option value="2000+">2000+</option>
                              </select>
                              <label for="company_size">Company Size</label>
                              @error('company_size')
                                  <span class="invalid-feedback" role="alert">
                                      <span class="fw-medium">{{ $message }}</span>
                                  </span>
                              @enderror
                          </div>
                        </div>
                        <div class="col-md-6">
                        <div class="form-floating form-floating-outline mb-5">
                            <input type="text" class="form-control @error('mobileno') is-invalid @enderror"
                                id="mobileno" name="mobileno" placeholder="1234567890" value="{{ old('mobileno') }}">
                            <label for="mobileno">Mobile No</label>
                            @error('mobileno')
                                <span class="invalid-feedback" role="alert">
                                    <span class="fw-medium">{{ $message }}</span>
                                </span>
                            @enderror
                        </div>
                      </div>
                      </div>
                        {{-- <div class="form-floating form-floating-outline mb-5">
              <input type="text" class="form-control @error('company') is-invalid  @enderror" id="company" name="company" placeholder="Mpiric" value="{{old('company')}}">
              <label for="company">Company</label>
              @error('company')
                <span class="invalid-feedback" role="alert">
                  <span class="fw-medium">{{ $message }}</span>
                </span>
              @enderror
            </div> --}}
                        <div class="mb-5 form-password-toggle">
                            <div class="input-group input-group-merge @error('password') is-invalid @enderror">
                                <div class="form-floating form-floating-outline">
                                    <input type="password" id="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password" />
                                    <label for="password">Password</label>
                                </div>
                                <span class="input-group-text cursor-pointer"><i class="ri-eye-off-line"></i></span>
                            </div>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <span class="fw-medium">{{ $message }}</span>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-5 form-password-toggle">
                            <div class="input-group input-group-merge">
                                <div class="form-floating form-floating-outline">
                                    <input type="password" id="password-confirm" class="form-control"
                                        name="password_confirmation"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password" />
                                    <label for="password-confirm">Confirm Password</label>
                                </div>
                                <span class="input-group-text cursor-pointer"><i class="ri-eye-off-line"></i></span>
                            </div>
                        </div>
                        @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                            <div class="mb-5">
                                {{-- <div class="form-check mt-2 @error('terms') is-invalid @enderror">
                                    <input class="form-check-input @error('terms') is-invalid @enderror" type="checkbox"
                                        id="terms" name="terms" />
                                    <label class="form-check-label" for="terms" style="color:#2129bd">
                                        I agree to
                                        <a href="{{ route('policy.show') }}" target="_blank"
                                            style="color: #2129bd">privacy policy</a> &
                                        <a href="{{ route('terms.show') }}" target="_blank"
                                            style="color: #2129bd">terms</a>
                                    </label>
                                </div> --}}
                                <div class="form-check mt-2 @error('terms') is-invalid @enderror">
                                    <input class="form-check-input @error('terms') is-invalid @enderror" type="checkbox"
                                        id="terms" name="terms" />
                                    <label class="form-check-label" for="terms" style="color:#2129bd">
                                        I agree to
                                        <a href="#" style="color: #2129bd">privacy policy</a> &
                                        <a href="#" style="color: #2129bd">terms</a>
                                    </label>
                                </div>
                                @error('terms')
                                    <div class="invalid-feedback" role="alert">
                                        <span class="fw-medium">{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                        @endif
                        <button type="submit" class="btn btn-primary d-grid w-100"
                            style="background-color: #2129bd">Sign up</button>
                    </form>

                    <p class="text-center">
                        <span>Already have an account?</span>
                        @if (Route::has('login'))
                            <a href="{{ route('login') }}">
                                <span style="color: #2129bd">Sign in instead</span>
                            </a>
                        @endif
                    </p>

                    <div class="divider my-5">
                        <div class="divider-text">or</div>
                    </div>

                    <div class="d-flex justify-content-center gap-2">
                        {{-- <a href="javascript:;" class="btn btn-icon rounded-circle btn-text-facebook">
                          <i class="tf-icons ri-facebook-fill"></i>
                        </a> --}}
              
                        {{-- <a href="{{ route('login.twitter') }}" class="btn btn-icon rounded-circle btn-text-twitter">
                          <i class="tf-icons ri-twitter-fill"></i> --}}
                        </a>
              
                        {{-- <a href="javascript:;" class="btn btn-icon rounded-circle btn-text-github">
                          <i class="tf-icons ri-github-fill"></i>
                        </a> --}}
              
                        <a href="{{ route('login.google') }}" class="btn btn-icon rounded-circle btn-text-google-plus">
                          <i class="tf-icons ri-google-fill"></i>
                        </a>
                      </div>
                </div>
            </div>
            <!-- /Register -->
        </div>
    </div>

@endsection
