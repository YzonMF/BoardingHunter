@extends('layouts.admin')

@section('title', 'Room Types - ' . $site['site_name'])

@section('content')
<div style="max-width:800px; margin:20px auto; padding:0 15px;">
    <h1 class="mb-2">Room Types</h1>
    <p class="text-muted">The types owners can choose when they create a listing, and seekers can filter by. Renaming a type updates every listing that uses it.</p>

    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
    @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

    <table class="table align-middle">
        <thead><tr><th>Name</th><th style="width:110px;">Listings</th><th style="width:160px;">Actions</th></tr></thead>
        <tbody>
        @foreach($types as $type)
            <tr>
                <td>
                    <form action="{{ route('admin.room-types.update', $type->RoomTypeID) }}" method="POST" class="d-flex gap-2">
                        @csrf
                        @method('PUT')
                        <input type="text" name="name" value="{{ old('name_' . $type->RoomTypeID, $type->name) }}" maxlength="50" class="form-control form-control-sm" required>
                        <button type="submit" class="btn btn-sm btn-outline-primary">Rename</button>
                    </form>
                </td>
                <td>{{ $usage[$type->name] ?? 0 }}</td>
                <td>
                    <form action="{{ route('admin.room-types.destroy', $type->RoomTypeID) }}" method="POST"
                          onsubmit="return confirm('Delete the type {{ e($type->name) }}?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    @error('name') <div class="alert alert-danger">{{ $message }}</div> @enderror

    <form action="{{ route('admin.room-types.store') }}" method="POST" class="d-flex gap-2">
        @csrf
        <input type="text" name="name" placeholder="New type (e.g. Apartment)" maxlength="50" class="form-control" required>
        <button type="submit" class="btn btn-primary">Add type</button>
    </form>
</div>
@endsection
