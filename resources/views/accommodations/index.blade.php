@extends('layouts.layout')

@section('content')

    <h2  class="container mt-4">All Accommodations</h2>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Owner</th>
                <th>Name</th>
                <th>Address</th>
                <th>Price</th>
                <th>Description</th>
                <th>Status</th>
                <th>Created At</th>
                <th>PhotoId</th>
            </tr>
        </thead>
        <tbody>
            @forelse($accommodations as $acc)
                <tr>
                    <td>{{ $acc->id }}</td>
                    <td>{{ $acc->owner->name ?? 'N/A' }}</td>
                    <td>{{ $acc->name }}</td>
                    <td>{{ $acc->address }}</td>
                    <td>{{ $acc->price }}</td>
                    <td>{{ $acc->description }}</td>
                    <td>{{ ucfirst($acc->status) }}</td>
                    <td>{{ $acc->created_at->format('Y-m-d') }}</td>
                    <td>{{ $acc->PhotoID }}</td>
                </tr>
            @empty
                <tr>

            @endforelse
        </tbody>
    </table>
@endsection