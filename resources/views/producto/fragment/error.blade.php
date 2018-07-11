@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Ups!</strong> Tienes algunos problemas en tus datos<br><br>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif