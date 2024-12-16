@extends('layouts/layoutMaster')

@section('title', 'Inputs')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body:not(.modal-open) .select2-container--open{
            z-index:99
        }
    </style>
    <!-- Vendor Styles -->
    @section('vendor-style')
    @vite([
        'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
        'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
        'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
        'resources/assets/vendor/libs/select2/select2.scss',
        'resources/assets/vendor/libs/@form-validation/form-validation.scss',
        'resources/assets/vendor/libs/animate-css/animate.scss',
        'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'
    ])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
    @vite([
        'resources/assets/vendor/libs/moment/moment.js',
        'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
        'resources/assets/vendor/libs/select2/select2.js',
        'resources/assets/vendor/libs/@form-validation/popular.js',
        'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
        'resources/assets/vendor/libs/@form-validation/auto-focus.js',
        'resources/assets/vendor/libs/cleavejs/cleave.js',
        'resources/assets/vendor/libs/cleavejs/cleave-phone.js',
        'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'
    ])
@endsection
@section('page-script')
    @vite('resources\js\stages.js')
@endsection
@section('content')
    <style>
        .form-section { display: none; }
        .form-section.active { display: block; }
    </style>

<div class="container my-5">
    <div class="btn-group" role="group" aria-label="Form Options">
        <button type="button" class="btn btn-primary" data-target="form-a">Option A</button>
        <button type="button" class="btn btn-primary" data-target="form-b">Option B</button>
        <button type="button" class="btn btn-primary" data-target="form-c">Option C</button>
        <button type="button" class="btn btn-primary" data-target="form-d">Option D</button>
        <button type="button" class="btn btn-primary" data-target="form-e">Option E</button>
    </div>

    <div class="forms mt-4">
        <div class="form-section" id="form-a">
            <h2>Form A</h2>
            <form action="" method="POST">
                @csrf
                <input type="text" class="form-control mb-3" name="answer_a" placeholder="Your Answer for Form A">
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
        <div class="form-section" id="form-b">
            <h2>Form B</h2>
            <form action="" method="POST">
                @csrf
                <input type="text" class="form-control mb-3" name="answer_b" placeholder="Your Answer for Form B">
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
        <div class="form-section" id="form-c">
            <h2>Form C</h2>
            <form action="" method="POST">
                @csrf
                <input type="text" class="form-control mb-3" name="answer_c" placeholder="Your Answer for Form C">
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
        <div class="form-section" id="form-d">
            <h2>Form D</h2>
            <form action="" method="POST">
                @csrf
                <input type="text" class="form-control mb-3" name="answer_d" placeholder="Your Answer for Form D">
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
        <div class="form-section" id="form-e">
            <h2>Form E</h2>
            <form action="" method="POST">
                @csrf
                <input type="text" class="form-control mb-3" name="answer_e" placeholder="Your Answer for Form E">
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

</div>

@endsection
