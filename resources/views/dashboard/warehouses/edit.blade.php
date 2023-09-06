@extends('layouts.dashboard')

@section('title')
    Редактирование склада
@endsection

@section('content')
    <h1 class="h2">Редактирование склада</h1>
    <form method="POST" action="{{ route('warehouses.update', ['warehouse' => $item->id]) }}">
        {{ csrf_field() }}
        @method('PUT')
        <input type="hidden" name="id" value="{{ $item->id }}">
        @if(!empty(session('successMessage')))
            <div class="row">
                <div class="col-md-12 mb-3">
                    <span class="text-success">{{ session('successMessage') }}</span>
                </div>
            </div>
        @endif

        @if(!empty(session('errorMessage')))
            <div class="row">
                <div class="col-md-12 mb-3">
                    <span class="text-success">{{ session('errorMessage') }}</span>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-md-12 mb-3">
                <label for="firstName">Название склада</label>
                <input type="text" class="form-control" id="name" name="name" required="" value="{{ $item->name }}">

                @error('name')
                    <div class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <hr class="mb-4">

        <div class="col-md-6 mb-3 ml-0 pl-0">

            <button class="btn btn-primary" type="submit">Обновить</button>
            <a class="btn btn-danger" href="{{ route('warehouses.index') }}">К списку</a>
        </div>
    </form>
@endsection
