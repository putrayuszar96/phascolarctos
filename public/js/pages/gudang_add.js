$(document).on('click', '#back-one', function () {
    history.go(-1);
})

$(document).on('click', '#check-kode-gudang', function () {
    console.log('hello')
    let kode_gudang = $('#kode-gudang').val();

    $.ajax({
        type: 'POST',
        url: baseUrl+'/gudang/check_kode_gudang_process',
        dataType: 'json',
        data: {
            kode_gudang: kode_gudang
        },
        success: function (response) {
            if(response.status == 'ok'){
                $('#form-check-kode-gudang').val('1');
                $('#status-check-kode-gudang').text('Kode dapat digunakan!')
            }else{
                $('#status-check-kode-gudang').text('Kode telah digunakan! Mohon gunakan kode yang lain!')
            }
        }
    })
})

$(document).on('click', '#submit-form-gudang', function () {
    $('#tambah-gudang').loading();

    let nama_gudang = $('#nama-gudang').val()
    let jumlah_rak = $('#jumlah-rak').val()
    let level_rak = $('#level-rak').val()
    let kode_gudang = $('#kode-gudang').val()
    let status_cek_kode_gudang = $('#form-check-kode-gudang').val()

    if(status_cek_kode_gudang == 0){
        $('#form-loading').addClass('d-none');
        $('#form-failed-check').removeClass('d-none');

        $('#tambah-gudang').loading('stop');

        setTimeout(function(){
            $('#form-failed-check').addClass('d-none');
        }, 2000)
    }else if(nama_gudang == '' || jumlah_rak == '' || level_rak == ''){
        $('#form-empty').removeClass('d-none');

        setTimeout(function(){
            $('#form-empty').addClass('d-none');
        }, 2000)
    }else{
        $.ajax({
            type: 'POST',
            url: baseUrl+'/gudang/add_gudang_process',
            dataType: 'json',
            data: {
                nama_gudang: nama_gudang,
                jumlah_rak: jumlah_rak,
                level_rak: level_rak,
                kode_gudang: kode_gudang
            },
            success: function (response) {
                if(response.status == 'ok'){
                    $('#form-loading').addClass('d-none');
                    $('#form-success').removeClass('d-none');
    
                    setTimeout(function () {
                        window.location.replace(baseUrl+'/gudang');
                    }, 1000)
                }else{
                    $('#form-loading').addClass('d-none');
                    $('#form-failed').removeClass('d-none');
                }

                $('#tambah-gudang').loading('stop');
            }
        })
    }
})