@extends('home')
@section('header')
@endsection
           @section('main')
            <div class="card">
                <div class="card-body">
                    <p class="shopeetext">{{ __('Quản lý hệ thống camera tích hợp') }}</p>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#NewCCTV">
                        Thêm mới
                    </button>
                    <div class="table-responsive">
                    <table id="tbCameras" class="display border border-danger">
                        <thead class="shopee">
                            <tr>
                                <th>ID</th>
                                <th>Tên</th>
                                <th>Địa chỉ</th>
                                <th>Tài khoản</th>
                                <th>SN</th>
                                <th>Số kênh</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cameras as $item)
                            <tr>
                                <td scope="row">{{$item->id}}</td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->address}}</td>
                                <td>{{$item->user}}</td>
                                <td>{{$item->sn}}</td>
                                <td>{{$item->channels}}</td>
                                <td></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="NewCCTV" tabindex="-1" aria-labelledby="NewCCTVLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form id="frmNew" class="modal-content" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h1 class="modal-title fs-5 shopeetext" id="NewCCTVLabel">Thêm mới</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <input type="text" value=0 id="txtID" name="txtID" hidden readonly required>
                                <label for="txtName" class="form-label">Tên hệ thống</label>
                                <input type="text" class="form-control" id="txtName" name="txtName" placeholder="KBT" required>
                            </div>
                            <div class="mb-3">
                                <label for="txtIP" class="form-label">Địa chỉ IP</label>
                                <input type="text" class="form-control" id="txtIP" name="txtIP" placeholder="192.168.1.50" required>
                            </div>
                            <div class="mb-3">
                                <label for="txtUser" class="form-label">Tài khoản</label>
                                <input type="text" class="form-control" id="txtUser" name="txtUser" placeholder="admin" required>
                            </div>
                            <div class="mb-3">
                                <label for="txtPass" class="form-label">Mật khẩu</label>
                                <input type="password" class="form-control" id="txtPass" name="txtPass" placeholder="" required>
                            </div>
                            <div class="mb-3">
                                <label for="txtSN" class="form-label">Series Number</label>
                                <input type="text" class="form-control" id="txtSN" name="txtSN" placeholder="XXXXXXXXXXXXXXX" required>
                            </div>
                            <div class="mb-3">
                                <label for="txtChannels" class="form-label">Số kênh</label>
                                <input type="text" class="form-control" id="txtChannels" name="txtChannels" placeholder="4" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" id="submit" class="btn btn-danger">Save changes</button>
                            <div id="loading" class="spinner-border text-danger" role="status">
                                <span class="sr-only"></span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @endsection
@section('footer')
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.css" />
<script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
<script>
    $(document).ready( function () {
        $('#loading').hide();
        const frm = document.querySelector('#frmNew');
        frm.addEventListener('submit',() => {
            $('#submit').hide();
            $('#loading').show();
        });
        var table = new DataTable('#tbCameras',{
            columnDefs: [
                {
                    data: null,
                    defaultContent: '<i class="bi bi-pencil-square shopeetext"></i>',
                    targets: -1
                }
            ]
        });
        table.on('click', 'i', function (e) {
            let data = table.row(e.target.closest('tr')).data();
            $('#txtID').val(data[0]);
            $('#txtName').val(data[1]);
            $('#txtIP').val(data[2]);
            $('#txtUser').val(data[3]);
            $('#txtPass').attr('placeholder','Nếu cần thay đổi mật khẩu hãy nhập');
            $('#txtPass').prop('required',false);
            $('#txtSN').val(data[4]);
            $('#txtChannels').val(data[5]);
            //alert(data[0] + "'s salary is: " + data[2]);
            var NewCCTV = new bootstrap.Modal(document.getElementById("NewCCTV"), {});
            NewCCTV.show();
        });
        const NewCCTV1 = document.getElementById('NewCCTV')
        NewCCTV1.addEventListener('hidden.bs.modal', event => {
            $('#txtPass').prop('required',true);
            $('#txtPass').attr('placeholder','');
            $('#txtID').val(0);
            $('#loading').hide();
            $('#submit').show();
            $('#txtName').val('');
            $('#txtIP').val('');
            $('#txtUser').val('');
            $('#txtPass').val('');
            $('#txtSN').val('');
            $('#txtChannels').val('');
        });
    } );
</script>
@endsection