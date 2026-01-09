@extends('layouts.app')

@section('content')

<h1 class="mt-4">Dashboard Admin</h1>

<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Dashboard</li>
</ol>

<div class="row justify-content-center">

    <!-- Card Pelatihan Kepemimpinan -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Pelatihan
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        Kepemimpinan
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-user-tie fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Card Pelatihan Fungsional -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Pelatihan
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        Fungsional
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
