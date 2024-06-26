@extends('home')
@section('header')
@endsection
           @section('main')
            <div class="row">
                <div class="col-md-4">
                    <div class="card border border-danger">
                        <div class="card-header shopee"><i class="bi bi-qr-code-scan"></i> Thiết bị quét mã</div>
                        <div class="card-body">
                            <h1 class="text-center">{{$data['devices']}}</h1>
                        </div>
                        <div class="card-footer text-center shopee">Tống số người/thiết bị quét mã</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border border-danger">
                        <div class="card-header shopee"><i class="bi bi-camera-video"></i> Camera</div>
                        <div class="card-body">
                            <h1 class="text-center">{{$data['cameras']}}</h1>
                        </div>
                        <div class="card-footer text-center shopee">Tống số camera kết nối</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border border-danger">
                        <div class="card-header shopee"><i class="bi bi-box-seam"></i> Hàng hóa</div>
                        <div class="card-body">
                            <h1 class="text-center">{{$data['packs']}}</h1>
                        </div>
                        <div class="card-footer text-center shopee">Tống số hàng đóng trong ngày</div>
                    </div>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-body">
                    <p class="shopeetext">{{ __('Nhật ký đóng hàng') }}</p>
                    <div class="table-responsive">
                    <table id="tbLogs" class="display border border-danger">
                        <thead class="shopee">
                            <tr>
                                <th>ID</th>
                                <th>Mã đơn hàng</th>
                                <th>Bắt đầu</th>
                                <th>Hoàn thành</th>
                                <th>Trạng thái</th>
                                <th>Video</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($packs as $item)
                            <tr>
                                <td scope="row">{{$item->id}}</td>
                                <td>{{$item->donhang}}</td>
                                <td>{{$item->created_at}}</td>
                                <td>{{$item->updated_at}}</td>
                                <td>{!!$item->status==0?"<button class='btn btn-danger'>Xong</button>":"<button class='btn btn-warning'>Đóng hàng</button>"!!}</td>
                                <td class="text-center">{!!$item->status==0?
                                    '<a href="http://'.$item->user.':'.$item->pass.'@'.$item->address.'/cgi-bin/loadfile.cgi?action=startLoad&channel=1&startTime=' . $item->created_at . '&endTime=' . $item->updated_at . '&subtype=0"><i class="bi bi-arrow-down-circle-fill shopeetext"></i></a>'
                                    :''!!}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
            @endsection
@section('footer')
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.css" />
<script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
<script>
    $(document).ready( function () {
        $('#tbLogs').DataTable();
    } );
</script>
@endsection