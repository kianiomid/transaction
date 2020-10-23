@extends('front.layout.app')

@section('content')
    <h1>تراکنش ناموفق</h1>

    <div class="container" style="background-color: #f00">
        <p>متاسفانه پرداخت شما ناموفق بود و تراکنش به درستی انجام نشده است.</p>
        <p>{{$userGatewayLog->status_code}}</p>
    </div>
@endsection
