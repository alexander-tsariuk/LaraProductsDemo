@extends('layouts.dashboard')

@section('title')
    Склады
@endsection

@section('content')
    <h1 class="h2">Склады</h1>
    <div class="row">
        <div class="col-md-12 col-lg-10 mb-3">
            <a href="{{ route('warehouses.create') }}" class="btn btn-primary">Добавить</a>
        </div>
    </div>

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

    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
            <tr>
                <th>#</th>
                <th>Название склада</th>
                <th>Создано</th>
                <th>Изменено</th>
                <th>Действия</th>
            </tr>
            </thead>

            <tbody>
                @forelse($items as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ date('d.m.Y H:i:s', strtotime($item->created_at)) }}</td>
                        <td>{{ date('d.m.Y H:i:s', strtotime($item->updated_at)) }}</td>
                        <td>
                            <a href="{{ route('warehouses.edit', ['warehouse' => $item->id]) }}">Редактировать</a>
                            <form method="post" action="{{ route('warehouses.destroy', ['warehouse' => $item->id]) }}" id="delete-row-{{ $item->id }}">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}

                                <a href="javascript:{}" onclick="document.getElementById('delete-row-{{$item->id}}').submit();">Удалить</a>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="5">Ни одного склада не было добавлено</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $items->links() }}

    </div>
@endsection
