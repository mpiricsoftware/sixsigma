@extends('layouts/layoutMaster')

@section('title', 'Dashboard - CRM')

@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
  'resources/assets/vendor/libs/apex-charts/apex-charts.scss',
  'resources/assets/vendor/libs/swiper/swiper.scss'
])
@endsection

@section('page-style')
<!-- Page -->
@vite([
  'resources/assets/vendor/scss/pages/cards-statistics.scss',
  'resources/assets/vendor/scss/pages/cards-analytics.scss'
])
@endsection

@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
  'resources/assets/vendor/libs/apex-charts/apexcharts.js',
  'resources/assets/vendor/libs/swiper/swiper.js'
  ])
@endsection



@section('content')
<div class="container my-4">
  <div class="row">
      @foreach ($forms as $form)
      <input type="hidden" name="id" value="{{$form->id}}">
          <div class="col-md-4 mb-3">
              <div class="card h-100">
                  <div class="card-body text-center">
                    <a href="{{ url('/display', ['id' => $form->id]) }}">
                      <h5 class="card-title">{{ $form->name }}</h5>
                  </a>

                  </div>
              </div>
          </div>
      @endforeach
  </div>
</div>

@endsection
