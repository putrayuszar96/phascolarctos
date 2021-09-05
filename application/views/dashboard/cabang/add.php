<div class="modal fade" id="tambah-cabang" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Tambah Kantor Cabang</h5>
      </div>
      <div class="modal-body">
        <form class="form" id="form-cabang">
            <div class="row">
                <div class="col-12">
                  <div class="alert alert-success d-none" id="form-success">Kantor Cabang berhasil ditambahkan! Halaman akan direfresh...</div>
                  <div class="alert alert-danger d-none" id="form-failed">Kantor Cabang gagal ditambahkan! Mohon cek form anda atau hubungi administrator!</div>
                  <div class="alert alert-warning d-none" id="form-loading">Menambahkan...</div>
                </div>
                <div class="form-group col-12">
                    <label for="nama">Nama <small class="text-danger">(required)</small></label>
                    <input type="text" class="form-control" id="nama" placeholder="Masukkan nama cabang...">
                </div>
                <div class="form-group col-12">
                    <label for="alamat">Alamat <small class="text-danger">(required)</small></label>
                    <input type="text" class="form-control" id="alamat" placeholder="Masukkan alamat cabang...">
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="cancel-form-cabang">Batalkan</button>
        <button type="button" class="btn btn-primary" id="submit-form-cabang">Tambah</button>
      </div>
    </div>
  </div>
</div>