<main>
    <div class="container-fluid">
        <ol class="breadcrumb my-4">
            <li class="breadcrumb-item"><?= $controller; ?></li>
            <li class="breadcrumb-item active"><?= $meta['name'] ;?></li>
        </ol>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                Daftar Pegawai
                            </div>
                            <div class="col-6">
                                <button id="btn-tambah-pegawai" class="btn btn-sm btn-primary float-right">Tambah Pegawai</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive"> 
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Nama Lengkap</th>
                                        <th>Divisi</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="data-table-body"></tbody>
                                <tfoot>
                                    <tr>
                                        <th>Nama Lengkap</th>
                                        <th>Divisi</th>
                                        <th>Status</th>
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
</main>