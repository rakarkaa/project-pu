@extends('layouts.app')

@section('content')
<h1 class="mt-4">Daftar Pantau Pelatihan Kepemimpinan</h1>

<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-clipboard-list me-1"></i>
        Administrasi Pelatihan
    </div>

    <div class="card-body">

        {{-- Tabs --}}
        <ul class="nav nav-tabs mb-4 flex-nowrap overflow-auto" role="tablist">
            <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab"
                        data-bs-target="#kepesertaan">
                    Kepesertaan
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab"
                        data-bs-target="#pengajar">
                    Pengajar
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab"
                        data-bs-target="#manajemen">
                    Manajemen
                </button>
            </li>
        </ul>

        {{-- Tab Content --}}
        <div class="tab-content">
            <div class="tab-pane fade show active" id="kepesertaan">
                @include('daftar-pantau.kepemimpinan.tabs.kepesertaan')
            </div>

            <div class="tab-pane fade" id="pengajar">
                @include('daftar-pantau.kepemimpinan.tabs.pengajar')
            </div>

            <div class="tab-pane fade" id="manajemen">
                @include('daftar-pantau.kepemimpinan.tabs.manajemen')
            </div>
        </div>

    </div>
</div>
@endsection
