<main>
    <div class="container-fluid">
        <ol class="breadcrumb my-4">
            <li class="breadcrumb-item"><?= $controller; ?></li>
            <li class="breadcrumb-item active"><?= $meta['name'] ;?></li>
        </ol>

        <input type="hidden" id="divisi-user" value="<?= $_SESSION['divisi'] ;?>" />

        <div class="row d-none" id="tampilan-gudang">
            <div class="col-xl-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                Data Gudang
                            </div>
                            <?php if($_SESSION['divisi'] == 'ADM'):?>
                            <div class="col-6">
                                <button id="btn-tambah-gudang" class="btn btn-primary btn-sm float-right">Tambah Gudang</button>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive"> 
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Nama Gudang</th>
                                                <th>Kode Gudang</th>
                                                <th>Jumlah Rak</th>
                                                <th>Daftar Rak</th>
                                                <th>Jumlah</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        
                                        <tfoot>
                                            <tr>
                                                <th>Nama Gudang</th>
                                                <th>Kode Gudang</th>
                                                <th>Jumlah Rak</th>
                                                <th>Daftar Rak</th>
                                                <th>Jumlah</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>