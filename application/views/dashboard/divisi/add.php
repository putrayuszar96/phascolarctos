<div class="modal fade" id="tambah-divisi" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Tambah Divisi</h5>
      </div>
      <div class="modal-body">
        <form class="form" id="form-divisi">
            <div class="row">
                <div class="col-12">
                  <div class="alert alert-success d-none" id="form-success">Divisi berhasil ditambahkan! Halaman akan direfresh...</div>
                  <div class="alert alert-danger d-none" id="form-failed">Divisi gagal ditambahkan! Mohon cek form anda atau hubungi administrator!</div>
                  <div class="alert alert-warning d-none" id="form-loading">Menambahkan...</div>
                </div>
                <div class="form-group col-12">
                    <label for="cabang">Kantor Cabang <small class="text-danger">(required)</small></label>
                    <input type="hidden" class="form-control d-none" id="form-kantor-cabang-hidden" value="<?=$value?>">
                    <input type="hidden" class="form-control d-none" id="form-id-divisi-terakhir" value="<?=$id_terakhir?>">
                    <input type="text" class="form-control" id="form-kantor-cabang" value="<?=$label;?>" disabled>
                </div>
                <div class="form-group col-12">
                    <label for="nama">Nama Divisi <small class="text-danger">(required)</small></label>
                    <input type="text" class="form-control" id="nama" placeholder="Masukkan nama divisi...">
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="cancel-form-divisi">Batalkan</button>
        <button type="button" class="btn btn-primary" id="submit-form-divisi">Tambah</button>
      </div>
    </div>
  </div>
</div>