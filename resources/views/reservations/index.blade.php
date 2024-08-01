@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>予約一覧</h1>
        
        <!-- フラッシュメッセージの表示 -->
        @if (session('flash_message'))
            <div class="alert alert-success">
                {{ session('flash_message') }}
            </div>
        @endif

        <!-- エラーメッセージの表示 -->
        @if (session('error_message'))
            <div class="alert alert-danger">
                {{ session('error_message') }}
            </div>
        @endif

        @if($reservations->isEmpty())
            <p>現在、予約はありません。</p>
        @else
            <table class="table">
                <head>
                    <tr>
                        <th>店名</th>
                        <th>予約日時</th>
                        <th>人数</th>
                        <th>操作</th>
                    </tr>
                </head>
                <body>
                    @foreach($reservations as $reservation)
                        <tr>
                            <td>{{ $reservation->shop->name }}</td>
                            <td>{{ $reservation->reserved_datetime }}</td>
                            <td>{{ $reservation->number_of_people }}</td>
                            <td>
                                <form action="{{ route('shops.reservations.destroy', ['shop' => $reservation->shop, 'reservation' => $reservation]) }}" method="POST" onsubmit="return confirm('本当にキャンセルしますか？');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">キャンセル</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </body>
            </table>
        @endif

        <a href="{{ route('shops.index') }}" class="btn btn-secondary">お店一覧に戻る</a>
    </div>
@endsection