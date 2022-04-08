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
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.1/css/buttons.dataTables.min.css">

    <style>
        .dataTables_wrapper {
            font-family: tahoma;
            font-size: 14px;
            position: relative;
            clear: both;
            *zoom: 1;
            zoom: 1;
        }

        input.form-date {
            border: none;
            font-family: sans-serif;
            font-size: 12px;
            background: hsl(0 0% 93%);
            border-radius: .25rem;
            padding: .55rem 1rem;
            width: 100%;
            cursor: pointer;
        }

    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body pt-2">
                    <div class="row">
                        <div class="col col-md-12">
                            <div class="row">
                                <div class="col-md-3 pr-3 pt-3">
                                    <input type="text" name="nama" id="nama" class="form-date" placeholder="Nama" />
                                </div>
                                <div class="row input-daterange pt-3 pb-3">
                                    <div class="col-md-3 pr-0">
                                        <input type="text" name="from_date" id="from_date" class="form-date"
                                            placeholder="From Date" readonly />
                                    </div>
                                    <div class="col-md-3 pr-0">
                                        <input type="text" name="to_date" id="to_date" class="form-date"
                                            placeholder="To Date" readonly />
                                    </div>
                                    <div class="col-md-3">
                                        <button type="button" name="filter" id="filter" class="btn btn-primary"
                                            style="padding:8px;">Filter
                                            Tanggal</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="table-absen" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Posisi</th>
                                            <th>Tanggal</th>
                                            <th>Jam datang</th>
                                            <th>Jam Pulang</th>
                                            <th>Status</th>
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
@endsection


@section('script')
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.input-daterange').datepicker({
                todayBtn: 'linked',
                format: 'yyyy-mm-dd',
                autoclose: true
            });

            load_data();

            function load_data(from_date = '', to_date = '', nama = '') {
                $('#table-absen').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'excelHtml5', 'pdfHtml5', 'csvHtml5'
                    ],
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    "bPaginate": false,
                    "bLengthChange": false,
                    "bFilter": true,
                    "bInfo": false,
                    "bAutoWidth": false,
                    "searching": false,
                    ajax: {
                        url: '{{ route('absen.get') }}',
                        data: {
                            from_date: from_date,
                            to_date: to_date,
                            nama: nama,
                        }
                    },
                    columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    }, {
                        data: 'nama',
                        name: 'nama'
                    }, {
                        data: 'posisi',
                        name: 'posisi'
                    }, {
                        data: 'tgl_a',
                        name: 'tgl_a'
                    }, {
                        data: 'jam_d',
                        name: 'jam_d'
                    }, {
                        data: 'jam_p',
                        name: 'jam_p'
                    }, {
                        data: 'status',
                        name: 'status'
                    }]
                });
            }

            $('#filter').click(function() {
                var from_date = $('#from_date').val();
                var to_date = $('#to_date').val();
                var nama = $('#nama').val();
                if (from_date != '' && to_date != '') {
                    $('#table-absen').DataTable().destroy();
                    load_data(from_date, to_date, nama);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops....',
                        text: 'Form Date Wajib Di Isi'
                    })
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
