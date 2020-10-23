@extends('layouts.backoffice')

@section('content')
    <section class="content-header">
        <h1 class="admin-list-h1">Import Fish Data From Excel</h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>
        @include('flash::message')
        <div class="clearfix"></div>

        <div class="box box-primary">
            <form class="form-horizontal" method="post" action="{{ route('FishLog.import') }}" enctype="multipart/form-data">
                @csrf
                <div class="box-body">
                    <div class="form-group @if($errors->has('tank_id')) has-error @endif">
                        <div class="col-sm-3">
                            {!! Form::label('tank_id', 'Pen/Tank', [
                                'class' => 'control-label'
                            ]) !!}
                        </div>
                        <div class="col-sm-4">
                            {!! Form::select('tank_id', $tanks, $errors->isEmpty() ? '' : $input['tank_id'], [
                                'class' => 'form-control'
                            ]) !!}
                        </div>
                        <div class="col-sm-5">
                            <span class="help-block">
                                @if($errors->has('tank_id'))
                                    @foreach ($errors->get('tank_id') as $message)
                                        <p>
                                            <i class="fa fa-times-circle-o"></i>
                                            {{ $message }}
                                        </p>
                                    @endforeach
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="form-group @if($errors->has('fish_type_id')) has-error @endif">
                        <div class="col-sm-3">
                            {!! Form::label('fish_type_id', 'Fish Type', [
                                'class' => 'control-label'
                            ]) !!}
                        </div>
                        <div class="col-sm-4">
                            {!! Form::select('fish_type_id', $fishTypes, $errors->isEmpty() ? '' : $input['fish_type_id'], [
                                'class' => 'form-control'
                            ]) !!}
                        </div>
                        <div class="col-sm-5">
                            <span class="help-block">
                                @if($errors->has('fish_type_id'))
                                    @foreach ($errors->get('fish_type_id') as $message)
                                        <p>
                                            <i class="fa fa-times-circle-o"></i>
                                            {{ $message }}
                                        </p>
                                    @endforeach
                                @endif
                            </span>
                        </div>
                    </div>

                    <div class="form-group @if($errors->has('date')) has-error @endif">
                        <div class="col-sm-3">
                            {!! Form::label('date', 'Submission Date:', [
                                'class' => 'control-label'
                            ]) !!}
                        </div>
                        <div class="col-sm-4">
                            {!! Form::text('date', $errors->isEmpty() ? date('Y-m-d H:i:s') : $input['date'] , [
                                'class' => 'form-control dir-ltr'
                            ]) !!}
                        </div>
                        <div class="col-sm-5">
                            <span class="help-block">
                                @if($errors->has('date'))
                                    @foreach ($errors->get('date') as $message)
                                        <p>
                                            <i class="fa fa-times-circle-o"></i>
                                            {{ $message }}
                                        </p>
                                    @endforeach
                                @endif
                            </span>
                        </div>
                    </div>

                    <div class="form-group @if($errors->has('version')) has-error @endif">
                        <div class="col-sm-3">
                            {!! Form::label('version', 'File Version:', [
                                'class' => 'control-label'
                            ]) !!}
                        </div>
                        <div class="col-sm-4">
                            {!! Form::text('version', $errors->isEmpty() ? 'v1' : $input['version'] , [
                                'class' => 'form-control dir-ltr'
                            ]) !!}
                        </div>
                        <div class="col-sm-5">
                            <span class="help-block">
                                @if($errors->has('version'))
                                    @foreach ($errors->get('version') as $message)
                                        <p>
                                            <i class="fa fa-times-circle-o"></i>
                                            {{ $message }}
                                        </p>
                                    @endforeach
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="form-group @if($errors->has('data')) has-error @endif">
                        <div class="col-sm-3">
                            {!! Form::label('data', 'Choose File:', [
                                'class' => 'control-label'
                            ]) !!}
                        </div>
                        <div class="col-sm-4">
                            {!! Form::file('data') !!}
                        </div>
                        <div class="col-sm-5">
                            <span class="help-block">
                                @if($errors->has('data'))
                                    @foreach ($errors->get('data') as $message)
                                        <p>
                                            <i class="fa fa-times-circle-o"></i>
                                            {{ $message }}
                                        </p>
                                    @endforeach
                                @endif
                            </span>
                        </div>
                    </div>
                </div>

                <div class="box-footer">

                    <div class="col-sm-12">
                        {!! Form::submit(__('Import Data'), ['class' => 'btn btn-info', 'name' => 'save']) !!}
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection