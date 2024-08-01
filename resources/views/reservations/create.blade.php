@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $shop->name }} の予約</h1>
        <!-- フラッシュメッセージの表示 -->
        @if (session('flash_message'))
            <div class="alert alert-success">
                {{ session('flash_message') }}
            </div>
        @endif

        <!-- バリデーションエラーメッセージの表示 -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('shops.reservations.store', $shop) }}" method="POST">
            @csrf
            <input type="hidden" name="shop_id" value="{{ $shop->id}}">
            <div class="form-group">
                <label for="reservation_date">予約日</label>
                <input type="date" id="reservation_date" name="reservation_date" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="reservation_time">予約時間</label>
                <input type="time" id="reservation_time" name="reservation_time" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="number_of_people">人数</label>
                <input type="number" id="number_of_people" name="number_of_people" class="form-control" required min="1" max="50">
            </div>

            <button type="submit" class="btn btn-primary">予約する</button>
        </form>
    </div>
@endsection