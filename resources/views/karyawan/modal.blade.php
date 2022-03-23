<!-- Modal -->
<div class="modal fade" id="tambah-edit-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="title"></h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <div class="card-body">
                    <form id="form-tambah-edit" name="form-tambah-edit">
                        @csrf
                        <input type="hidden" name="id" id="id">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama">
                                </div>
                                <div class="form-group">
                                    <label for="jenis_kelamin">Jenis Kelamin</label>
                                    <select name="jenis_kelamin" class="form-control" id="jenis_kelamin">
                                        <option value="Laki-Laki">Laki-Laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="posisi">Posisi</label>
                                    <input type="text" class="form-control" name="posisi" id="posisi"
                                        placeholder="Posisi">
                                </div>
                                <div class="form-group">
                                    <label for="hp">Nomor HP</label>
                                    <input type="number" class="form-control" name="hp" id="hp"
                                        placeholder="Nomor Hp">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-sm" id="button-simpan"></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
