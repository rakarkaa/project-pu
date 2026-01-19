@extends('layouts.app')

@section('content')
<h1 class="mt-4">Edit User</h1>

<div class="card mb-4">
    <div class="card-body">

        <form action="{{ route('users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" name="name"
                       value="{{ $user->name }}"
                       class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Role</label>
                <select name="role" class="form-select" required>
                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>
                        Admin
                    </option>
                    <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>
                        User
                    </option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="is_active" class="form-select" required>
                    <option value="1" {{ $user->is_active ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ !$user->is_active ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            <button class="btn btn-primary">
                <i class="fas fa-save"></i> Update
            </button>

            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                Kembali
            </a>

        </form>

    </div>
</div>
@endsection
