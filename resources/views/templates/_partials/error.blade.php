@if(Session::has('error'))
    <div class="alert alert-danger alert-dismissible flash-message">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-close"></i> Error, Error!!</h4>
        {{ Session::get('error') }}
    </div>
@endif