<main>
    <div class="container-fluid">
        <ol class="breadcrumb my-4">
            <li class="breadcrumb-item"><?= $controller; ?></li>
            <li class="breadcrumb-item active"><?= $meta['name'] ;?></li>
        </ol>

        <div class="row">
            <div class="col-xl-12">
                <div class="card mb-4">
                    <div class="card-header">
                        Gudang
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <label for="kantor-cabang">Pilih Kantor Cabang:</label>
                                <select class="form-control" id="show-kantor-cabang">
                                    <option value="">--- Pilih kantor cabang yang ingin ditampilkan ---</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row d-none" id="tampilan-gudang">
            <div class="col-xl-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                Data Gudang
                            </div>
                            <div class="col-6">
                                <button id="btn-tambah-gudang" class="btn btn-primary btn-sm float-right">Tambah Gudang</button>
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
                                                <th>Nama Gudang</th>
                                                <th>Jumlah Rak</th>
                                                <th>Daftar Rak</th>
                                                <th>Jumlah</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        
                                        <tfoot>
                                            <tr>
                                                <th>Nama Gudang</th>
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