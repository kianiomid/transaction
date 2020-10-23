@extends('layouts.backoffice')

@section('content')
    <section class="content-header">
        <h1>
            <h1>
                {{ __($title) }}
            </h1>
        </h1>
    </section>
    <div class="content">

        @include('flash::message')
        <div class="clearfix"></div>

        {!! Form::open([
            'route' => $modelName.'.store',
            'class' => 'form-horizontal'
        ]) !!}

        @include('admin_generator.fields')

        {!! Form::close() !!}
    </div>
@endsection
