@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-3">
            <div id="menu" class="btn-group-vertical" role="group" aria-label="Vertical button group" style="display:block !important;">
                <a href="{{ route('home') }}" class="btn btn-light text-start"><i class="bi bi-menu-button-wide"></i> Bảng điều khiển</a>
                <a href="{{ route('scan') }}" class="btn btn-light text-start"><i class="bi bi-phone-vibrate"></i> Quản lý quét mã</a>
                <a href="{{ route('camera') }}" class="btn btn-light text-start"><i class="bi bi-camera-video"></i> Quản lý camera</a>
            </div>
        </div>
        <div class="col-md-9">
            @yield('main')
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
$(function(){
    var current = location.pathname;
    $('#menu a').each(function(){
        var $this = $(this);
        // if the current path is like this link, make it active
        if($this.attr('href').indexOf(current) !== -1){
            $this.removeClass('btn-light')
            $this.addClass('shopee');
        }
    })
})
</script>
@endsection