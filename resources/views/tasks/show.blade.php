@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $task->title }}</div>

                <div class="card-body">
                    <p>Description: {{ $task->description }}</p>
                    <p>Status: {{ ucfirst($task->status) }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
