@extends('home')
@section('header')
@endsection
           @section('main')
            <div class="card">

                <div class="card-body">
                    <p class="shopeetext">{{ __('Quản lý điểm đóng hàng') }}</p>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#NewCCTV">
                        Thêm mới
                    </button>
                    <div class="table-responsive">
                    <table id="tbScans" class="display border border-danger">
                        <thead class="shopee">
                            <tr>
                                <th>ID</th>
                                <th>Tên</th>
                                <th>Ghi hình</th>
                                <th>Kênh</th>
                                <th>License</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($scans as $item)
                            <tr>
                                <td scope="row">{{$item->id}}</td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->cctv->name}}</td>
                                <td>{{$item->channel}}</td>
                                <td>{{$item->lic}}</td>
                                <td><i class="bi bi-qr-code-scan shopeetext" onclick="qr('{{$item->id}}')" data-bs-toggle="modal" data-bs-target="#QRCode"></i></td>
                                <td></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
            <!-- CCTV -->
            <div class="modal fade" id="NewCCTV" tabindex="-1" aria-labelledby="NewCCTVLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form class="modal-content" method="POST">
                        @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5 shopeetext" id="NewCCTVLabel">Thêm mới</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="txtID" class="form-label">ID</label>
                            <input type="text" class="form-control" id="txtID" name="txtID" placeholder="f8a6c00f-69c8-482b-b8f0-e90f88e5aa41" required>
                        </div>
                        <div class="mb-3">
                            <label for="txtTen" class="form-label">Tên khu vực</label>
                            <input type="text" class="form-control" id="txtTen" name="txtTen" placeholder="KBT-01" required>
                        </div>
                        <div class="mb-3">
                            <label for="txtCamera" class="form-label">Hệ thống Camera</label>
                            <select name="txtCamera" class="form-select" required>
                                @foreach ($cameras as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="txtChannel" class="form-label">Kênh Camera</label>
                            <input type="number" class="form-control" id="txtChannel" name="txtChannel" value=1 required>
                        </div>
                        <div class="mb-3">
                            <label for="txtLicense" class="form-label">Mã kích hoạt</label>
                            <input type="text" class="form-control" id="txtLicense" name="txtLicense" placeholder="Mã được cấp bởi KBT" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Save changes</button>
                    </div>
                    </form>
                </div>
            </div>

            <!-- QR -->
            <div class="modal fade" id="QRCode" tabindex="-1" aria-labelledby="QRCodeLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="QRCodeLabel">QRCode</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="qrcode" class="text-center"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <a id="inqr" type="button" class="btn btn-primary" href="" target="_blank">Print</a>
                    </div>
                    </div>
                </div>
            </div>
            @endsection
@section('footer')
<script type="text/javascript" src="js/jquery.qrcode.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.css" />
<script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
<script>
    $(document).ready( function () {
        //$('#tbScans').DataTable();
        var table = new DataTable('#tbScans',{
            columnDefs: [
                { 'visible': false, 'targets': 4 },
                {
                    data: null,
                    defaultContent: '<i class="bi bi-pencil-square shopeetext"></i>',
                    targets: -1
                }
            ]
        });
        table.on('click', '.bi-pencil-square', function (e) {
            let data = table.row(e.target.closest('tr')).data();
            $('#txtID').val(data[0]);
            $('#txtTen').val(data[1]);
            $('#txtCamera').val(data[2]);
            $('#txtChannel').val(data[3]);
            $('#txtLicense').val(data[4]);
            //alert(data[0] + "'s salary is: " + data[2]);
            var NewCCTV = new bootstrap.Modal(document.getElementById("NewCCTV"), {});
            NewCCTV.show();
        });
    } );
    function qr($id){
        $('#qrcode').empty();
        $('#qrcode').qrcode('{"id":"'+$id+'","host":"{{env("APPBASE_URL")}}"}');
        $('#inqr').attr('href',"{{route('inqr','').'/'}}" + $id);
    }
</script>
@endsection