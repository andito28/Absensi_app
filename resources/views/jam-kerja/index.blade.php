@extends('layouts.master')

@section('link')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.1.9/sweetalert2.min.css"
        integrity="sha512-cyIcYOviYhF0bHIhzXWJQ/7xnaBuIIOecYoPZBgJHQKFPo+TOBA+BY1EnTpmM8yKDU4ZdI3UGccNGCEUdfbBqw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.1.9/sweetalert2.all.min.js"
        integrity="sha512-IZ95TbsPTDl3eT5GwqTJH/14xZ2feLEGJRbII6bRKtE/HC6x3N4cHye7yyikadgAsuiddCY2+6gMntpVHL1gHw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection

@section('content')
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title pb-2">Update Jam Kerja</h4>
                    <form class="forms-sample" id="form-tambah-edit" name="form-tambah-edit">
                        <input type="hidden" name="id" value="{{ $jamKerja->id }}">
                        <div class="form-group">
                            <label for="Jam-Masuk">Jam Masuk</label>
                            <input type="time" class="form-control" name="jam_masuk" value="{{ $jamKerja->jam_masuk }}">
                        </div>
                        <div class="form-group">
                            <label for="Jam-Pulang">Jam Pulang</label>
                            <input type="time" class="form-control" name="jam_pulang"
                                value="{{ $jamKerja->jam_pulang }}">
                        </div>
                        <button type="submit" class="btn btn-primary mr-2"> Simpan </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script type="text/javascript">
        //ketika tombol simpan di tekan
        $('#form-tambah-edit').on('submit', function(e) {
            e.preventDefault();

            let formData = new FormData(this);
            var form = $('form');
            $.ajax({
                type: "POST",
                url: "{{ route('jamKerja.update') }}",
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses!',
                        text: 'Data berhasil di update!'
                    });
                },
                error: function(xhr) {
                    console.log(xhr);
                }
            });
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
