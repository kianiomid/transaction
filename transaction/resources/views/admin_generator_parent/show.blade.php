@extends('layouts.backoffice')

@section('content')
    <section class="content-header">
        <h1>{{ __($title, [
            'parent'    =>  $parentObject
        ]) }}</h1>
    </section>
    <div class="content">
        <div class="form-horizontal">
            @include('admin_generator_parent.show_fields')
        </div>
    </div>
@endsection
