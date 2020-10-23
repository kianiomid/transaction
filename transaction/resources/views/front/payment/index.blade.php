@extends('front.layout.app')

@section('content')
    <h1>شارژ حساب</h1>

    <form method="post" action="{{route('front.payment')}}">
        {{csrf_field()}}
        <div class="container">
            <label>مبلغ : </label>
            <input type="text" name="price">
            @if($errors->has('price'))
                <div class="error">{{ $errors->first('price') }}</div>
            @endif
            <label>موبایل : </label>
            <input type="text" name="mobile">
            @if($errors->has('mobile'))
                <div class="error">{{ $errors->first('mobile') }}</div>
            @endif
            <button type="submit">پرداخت</button>
        </div>
    </form>
@endsection
