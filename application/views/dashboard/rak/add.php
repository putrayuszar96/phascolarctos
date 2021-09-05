<div class="modal fade" id="tambah-pemilik" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Tambah Pemilik Rak</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="form" id="form-pemilik">
            <div class="row">
                <div class="form-group col-12">
                    <label for="cabang">Kantor Cabang <small class="text-danger">(required)</small></label>
                    <input type="hidden" class="form-control d-none" id="form-kantor-cabang-hidden" value="<?=$value?>">
                    <input type="text" class="form-control" id="form-kantor-cabang" value="<?=$label;?>" disabled>
                </div>
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
                      <option value="">--- Pilih gudang ---</option>
                      <?php foreach($gudang as $g):?>
                        <option value="<?=$g['id_rak'];?>"><?=$g['nama'];?></option>
                      <?php endforeach;?>
                    </select>
                    <label for="daftar-rak" class="mt-2">Daftar Rak</label>
                    <div id="daftar-rak-container" class="mt-2">

                    </div>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batalkan</button>
        <button type="button" class="btn btn-primary">Tambah</button>
      </div>
    </div>
  </div>
</div>