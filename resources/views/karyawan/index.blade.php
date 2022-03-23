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
                    <p class="card-title">
                    <div class="header-right d-flex flex-wrap mt-2 mt-sm-0 mb-3">
                        <button type="button" class="btn btn-primary mt-2 mt-sm-0 btn-icon-text" data-toggle="modal"
                            id="button-tambah">
                            <i class="mdi mdi-plus-circle"></i>Tambah Karyawan </button>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="table-user" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Jenis Kelamin</th>
                                            <th>HP</th>
                                            <th>Posisi</th>
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
    @include('karyawan.modal')
@endsection


@section('script')
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script type="text/javascript">
        $(function() {
            $('#table-user').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: '{{ route('user.get') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    }, {
                        data: 'nama',
                        name: 'nama'
                    }, {
                        data: 'jenis_kelamin',
                        name: 'jenis_kelamin'
                    }, {
                        data: 'hp',
                        name: 'hp'
                    }, {
                        data: 'posisi',
                        name: 'posisi'
                    }, {
                        data: 'action',
                        name: 'action'
                    }

                ]
            });
        });


        //ketika tombol add product di tekan
        $('#button-tambah').click(function() {
            $('#button-simpan').html('Simpan'); //valuenya menjadi create-post
            $('#id').val(''); //valuenya menjadi kosong
            $('#kecamatan_id').html('');
            $('#form-tambah-edit').trigger("reset"); //mereset semua input dll didalamnya
            $('#title').html("Tambah Karyawan"); //valuenya tambah role baru
            $('#tambah-edit-modal').modal('show'); //modal tampil
        });


        //ketika tombol simpan di tekan
        $('#form-tambah-edit').on('submit', function(e) {
            e.preventDefault();

            let formData = new FormData(this);
            var form = $('form');
            form.find('span').remove();
            form.find('.form-group').removeClass('is-invalid');
            form.find('.form-control').removeClass('is-invalid');

            $.ajax({
                type: "POST",
                url: "{{ route('user.store') }}",
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    $('#form-tambah-edit').trigger("reset");
                    $('#tambah-edit-modal').modal('hide');
                    $('#table-user').DataTable().ajax.reload();
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses!',
                        text: 'Data berhasil disimpan!'
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
        $('body').on('click', '.edit-user', function() {
            let data_id = $(this).data('id');
            $('#kecamatan_id').html("")
            $.get('edit-user/' + data_id, function(data) {
                console.log(data)
                $('#tambah-edit-modal').modal('show');
                $('#title').html("Edit Karyawan");
                $('#button-simpan').html('Update');
                $('#id').val(data.id);
                $('#nama').val(data.nama);
                $('#jenis_kelamin').val(data.jenis_kelamin).change();
                $('#hp').val(data.hp);
                $('#posisi').val(data.posisi);
            })

        })

        //ketika tombol delete di tekan
        $('body').on('click', '.delete-user', function() {
            let dataId = $(this).attr('id');
            Swal.fire({
                icon: 'warning',
                title: 'Hapus? ',
                text: 'Anda yakin ingin menghapus data ini?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        method: "get",
                        url: "delete-user/" + dataId,

                        success: function(data) {
                            $('#table-user').DataTable().ajax.reload();
                            Swal.fire({
                                icon: 'success',
                                title: 'Sukses!',
                                text: 'Data berhasil dihapus!'
                            });
                        },
                        error: function(data) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops....',
                                text: 'Something went wrong'
                            })
                        }
                    });
                }
            })
        });


        $(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
    </script>
@endsection()
