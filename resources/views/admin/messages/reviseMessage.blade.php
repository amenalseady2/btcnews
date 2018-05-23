@if (Session::get('reviseStatus',false) )
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> {{ __('adminUser.operationOk') }}!</h4>
    </div>
@else
	@if (count($errors) > 0)
	    <ul>
	        @foreach ($errors->all() as $error)
	            <div class="alert alert-warning alert-dismissable">
	                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	                <h4><i class="icon fa fa-warning"></i>{{ $error }}！</h4>
	            </div>
	        @endforeach
	    </ul>
	@endif
@endif