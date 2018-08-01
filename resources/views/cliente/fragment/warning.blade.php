@if ($message = Session::get('warning'))
    <div class="alert alert-warning">
    	<button type="button" class="close" data-dismiss="alert">&times;</button>
        <p>{{ $message }}</p>
    </div>
@endif