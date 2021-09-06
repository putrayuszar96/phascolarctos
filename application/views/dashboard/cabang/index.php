<main>
    <div class="container-fluid">
        <ol class="breadcrumb my-4">
            <li class="breadcrumb-item"><?= $controller; ?></li>
            <li class="breadcrumb-item active"><?= $meta['name'] ;?></li>
        </ol>

        <div class="row" id="tampilan-cabang">
            <div class="col-xl-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                Data Cabang
                            </div>
                            <div class="col-6">
                                <button id="btn-tambah-cabang" class="btn btn-primary btn-sm float-right">Tambah Cabang</button>
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
                                                <th>Kantor Cabang</th>
                                                <th>Alamat</th>
                                                <th>Jumlah Divisi</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        
                                        <tfoot>
                                            <th>Kantor Cabang</th>
                                            <th>Alamat</th>
                                            <th>Jumlah Divisi</th>
                                            <th>Action</th>
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