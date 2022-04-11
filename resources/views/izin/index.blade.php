@extends('layouts.master')

@section('link')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
        integrity="sha512-c42qTSw/wPZ3/5LBzD+Bw5f7bSF2oxou6wEb+I/lqeaKV5FDIfMvvRp772y4jcJLKuGUOpbJMdg/BTl50fJYAw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.1.9/sweetalert2.min.css"
        integrity="sha512-cyIcYOviYhF0bHIhzXWJQ/7xnaBuIIOecYoPZBgJHQKFPo+TOBA+BY1EnTpmM8yKDU4ZdI3UGccNGCEUdfbBqw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.1.9/sweetalert2.all.min.js"
        integrity="sha512-IZ95TbsPTDl3eT5GwqTJH/14xZ2feLEGJRbII6bRKtE/HC6x3N4cHye7yyikadgAsuiddCY2+6gMntpVHL1gHw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <style>
        .dataTables_wrapper {
            font-family: tahoma;
            font-size: 14px;
            position: relative;
            clear: both;
            *zoom: 1;
            zoom: 1;
        }

    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="table-izin" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Jenis Izin</th>
                                            <th>Waktu Mulai</th>
                                            <th>Waktu Selesai</th>
                                            <th>Status</th>
                                            <th width="100px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('izin.modal')
@endsection


@section('script')
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script type="text/javascript">
        $(function() {
            $('#table-izin').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: '{{ route('izin.get') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    }, {
                        data: 'nama',
                        name: 'nama'
                    }, {
                        data: 'jenis_izin',
                        name: 'jenis_izin'
                    }, {
                        data: 'waktu_m',
                        name: 'waktu_m'
                    }, {
                        data: 'waktu_s',
                        name: 'waktu_s'
                    }, {
                        data: 'status_i',
                        name: 'status_i'
                    }, {
                        data: 'action',
                        name: 'action'
                    }

                ]
            });
        });




        //ketika tombol simpan di tekan
        $('#form-tambah-edit').on('submit', function(e) {
            e.preventDefault();

            let formData = new FormData(this);
            var form = $('form');

            console.log(formData)
            $.ajax({
                type: "POST",
                url: "{{ route('izin.store') }}",
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    $('#form-tambah-edit').trigger("reset");
                    $('#tambah-edit-modal').modal('hide');
                    $('#table-izin').DataTable().ajax.reload();
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses!',
                        text: 'Data berhasil di update!'
                    });
                },
                error: function(xhr) {
                    var res = $.parseJSON(xhr.responseText);
                    if ($.isEmptyObject(res) == false) {
                        $.each(res.errors, function(key, value) {

                            $('#' + key).closest('.form-group').addClass('is-invalid').append(
                                '<span class="is-invalid text-danger">' + value +
                                '</span>');
                            $('#' + key).closest('.form-control').addClass('is-invalid');
                        })
                    }
                }
            });
        });
        //akhir tombol simpan

        //ketika tombol edit di tekan
        $('body').on('click', '.edit-izin', function() {
            let data_id = $(this).data('id');
            $.get('edit-izin/' + data_id, function(data) {
                console.log(data)
                $('#tambah-edit-modal').modal('show');
                $('#title').html("Update Status");
                $('#button-simpan').html('Update');
                $('#id').val(data.id);
                $('#user_id').val(data.user_id);
                $('#jenis_izin').val(data.jenis_izin);
                $('#waktu_mulai').val(data.waktu_mulai);
                $('#waktu_selesai').val(data.waktu_selesai);
                $('#ket').val(data.ket);
                $('#status').val(data.status).change();
            })

        })

        $(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
    </script>
@endsection()
