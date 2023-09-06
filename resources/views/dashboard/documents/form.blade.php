@extends('layouts.dashboard')

@section('title')
    @switch($typeId)
        @case(1)
            Новый приход товара
            @break
        @case(2)
            Новый расход товара
            @break
    @endswitch
@endsection

@section('content')
    <h1 class="h2">
        @switch($typeId)
            @case(1)
                Новый приход товара
                @break
            @case(2)
                Новый расход товара
                @break
        @endswitch
    </h1>
    <form method="POST" action="{{ route('document-store') }}">
        {{ csrf_field() }}
        <input type="hidden" name="type_id" value="{{ $typeId }}">

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
                <label for="firstName">Склад</label>
                <select class="form-control" name="warehouse_id" required>
                    <option value="0">Не выбрано</option>
                    @if(isset($warehouses) && !empty($warehouses))
                        @foreach($warehouses as $warehouse)
                            <option
                                value="{{ $warehouse->id }}"
                                {{ !empty(old('warehouse_id')) && old('warehouse_id') == $warehouse->id ? 'selected' : '' }}
                            >{{ $warehouse->name }}</option>
                        @endforeach
                    @endif
                </select>

                @error('warehouse_id')
                    <div class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-md-12 mb-3">
                <label for="firstName">Товар</label>

                <select class="form-control" name="product_id" required>
                    <option value="0">Не выбрано</option>
                    @if(isset($products) && !empty($products))
                        @foreach($products as $product)
                            <option
                                value="{{ $product->id }}"
                                {{ !empty(old('product_id')) && old('product_id') == $product->id ? 'selected' : '' }}
                            >{{ $product->name }}</option>
                        @endforeach
                    @endif
                </select>

                @error('product_id')
                    <div class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-md-12 mb-3">
                <label for="price">Количество</label>
                <input type="number" class="form-control" id="qty" name="qty" required="" value="{{ old('qty') }}">

                @error('qty')
                    <div class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <hr class="mb-4">

        <div class="col-md-6 mb-3 ml-0 pl-0">

            <button class="btn btn-primary" type="submit">Добавить</button>
        </div>
    </form>
@endsection
