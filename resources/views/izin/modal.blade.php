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
                        <input type="hidden" class="form-control" name="user_id" id="user_id">
                        <input type="hidden" class="form-control" name="jenis_izin" id="jenis_izin">
                        <input type="hidden" class="form-control" name="waktu_mulai" id="waktu_mulai">
                        <input type="hidden" class="form-control" name="waktu_selesai" id="waktu_selesai">
                        <input type="hidden" class="form-control" name="ket" id="ket">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="jenis_kelamin">Status</label>
                                    <select name="status" class="form-control" id="status">
                                        <option value="proses">proses</option>
                                        <option value="terima">terima</option>
                                        <option value="tolak">tolak</option>
                                    </select>
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
