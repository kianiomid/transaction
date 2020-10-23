@extends('layouts.backoffice')

@section('content')
    <section class="content-header">
        <h1>{{ __($title, [
            'user'  =>  $item
        ]) }}</h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>

        {!! Form::open([
            'route' => [$modelName.'.changePassword', $item->id],
            'method' => 'post',
            'class' => 'form-horizontal'
        ]) !!}

        <div class="box box-primary">
            <div class="box-body">
                <div class="row col-sm-10">

                    @foreach($fields as $f_k => $f_v)

                        @include('admin_generator.field' , [
                            'fieldName' => $f_k,
                            'field'     =>  $f_v,
                            'formItem'  => $f_v,
                            'AGformType'  => \App\Http\Controllers\BGenerator\BaseController::NS_FORM
                        ])

                    @endforeach

                </div>

            </div>

            <div class="box-footer">
                <div class="col-sm-10">
                    <div class="col-sm-offset-2">
                        <a href="{!! route($modelName.'.index') !!}" class="btn btn-default">{{ __('generator.list') }}</a>
                        {!! Form::submit(__('generator.changePassword'), [
                            'class' => 'btn btn-primary',
                            'name'  =>  'change-password'
                        ]) !!}
                    </div>
                </div>
            </div>

        </div>

        {!! Form::close() !!}
    </div>
@endsection

@section("scripts")
    @parent
    @include("admin_generator.icheck_scripts")

    <script>

        $(document).ready(function(){
            $('#random_password_chk').on('ifChanged', function (event) {
                if (this.checked == true) {
                    $("#password").val("abcd@1234FD");
                    $("#password_confirmation").val("abcd@1234FD");
                    $("#password").attr("readonly", "readonly");
                    $("#password_confirmation").attr("readonly", "readonly");
                }else{
                    $("#password").val("");
                    $("#password_confirmation").val("");
                    $("#password").removeAttr("readonly");
                    $("#password_confirmation").removeAttr("readonly");
                }
            });
        });

    </script>

@endsection