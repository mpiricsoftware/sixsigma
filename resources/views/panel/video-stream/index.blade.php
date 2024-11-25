@extends('layouts/layoutMaster')

@section('title', 'Video Stream')

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
    @vite([
        'resources/js/video-stream-manage.js',
    ]);
@endsection

@section('content')
    <h4 class="mb-1">Video Stream List</h4>
    <p class="mb-6"></p>

    <!-- cards -->
    <div class="row g-6" id=stream-card>
        @if ($streams)
            @foreach ($streams as $stream)
                <div class="col-xl-3 col-lg-3 col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                              <embed type="application/x-vlc-plugin" width="100%" height="120"
                              target="rtsp://admin:admin@123@192.168.31.207:554/cam/realmonitor?channel=1&subtype=1" autoplay="yes" />
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="heading">
                                    <h6 class="mb-1">{{ $stream->name }}</h6>
                                    {{-- <a href="javascript:void(0);" data-id="{{$stream->id}}" data-bs-toggle="modal" data-bs-target="#addStreamModal" class="edit-record">
                                        <p class="mb-0">Edit Video Stream</p>
                                    </a> --}}
                                </div>
                                <div>
                                    <a href="javascript:void(0);" data-id="{{$stream->id}}" data-bs-toggle="modal" data-bs-target="#addStreamModal" class="text-secondary edit-record" title="Edit"><i class="ri-edit-box-line ri-22px"></i></a>
                                    <a href="javascript:void(0);" data-id="{{$stream->id}}" data-bs-toggle="modal" class="text-secondary delete-record" title="Delete"><i class="ri-delete-bin-7-line ri-22px"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif

        <div class="col-xl-3 col-lg-3 col-md-3">
            <div class="card h-100">
                <div class="row h-100">
                    <div class="col-5">
                        <div class="d-flex align-items-end h-100 justify-content-center">
                            <img src="{{asset('assets/img/illustrations/add-new-role-illustration.png')}}" class="img-fluid" alt="Image" width="75">
                        </div>
                    </div>
                    <div class="col-7">
                        <div class="card-body text-sm-end text-center ps-sm-0">
                            <button data-bs-target="#addStreamModal" data-bs-toggle="modal" class="btn btn-sm btn-primary mb-4 text-nowrap add-new-role">Add New Stream</button>
                            <p class="mb-0">Add new one,<br> if it doesn't exist</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- cards -->

    <div class="modal fade" id="addStreamModal" aria-hidden="true" aria-labelledby="modalStreamLabel">
        <div class="modal-dialog modal-lg modal-simple modal-add-new-stream">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body p-0">
                    <div class="text-center mb-6">
                        <h4 id="modalStreamLabel" class="title mb-2 pb-0">Add Stream</h4>
                        <p></p>
                    </div>
                    <form id="addStreamForm" class="row g-3">
                        <input type="hidden" name="id" id="id" value="">
                        <div class="col-6 mb-3">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="name" name="name" class="form-control" placeholder="Enter name" />
                                <label for="name">Name</label>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="form-floating form-floating-outline">
                                <select id="protocol" name="protocol" class="form-control" placeholder="Select Protocol">
                                    <option value="RTSP">RTSP</option>
                                </select>
                                <label for="protocol">Camera Protocol</label>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="username" name="username" class="form-control" placeholder="Enter username" />
                                <label for="username">Username</label>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-floating form-floating-outline">
                                <input type="password" id="password" name="password" class="form-control" placeholder="Enter password" />
                                <label for="password">Password</label>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="camera_ip" name="camera_ip" class="form-control" placeholder="Enter camera IP" />
                                <label for="camera_ip">Camera IP Address</label>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="port" name="port" class="form-control" placeholder="Enter port" />
                                <label for="port">Port</label>
                            </div>
                        </div>
                        <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
