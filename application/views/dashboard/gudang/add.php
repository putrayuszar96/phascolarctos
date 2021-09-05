<div class="modal fade" id="tambah-gudang" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Tambah Gudang Rak</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="form" id="form-gudang">
            <div class="row">
                <div class="form-group col-12">
                    <label for="form-kantor-cabang">Kantor Cabang</label>
                    <input type="hidden" class="form-control d-none" id="form-kantor-cabang-hidden" value="<?=$value?>">
                    <input type="hidden" class="form-control d-none" id="form-id-gudang-terakhir" value="<?=$id_terakhir?>">
                    <input type="text" class="form-control" id="form-kantor-cabang" value="<?=$label;?>" disabled>
                </div>
                <div class="form-group col-12">
                    <label for="nama-gudang">Nama Gudang</label>
                    <input type="text" class="form-control" id="nama-gudang"/>
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
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="cancel-form-gudang">Batalkan</button>
        <button type="button" class="btn btn-primary" id="submit-form-gudang">Tambah</button>
      </div>
    </div>
  </div>
</div>