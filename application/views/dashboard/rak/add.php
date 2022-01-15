<main>
    <div class="container-fluid">
        <ol class="breadcrumb my-4">
            <li class="breadcrumb-item"><?= $controller; ?></li>
            <li class="breadcrumb-item active"><?= $meta['name'] ;?></li>
        </ol>

        <div class="row" id="tambah-pemilik">
            <div class="form-group col-12">
                <label for="nama-divisi">Nama Divisi</label>
                <select class="form-control" id="divisi">
                  <option value="">--- Pilih divisi yang ingin ditambahkan rak ---</option>
                  <?php foreach($divisi as $d):?>
                    <option value="<?=$d['id_divisi'];?>"><?=$d['nama'];?></option>
                  <?php endforeach;?>
                </select>
            </div>
            <div class="form-group col-12">
                <strong class="d-block">Rak Milik</strong>
                <label for="gudang">Pilih Gudang</label>
                <select class="form-control" id="gudang">
                  <option value="null">--- Pilih gudang ---</option>
                  <?php foreach($gudang as $g):?>
                    <option value="<?=$g['id_rak'];?>"><?=$g['nama'];?></option>
                  <?php endforeach;?>
                </select>
                <label for="daftar-rak" class="mt-2">Daftar Rak</label>
                <div id="daftar-rak-container" class="mt-2"></div>
            </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="button" class="btn btn-secondary" id="back-one">Batalkan</button>
            <button type="button" class="btn btn-primary" id="submit-form-rak">Tambah</button>
          </div>
          <div class="col-12">
              <div class="alert alert-success d-none" id="form-success">Rak Milik berhasil ditambahkan! Halaman akan dialihkan...</div>
              <div class="alert alert-danger d-none" id="form-failed">Rak Milik gagal ditambahkan! Mohon cek form anda atau hubungi administrator!</div>
              <div class="alert alert-danger d-none" id="form-empty">Mohon mengisi semua kolom form!</div>
              <div class="alert alert-warning d-none" id="form-loading">Menambahkan...</div>
            </div>
        </div>
    </div>
</main>