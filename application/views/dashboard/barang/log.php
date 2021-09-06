<div class="modal fade" id="log-peminjaman" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Log Peminjaman</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="row">
                <div class="col-4">
                    <span class="font-bold">Status Pinjam</span>
                </div>
                <div class="col-8">
                    <?php if($status == 0):?>
                        <span>Tersedia</span>
                    <?php else:?>
                        <span>Dipinjam</span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col">
                    <table class="table table-striped">
                        <tr>
                            <th>Peminjam</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                        </tr>
                        <?php if($log != null):?>
                            <?php foreach($log as $l):?>
                                <tr>
                                    <td><?=$l['nama_peminjam'];?></td>
                                    <td><?=date("d M Y H:i", $l['tanggal_pinjam']);?></td>
                                    <?php if($l['tanggal_kembali'] == null):?>
                                        <td><i>Belum dikembalikan</i></td>
                                    <?php else: ?>
                                        <td><?=date("d M Y H:i", $l['tanggal_kembali']);?></td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach;?>
                        <?php else:?>
                            <tr>
                                <td colspan="3">Tidak ada data peminjaman</td>
                            </tr>
                        <?php endif;?>
                    </table>
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="log-peminjaman-close" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>