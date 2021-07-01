
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> </h5>
       
      </div>
      <div class="modal-body">
        <form action="#" id="formproduk" name="formproduk">
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Nama Barang:</label>
            <input type="hidden" class="form-control" id="Id" name="Id">
            <input type="text" class="form-control" id="Nama_barang" name="Nama_barang" required>
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Kode Barang:</label>
            <input type="text" class="form-control" id="Kode_barang" name="Kode_barang" required>
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Jumlah Barang:</label>
            <input type="number" class="form-control" id="Jumlah_barang" pattern="([0-9]{1,3}).([0-9]{1,3})" name='Jumlah_barang' required>
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Tanggal:</label>
            <input type="text" data-provide="datepicker" class="form-control datepicker" id="Tanggal" name='Tanggal' required>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="button" id="btnSave" class="btn btn-primary">Simpan</button>
      </div>
    </div>
  </div>
</div>