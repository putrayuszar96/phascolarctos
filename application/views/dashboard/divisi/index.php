<main>
    <div class="container-fluid">
        <ol class="breadcrumb my-4">
            <li class="breadcrumb-item"><?= $controller; ?></li>
            <li class="breadcrumb-item active"><?= $meta['name'] ;?></li>
        </ol>

        <input type="hidden" id="divisi-user" value="<?= $_SESSION['divisi'] ;?>" />

        <div class="row" id="tampilan-divisi">
            <div class="col-xl-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                Data Divisi
                            </div>
                            <div class="col-6">
                                <a href="<?=base_url();?>/divisi/add"><button id="btn-tambah-divisi" class="btn btn-primary btn-sm float-right">Tambah Divisi</button></a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive"> 
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Nama Divisi</th>
                                                <th>Jumlah Pegawai</th>
                                                <th>Jumlah Rak Milik</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        
                                        <tfoot>
                                            <tr>
                                                <th>Nama Divisi</th>
                                                <th>Jumlah Pegawai</th>
                                                <th>Jumlah Rak Milik</th>
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