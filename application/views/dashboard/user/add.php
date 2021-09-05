<div class="modal fade" id="tambah-pegawai" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Tambah Pegawai</h5>
      </div>
      <div class="modal-body">
        <form class="form" id="form-pegawai">
            <div class="row">
                <div class="col-12">
                  <div class="alert alert-success d-none" id="form-success">Pegawai berhasil ditambahkan! Halaman akan direfresh...</div>
                  <div class="alert alert-danger d-none" id="form-failed">Pegawai gagal ditambahkan! Mohon cek form anda atau hubungi administrator!</div>
                  <div class="alert alert-warning d-none" id="form-loading">Menambahkan...</div>
                </div>
                <div class="form-group col-12">
                    <label for="cabang">Kantor Cabang <small class="text-danger">(required)</small></label>
                    <select class="form-control" id="cabang">
                        <option value="">--- Pilih Cabang ---</option>
                        <?php foreach($cabang as $cab):?>
                            <option value="<?=$cab['id_cabang'];?>"><?= $cab['nama'];?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="form-group col-12">
                    <label for="divisi">Divisi <small class="text-danger">(required)</small></label>
                    <select class="form-control" id="divisi">
                        <option value="">--- Pilih Divisi ---</option>
                        <?php foreach($divisi as $div):?>
                            <option value="<?=$div['id_divisi'];?>"><?= $div['nama'];?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="form-group col-12">
                    <label for="email">Email <small class="text-danger">(required)</small></label>
                    <input type="email" class="form-control" id="email" placeholder="Masukkan email pegawai...">
                </div>
                <div class="form-group col-12">
                    <label for="username">Username <small class="text-danger">(required)</small></label>
                    <input type="text" class="form-control" id="username" placeholder="Masukkan nama pegawai...">
                </div>
                <div class="form-group col-12">
                    <label for="nama-pegawai">Nama Pegawai <small class="text-danger">(required)</small></label>
                    <input type="text" class="form-control" id="nama-pegawai" placeholder="Masukkan nama pegawai...">
                </div>
                <div class="d-none">
                  <input type="text" id="status" value="1" />
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="cancel-form-pegawai">Batalkan</button>
        <button type="button" class="btn btn-primary" id="submit-form-pegawai">Tambah</button>
      </div>
    </div>
  </div>
</div>