<main>
    <div class="container-fluid">
        <ol class="breadcrumb my-4">
            <li class="breadcrumb-item"><?= $controller; ?></li>
            <li class="breadcrumb-item active"><?= $meta['name'] ;?></li>
        </ol>

        <div class="row" id="tampilan-gudang">
          <div class="col-12">
            <div class="alert alert-success d-none" id="form-success">Berkas berhasil ditambahkan! Halaman akan direfresh...</div>
            <div class="alert alert-danger d-none" id="form-failed">Berkas gagal ditambahkan! Mohon cek form anda atau hubungi administrator!</div>
            <div class="alert alert-danger d-none" id="form-empty">Mohon mengisi semua kolom form!</div>
            <div class="alert alert-danger d-none" id="form-failed-check">Mohon cek kode gudang! Kode gudang tidak boleh kosong ataupun terduplikasi!</div>
            <div class="alert alert-warning d-none" id="form-loading">Menambahkan...</div>
          </div>
          <div class="form-group col-12">
              <label for="nama-gudang">Nama Gudang</label>
              <input type="text" class="form-control" id="nama-gudang"/>
          </div>
          <div class="form-group col-12">
              <label for="kode-gudang">Kode Gudang</label>
              <div class="input-group mb-3">
                <input type="text" class="form-control" id="kode-gudang" placeholder="Kode Gudang" aria-label="Kode Gudang" aria-describedby="basic-addon2">
                <input type="hidden" id="form-check-kode-gudang">
                <div class="input-group-append">
                  <button class="btn btn-outline-secondary" type="button" id="check-kode-gudang">Cek Kode</button>
                </div>
              </div>
              <small id="status-check-kode-gudang"></small>
          </div>
          <div class="form-group col-6">
              <label for="jumlah-rak">Jumlah Rak</label>
              <input type="number" class="form-control" id="jumlah-rak"/>
          </div>
          <div class="form-group col-6">
              <label for="level-rak">Level per Rak</label>
              <input type="number" class="form-control" id="level-rak"/>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="button" class="btn btn-secondary" id="back-one">Batalkan</button>
            <button type="button" class="btn btn-primary" id="submit-form-gudang">Tambah</button>
          </div>
        </div>
    </div>
</main>
