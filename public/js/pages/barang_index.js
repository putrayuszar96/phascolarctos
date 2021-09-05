var cabang_terpilih = null;
var label_cabang_terpilih = null;

$(document).ready(function () {
    getCabang();
});

$('#show-kantor-cabang').on('change', function() {
    cabang_terpilih = $(this).val();
    label_cabang_terpilih = $('option:selected', this).data('label')

    let filter = {
        cabang: cabang_terpilih
    }

    getBarang(filter);
})

$(document).on('click', '#btn-tambah-divisi', function () {
    $('main').loading();
    $.ajax({
        type: 'POST',
        url: 'barang/add_barang_form',
        dataType: 'json',
        data: {
            'value': cabang_terpilih,
            'label': label_cabang_terpilih
        },
        success: function (response) {
            $('main').after(response.body);
            $('main').loading('stop');
            $('.modal').modal({
                'show': true,
                'backdrop': 'static',
                'keyboard': false
            });
        }
    })
})

$(document).on('click', '#cancel-form-barang', function () {
    $('#tambah-barang').modal('hide');
    $('#tambah-barang, .modal-backdrop').remove();
})

$(document).on('click', '#submit-form-barang', function () {
    $('#tambah-barang').loading();

    let nama_barang = $('#nama-barang').val();
    let id_cabang = $('#form-kantor-cabang-hidden').val();
    let id_divisi = $('#divisi').val()
    let uploader = $('#uploader').val();
    let status_pinjam = $('#status-pinjam').val();
    let rak_posisi = $('input[type=radio]:checked').val()

    $.ajax({
        type: 'POST',
        url: 'barang/add_barang_process',
        dataType: 'json',
        data: {
            nama_barang: nama_barang,
            id_cabang: id_cabang,
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
                    $('#tambah-barang').modal('hide');
                    $('#tambah-barang, .modal-backdrop').remove();
                    
                    $('#dataTable').DataTable().clear();
                    $('#dataTable').DataTable().destroy();

                    let filter = {
                        'cabang': id_cabang
                    }

                    getBarang(filter)
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
        url: 'barang/add_barang_form_get_rak_list',
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

function getCabang()
{
    $.ajax({
        type: 'POST',
        url: 'cabang/list',
        dataType: 'json',
        success: function (response) {
            if(response.status == 'ok'){
                let data = response.data;
                let option = ''

                data.forEach(cabang => {
                    option += '<option value="'+cabang.action.id_cabang+'" data-label="'+cabang.nama+'">'+cabang.nama+'</option>';
                });

                $('#show-kantor-cabang').append(option);
            }else{
                alert('Tidak ada cabang yang ditemukan! Harap menambahkan cabang terlebih dahulu!')
            }
        }
    })
}

function getBarang(filter)
{
    $('#dataTable').DataTable({
        "processing": true,
        "serverSide": false,
        "order": false,
        'ajax': {
            'type': 'POST',
            'url': 'barang/list',
            'data': function(d){
                d.cabang = filter.cabang
            },
            'dataSrc': function(json) {
                if (json != null) {
                    if (json.status == 'ok') {
                        console.log(json)
                        if (json.hasOwnProperty('data')) return json.data;
                        else return json;
                    } else {
                        if (json.hasOwnProperty('data')) {
                            
                        }
                        return '';
                    }
                } else return '';
            }
        },
        'sAjaxDataProp': '',
        'columnDefs': [{
                targets: [0, 1, 2, 3, 4, 5],
                visible: true
            },
            {
                targets: '_all',
                visible: false
            },
            {
                'targets': 0,
                'data': 'nama_barang',
                'title': 'Nama Barang',
                'render': function(data, type, row, meta) {
                    return (data != null && data != 'null' && data != '') ? data : '-';
                }
            },
            {
                'targets': 1,
                'data': 'nama_divisi',
                'title': 'Divisi',
                'render': function(data, type, row, meta) {
                    return (data != null && data != 'null' && data != '') ? data : '-';
                }
            },
            {
                'targets': 2,
                'data': 'lokasi',
                'title': 'Lokasi Rak',
                'render': function(data, type, row, meta) {
                    return (data != null && data != 'null' && data != '') ? `<span class="badge badge-primary">${data}</span>` : '-';
                }
            },
            {
                'targets': 3,
                'data': 'uploader',
                'title': 'Uploader',
                'render': function(data, type, row, meta) {
                    return (data != null && data != 'null' && data != '') ? data : '-';
                }
            },
            {
                'targets': 4,
                'data': 'status',
                'title': 'Status',
                'render': function(data, type, row, meta) {
                    return (data != null && data != 'null' && data != '') ? (data == 1 ? "Tersedia" : "Dipinjam" ) : '-';
                }
            },
            {
                'targets': 5,
                'data': 'action',
                'title': 'Action',
                'render': function(data, type, row, meta) {
                    var output = `<button type="button" id="update_barang" data-id="${data.uuid}" class="btn btn-warning btn-sm d-block"><i class="fa fa-edit"></i></button>`
                    
                    if(data.status_pinjam == 1){
                        output += `<button type="button" id="btn-pinjam-barang" data-id="${data.uuid}" class="btn btn-success btn-sm d-block my-2"><i class="fa fa-sign-out-alt"></i></button>` 
                    }else{
                        output += `<button type="button" id="btn-kembalikan-barang" data-id="${data.uuid}" class="btn btn-info btn-sm d-block my-2"><i class="fa fa-sign-in-alt"></i></button>` 
                    }
                    output += `<button type="button" id="delete_barang" data-id="${data.uuid}" class="btn btn-danger btn-sm d-block"><i class="fa fa-trash"></i></button>`;
                    
                    return output;
                }
            }
        ]
    });

    var tampil_barang = $('#tampilan-barang').hasClass('d-none');
    if(tampil_barang == true){
        $('#tampilan-barang').removeClass('d-none');
    }
}