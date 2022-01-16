<main>
    <div class="container-fluid">
        <ol class="breadcrumb my-4">
            <li class="breadcrumb-item"><?= $controller; ?></li>
            <li class="breadcrumb-item active"><?= $meta['name'] ;?></li>
        </ol>

        <div class="row" id="tambah-barang">
            <input type="hidden" class="form-control d-none" id="form-kantor-cabang-hidden" value="CAB001">
            <input type="hidden" id="uploader" value="1" />
            <input type="hidden" id="status-pinjam" value="1" />

            <div class="col-12">
              <div class="alert alert-success d-none" id="form-success">Berkas berhasil ditambahkan! Halaman akan direfresh...</div>
              <div class="alert alert-danger d-none" id="form-failed">Berkas gagal ditambahkan! Mohon cek form anda atau hubungi administrator!</div>
              <div class="alert alert-warning d-none" id="form-loading">Menambahkan...</div>
            </div>

            <div class="form-group col-12">
                <label for="divisi">Divisi</label>
                <select class="form-control" id="divisi">
                    <option value="">--- Pilih Divisi ---</option>
                    <?php foreach($divisi as $d):?>
                        <option value="<?=$d['id_divisi'];?>"><?=$d['nama'];?>
                    <?php endforeach;?>
                </select>
            </div>
            <div class="form-group col-12">
                <label for="nama-barang">Nama Berkas</label>
                <input type="text" class="form-control" id="nama-barang" placeholder="Masukkan nama berkas...">
            </div>
            <div class="form-group col-12">
                <label for="rak">Posisi Rak</label>
                <div id="daftar-rak-container" class="mt-2"></div>
            </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="button" class="btn btn-secondary" id="back-one">Batalkan</button>
            <button type="button" class="btn btn-primary" id="submit-form-barang">Tambah</button>
          </div>
        </div>
    </div>
</main>