@extends('layouts.layoutMaster')

@section('title', 'Dashboard-Business Excellence')
@section('content')

@if($inquiry->isNotEmpty() && $inquiry->first()->type == 'Online')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card mb-8">
                    <div class="d-flex flex-column align-items-center">
                      <a href="{{ url('/info',['slug' => $forms->slug]) }}">
                            <img src="{{ asset('assets/img/logo/1.png') }}" class="img-fluid mb-2" alt="Image 1" style="border-radius:10px">
                        </a>
                    </div>
                </div>

                {{-- <div class="card mb-8">
                    <div class="d-flex flex-column align-items-center">
                        <img src="{{ asset('assets/img/logo/2.png') }}" class="img-fluid mb-2" alt="Image 2" style="border-radius: 10px">
                    </div>
                </div> --}}

                <div class="card mb-8">
                    <div class="d-flex flex-column align-items-center">
                      <a href="{{url('/details',['slug' => $forms->slug])}}">
                            <img src="{{ asset('assets/img/logo/3.png') }}" class="img-fluid mb-2" alt="Image 3" style="border-radius: 10px">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card mb-8">
                    <div class="d-flex flex-column align-items-center">
                      <a href="{{ url('/info',['slug' => $forms->slug]) }}">
                            <img src="{{ asset('assets/img/logo/1.png') }}" class="img-fluid mb-2" alt="Image 1" style="border-radius:10px">
                        </a>
                    </div>
                </div>

                {{-- Uncomment and use the next section if you want to display Image 2 --}}
                {{--
                <div class="card mb-8">
                    <div class="d-flex flex-column align-items-center">
                        <img src="{{ asset('assets/img/logo/2.png') }}" class="img-fluid mb-2" alt="Image 2" style="border-radius: 10px">
                    </div>
                </div>
                --}}

                <div class="card mb-8">
                    <div class="d-flex flex-column align-items-center">
                        <a href="{{url('/details',['slug' => $forms->slug])}}">
                            <img src="{{ asset('assets/img/logo/3.png') }}" class="img-fluid mb-2" alt="Image 3" style="border-radius: 10px">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

@endsection
