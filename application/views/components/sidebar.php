<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <!-- <a class="nav-link" href="index.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a> -->
                <a class="nav-link<?= ($active == 'gudang') ? " active" : "" ;?>" href="<?=base_url();?>gudang">
                    <div class="sb-nav-link-icon"><i class="fas fa-building"></i></div>
                    Gudang
                </a>
                <a class="nav-link<?= ($active == 'rak') ? " active" : "" ;?>" href="<?=base_url();?>rak">
                    <div class="sb-nav-link-icon"><i class="fas fa-users-cog"></i></div>
                    Rak Milik
                </a>
                <a class="nav-link<?= ($active == 'berkas') ? " active" : "" ;?>" href="<?=base_url();?>barang">
                    <div class="sb-nav-link-icon"><i class="fas fa-copy"></i></div>
                    Berkas
                </a>
                <a class="nav-link<?= ($active == 'divisi') ? " active" : "" ;?>" href="<?=base_url();?>divisi">
                    <div class="sb-nav-link-icon"><i class="fas fa-house-user"></i></div>
                    Divisi
                </a>
                <a class="nav-link<?= ($active == 'user') ? " active" : "" ;?>" href="<?=base_url();?>user">
                    <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                    Pegawai
                </a>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            
        </div>
    </nav>
</div>