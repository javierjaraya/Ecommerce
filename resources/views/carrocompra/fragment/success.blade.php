@if ($message = Session::get('success'))
    <div class="alert alert-success">
    	<button type="button" class="close" data-dismiss="alert">&times;</button>
        <p>{{ $message }}</p>
    </div>
@endif