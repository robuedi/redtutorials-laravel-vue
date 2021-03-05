@if ($errors->any())
    <div >
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            @foreach ($errors->all(':message') as $message)
                {!! $message !!}
            @endforeach
        </div>
    </div>
@endif
@if(session()->has('success_msg'))
    <div >
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                {!! session('success_msg') !!}
        </div>
    </div>
@endif
