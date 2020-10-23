@extends('layouts.backoffice')

@section('content')
    <section class="content-header">
        <h1>{{ $title }}</h1>
    </section>
    <div class="content">
        <div class="form-horizontal">
            @include('admin_generator.show_fields')
        </div>
    </div>
@endsection
