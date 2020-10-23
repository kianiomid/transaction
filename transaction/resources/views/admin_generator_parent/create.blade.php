@extends('layouts.backoffice')

@section('content')
    <section class="content-header">
        <h1>
            <h1>
                {{ __($title, [
                    'parent'    =>  $parentObject
                ]) }}
            </h1>
        </h1>
    </section>
    <div class="content">

        @include('flash::message')
        <div class="clearfix"></div>

        {!! Form::open([
            'route' => [$modelName.'.store', $parentObject->$parentRelatedKey],
            'class' => 'form-horizontal'
        ]) !!}

        @include('admin_generator_parent.fields')

        {!! Form::close() !!}
    </div>
@endsection
