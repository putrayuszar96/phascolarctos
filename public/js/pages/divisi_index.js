var cabang_terpilih = null;
var label_cabang_terpilih = null;

$(document).ready(function () {
    getCabang();
});

$('#show-kantor-cabang').on('change', function() {
    cabang_terpilih = $(this).val();
    label_cabang_terpilih = $('option:selected', this).data('label')

    getDivisi(cabang_terpilih);
})

$(document).on('click', '#btn-tambah-divisi', function () {
    $('main').loading();
    $.ajax({
        type: 'POST',
        url: 'divisi/add_divisi_form',
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

$(document).on('click', '#cancel-form-divisi', function () {
    $('#tambah-divisi').modal('hide');
    $('#tambah-divisi, .modal-backdrop').remove();
})

$(document).on('click', '#submit-form-divisi', function () {
    $('#tambah-divisi').loading();

    let nama = $('#nama').val()
    let alamat = $('#alamat').val()

    $.ajax({
        type: 'POST',
        url: 'user/add_divisi_process',
        dataType: 'json',
        data: {
            nama: nama,
            alamat: alamat
        },
        success: function (response) {
            if(response.status == 'ok'){
                $('#form-loading').addClass('d-none');
                $('#form-success').removeClass('d-none');

                setTimeout(function () {
                    location.reload()
                }, 1000)
            }else{
                $('#form-loading').addClass('d-none');
                $('#form-failed').removeClass('d-none');

                $('#tambah-divisi').loading('stop');
            }
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

function getDivisi(cabang)
{
    console.log(cabang)
    $('#dataTable').DataTable({
        "processing": true,
        "serverSide": false,
        "order": false,
        'ajax': {
            'type': 'POST',
            'url': 'divisi/list',
            'data': function(d){
                d.cabang = cabang
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
                targets: [0, 1, 2, 3],
                visible: true
            },
            {
                targets: '_all',
                visible: false
            },
            {
                'targets': 0,
                'data': 'nama',
                'title': 'Nama Divisi',
                'render': function(data, type, row, meta) {
                    return (data != null && data != 'null' && data != '') ? data : '-';
                }
            },
            {
                'targets': 1,
                'data': 'nama_cabang',
                'title': 'Kantor Cabang',
                'render': function(data, type, row, meta) {
                    return (data != null && data != 'null' && data != '') ? data : '-';
                }
            },
            {
                'targets': 2,
                'data': 'jumlah_pegawai',
                'title': 'Jumlah Pegawai',
                'render': function(data, type, row, meta) {
                    return (data != null && data != 'null' && data != '') ? data + " orang" : '-';
                }
            },
            {
                'targets': 3,
                'data': 'action',
                'title': 'Action',
                'render': function(data, type, row, meta) {
                    var output = `<button type="button" id="update_divisi" data-id="${data.id_ai_divisi}" class="btn btn-warning btn-sm d-block"><i class="fa fa-edit"></i></button>`
                    output += `<button type="button" id="delete_divisi" data-id="${data.id_ai_divisi}" class="btn btn-danger btn-sm d-block"><i class="fa fa-trash"></i></button>`;
                    
                    return output;
                }
            }
        ]
    });

    var tampil_divisi = $('#tampilan-divisi').hasClass('d-none');
    if(tampil_divisi == true){
        $('#tampilan-divisi').removeClass('d-none');
    }
}