@extends('layouts.master')

@section('link')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.1.9/sweetalert2.min.css"
        integrity="sha512-cyIcYOviYhF0bHIhzXWJQ/7xnaBuIIOecYoPZBgJHQKFPo+TOBA+BY1EnTpmM8yKDU4ZdI3UGccNGCEUdfbBqw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.1.9/sweetalert2.all.min.js"
        integrity="sha512-IZ95TbsPTDl3eT5GwqTJH/14xZ2feLEGJRbII6bRKtE/HC6x3N4cHye7yyikadgAsuiddCY2+6gMntpVHL1gHw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
        integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
        crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
        integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
        crossorigin=""></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-geosearch@3.0.0/dist/geosearch.css" />
    <script src="https://unpkg.com/leaflet-geosearch@3.1.0/dist/geosearch.umd.js"></script>
    <style>
        #leafletMap-registration {
            height: 300px;
        }

    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title pb-2">Update Lokasi Kantor</h4>
                    <form class="forms-sample" id="form-tambah-edit" name="form-tambah-edit">
                        <input type="hidden" name="id" value="{{ $lokasi->id }}">
                        <input type="hidden" class="form-control" id="koordinat" name="koordinat"
                            value="{{ $lokasi->titik_koordinat }}">
                        <input type="hidden" id="lokasi_kantor" name="lokasi_kantor">
                        <div class="form-group">
                            <label for="lokasi-kantor">Keterangan</label>
                            <input class="form-control" id="ket" name="ket" value="{{ $lokasi->ket }}">
                        </div>
                        <div class="form-group">
                            <div id="leafletMap-registration"></div>
                            <p class="mb-0 text-danger" id="latlong"></p>
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
                url: "{{ route('lokasiKantor.update') }}",
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
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops....',
                        text: 'Terjadi Kesalahan'
                    })
                }
            });
        });

        //openstreep map
        // you want to get it of the window global
        const providerOSM = new GeoSearch.OpenStreetMapProvider();

        var lokasi = document.getElementById('koordinat').value;
        var koordinat = lokasi.split('_');
        //leaflet map
        var leafletMap = L.map('leafletMap-registration', {
            fullscreenControl: true,
            // OR
            fullscreenControl: {
                pseudoFullscreen: false // if true, fullscreen to page width and height
            },
            minZoom: 2
        }).setView([koordinat[0], koordinat[1]], 14);

        L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(leafletMap);

        // let theMarker = {};
        theMarker = L.marker([koordinat[0], koordinat[1]]).addTo(leafletMap);

        leafletMap.on('click', function(e) {
            let latitude = e.latlng.lat.toString().substring(0, 15);
            let longitude = e.latlng.lng.toString().substring(0, 15);

            if (theMarker != undefined) {
                leafletMap.removeLayer(theMarker);
            };
            theMarker = L.marker([latitude, longitude]).addTo(leafletMap);

            let lokasiKantor = latitude + '_' + longitude;

            document.getElementById("lokasi_kantor").value = lokasiKantor;
        });

        const search = new GeoSearch.GeoSearchControl({
            provider: providerOSM,
            style: 'bar',
            searchLabel: 'c a r i',
            showMarker: false
        });

        leafletMap.addControl(search);

        //end

        $(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
    </script>
@endsection()
