@extends('layouts.dashboard')

@section('title')
    Остатки складов
@endsection

@section('content')
    <h1 class="h2">Остатки складов</h1>
    <div class="row">
        <div class="col-md-12 col-lg-10 mb-3">
            <form class="form-inline">
                <div class="col-md-4 col-lg-3">
                    <select class="form-control" name="warehouse_id">
                        <option value="0">Не выбрано</option>
                        @if(isset($warehouses) && !empty($warehouses))
                            @foreach($warehouses as $warehouse)
                                <option value="{{ $warehouse->id }}" {{ $warehouse_id == $warehouse->id ? 'selected' : '' }}>{{ $warehouse->name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-md-4 col-lg-3">
                    <select class="form-control" name="product_id">
                        <option value="0">Не выбрано</option>
                        @if(isset($products) && !empty($products))
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ $product_id == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-md-4 col-lg-3">
                    <button type="submit" class="btn btn-primary">Поиск</button>
                </div>
            </form>

        </div>
    </div>
    <h3>Остатки</h3>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
            <tr>
                <th>#</th>
                <th>Склад</th>
                <th>Товар</th>
                <th>Количество</th>
                <th>Тип операции</th>
                <th>Дата</th>
            </tr>
            </thead>

            <tbody>
                @if(isset($balance) && !empty($balance))
                    @forelse($balance as $balanceItem)
                        <tr>
                            <td>{{ ++$loop->index }}</td>
                            <td>{{ $balanceItem->warehouse->name }}</td>
                            <td>{{ $balanceItem->product->name }}</td>
                            <td>{{ $balanceItem->qty }}</td>
                            <td>{{ $balanceItem->type_id == 1 ? 'Приход' : 'Расход' }}</td>
                            <td>{{ date('d.m.Y H:i:s', strtotime($balanceItem->updated_at)) }}</td>
                    @empty
                        <tr>
                            <td class="text-center" colspan="5">Данных не найдено</td>
                        </tr>
                    @endforelse
                @endif
            </tbody>
        </table>
    </div>
    <h3>Приход/Расход</h3>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
            <tr>
                <th>#</th>
                <th>Склад</th>
                <th>Товар</th>
                <th>Количество</th>
                <th>Тип операции</th>
                <th>Дата</th>
            </tr>
            </thead>

            <tbody>
                @if(isset($traffic) && !empty($traffic))
                    @forelse($traffic as $trafficItem)
                        <tr>
                            <td>{{ ++$loop->index }}</td>
                            <td>{{ $trafficItem->warehouse->name }}</td>
                            <td>{{ $trafficItem->product->name }}</td>
                            <td>{{ $trafficItem->qty }}</td>
                            <td>{{ $trafficItem->type_id == 1 ? 'Приход' : 'Расход' }}</td>
                            <td>{{ date('d.m.Y H:i:s', strtotime($trafficItem->created_at)) }}</td>
                    @empty
                        <tr>
                            <td class="text-center" colspan="5">Данных не найдено</td>
                        </tr>
                    @endforelse
                @endif
            </tbody>
        </table>
    </div>
@endsection
