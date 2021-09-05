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
                    <input type="text" class="form-control d-none" id="form-kantor-cabang-hidden">
                    <input type="text" class="form-control" id="form-kantor-cabang" placeholder="" value="" disabled>
                </div>
                <div class="form-group col-12">
                    <label for="jumlah-rak">Rak</label>
                </div>
                <div class="form-group col-6">
                    <label for="jumlah-rak">Jumlah Rak</label>
                    <select class="form-control" id="jumlah-rak"></select>
                </div>
                <div class="form-group col-6">
                    <label for="level-rak">Level per Rak</label>
                    <select class="form-control" id="level-rak"></select>
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