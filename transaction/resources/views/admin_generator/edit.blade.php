@extends('layouts.backoffice')

@section('content')
    <section class="content-header">
        <h1>
            {{ __($title, [
                'item' => $item
            ]) }}
        </h1>
   </section>

   <div class="content">
       @include('flash::message')
       <div class="clearfix"></div>

       {!! Form::model($item, [
            'route' => [$modelName.'.update', $item->id],
            'method' => 'patch',
            'class' => 'form-horizontal'
       ]) !!}

            @include('admin_generator.fields')

       {!! Form::close() !!}
   </div>
@endsection