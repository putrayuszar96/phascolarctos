$(document).on('click', '#submit-form-barang', function () {
    $('#tambah-barang').loading();

    let nama_barang = $('#nama-barang').val();
    let id_divisi = $('#divisi').val()
    let uploader = $('#uploader').val();
    let status_pinjam = $('#status-pinjam').val();
    let rak_posisi = $('input[type=radio]:checked').val()

    $.ajax({
        type: 'POST',
        url: baseUrl+'/barang/add_barang_process',
        dataType: 'json',
        data: {
            nama_barang: nama_barang,
            id_divisi: id_divisi,
            uploader: uploader,
            status_pinjam: status_pinjam,
            rak_posisi: rak_posisi
        },
        success: function (response) {
            if(response.status == 'ok'){
                $('#form-loading').addClass('d-none');
                $('#form-success').removeClass('d-none');
                $('#tambah-barang').loading('stop');

                setTimeout(function () {
                    window.location.replace(baseUrl+'/barang');
                }, 1000)
            }else{
                $('#form-loading').addClass('d-none');
                $('#form-failed').removeClass('d-none');

                $('#tambah-barang').loading('stop');
            }
        }
    })
})

$(document).on('change', '#divisi', function () {
    $('#tambah-barang').loading();

    let id_divisi = $(this).val();

    $.ajax({
        type: 'POST',
        url: baseUrl+'/barang/add_barang_form_get_rak_list',
        dataType: 'json',
        data: {
            id_divisi: id_divisi,
        },
        success: function (response) {
            if(response.status == 'ok'){
                $('#daftar-rak-container').empty()
                response.list.forEach(element => {
                    let html = ''
                    let value = element.split(".")

                    html += `
                        <input type="radio" id="lokasi-${value[0]}-${value[1]}" name="lokasi" value="${element}" />
                        <label for="lokasi-${value[0]}-${value[1]}">${element}</label>
                    `

                    $('#daftar-rak-container').append(html)
                });
            }else{
                console.log(response.status)
            }

            $('#tambah-barang').loading('stop');
        }
    })
})