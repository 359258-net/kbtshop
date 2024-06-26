@extends('layouts.app')
@section('header')
@endsection
           @section('content')
           <div class="row justify-content-center">
                <div class="col-sm-3">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="text-center">{{$ten}}</h4>
                            <div id="qrcode" class="text-center"></div>
                            <h4 class="text-center">{{$id}}</h4>
                        </div>
                    </div>
                </div>
            </div>
            @endsection
@section('footer')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script type="text/javascript" src="{{ asset('js/jquery.qrcode.min.js') }}"></script>
<script>
    $(document).ready( function () {
        $('#qrcode').qrcode('{"id":"{{$id}}","host":"{{env("APPBASE_URL")}}"}');
    });
</script>
@endsection