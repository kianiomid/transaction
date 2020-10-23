@extends('front.layout.app')

@section('content')
    <h1>تراکنش موفق</h1>

    <div class="container" style="background-color: #0f0">
        <p>تراکنش با موفقیت انجام شد.</p>
        <p>{{$userGatewayLog->gateway_result}}</p>
    </div>
@endsection
