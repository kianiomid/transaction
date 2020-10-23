@section('content')
 	<div class="row">
        <div class="col-md-12">
           <!-- BEGIN TABLE PORTLET-->
            {!! Form::open(array('url' => getCurrentURL(), 'files' => true))  !!}
                <div class="portlet box blue-hoki">
                	<div class="portlet-title">
					    <div class="caption">
					        <i class="fa fa-download"></i>
						    <div class="tools">
						        <a href="javascript:;" class="collapse"></a>
						        {{-- <a href="#responsive" data-toggle="modal" class="config"></a> --}}
						        {{-- <a href="javascript:;" class="remove"></a> --}}

						    </div>
						</div>
					</div>

                    <div class="portlet-body">
                        <div class="data-list table-responsive">
					        <div class=" table-responsive">
					        	<table class="table table-bordered table-striped">
					        		<tbody>
					        			<tr>
					        				<td style="vertical-align: middle;">{{ trans('language.select file') }}:</td>
					        				<td>                  
					                            <div class="fileinput fileinput-new" data-provides="fileinput">
					                                <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
					                                    <img src="/images/icon/excel128.png" alt="" />
					                                </div>
					                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;">
					                                </div>
					                                <div>
					                                    <span class="btn default btn-file">
					                                        <span class="fileinput-new">{{ trans('language.select') }}</span>
					                                        <span class="fileinput-exists">{{ trans('language.change') }}</span>
					                                        {!! Form::file('excel')  !!}
					                                    </span>
					                                    <a href="#" class="btn default fileinput-exists" data-dismiss="fileinput">
					                                        {{ trans('language.remove') }}
					                                    </a>
					                                </div>
					                            </div>
					        				</td>
					        			</tr>
					        			<tr>
					        				<td colspan="2">
					        					<input class="btn btn-primary" type="submit" value="{{ trans('language.send') }}">
					        				</td>
					        			</tr>
					        		</tbody>
					        	</table>
						    </div>	
                        </div>
                    </div>
                </div>
            {!! Form::close()  !!}
            <!-- END TABLE PORTLET-->
        </div>
    </div>  
@stop