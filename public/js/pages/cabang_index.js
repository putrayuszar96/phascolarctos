$(document).ready(function () {
    getCabang();
})

$(document).on('click', '#btn-tambah-cabang', function () {
    $('main').loading();
    $.ajax({
        type: 'POST',
        url: 'cabang/add_cabang_form',
        dataType: 'json',
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

$(document).on('click', '#cancel-form-cabang', function () {
    $('#tambah-cabang').modal('hide');
    $('#tambah-cabang, .modal-backdrop').remove();
})

$(document).on('click', '#submit-form-cabang', function () {
    $('#tambah-cabang').loading();

    let nama = $('#nama').val()
    let alamat = $('#alamat').val()

    $.ajax({
        type: 'POST',
        url: 'user/add_cabang_process',
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

                $('#tambah-cabang').loading('stop');
            }
        }
    })
})

function getCabang()
{
    $('#dataTable').DataTable({
        "processing": true,
        "serverSide": false,
        "order": false,
        'ajax': {
            'type': 'POST',
            'url': 'cabang/list',
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
                targets: [0, 1, 2, 3, 4],
                visible: true
            },
            {
                targets: '_all',
                visible: false
            },
            {
                'targets': 0,
                'data': 'nama',
                'title': 'Nama Kantor',
                'render': function(data, type, row, meta) {
                    return (data != null && data != 'null' && data != '') ? data : '-';
                }
            },
            {
                'targets': 1,
                'data': 'alamat',
                'title': 'Alamat Kantor',
                'render': function(data, type, row, meta) {
                    return (data != null && data != 'null' && data != '') ? data : '-';
                }
            },
            {
                'targets': 2,
                'data': 'jumlah_divisi',
                'title': 'Jumlah Divisi',
                'render': function(data, type, row, meta) {
                    return (data != null && data != 'null' && data != '') ? data + " divisi" : '-';
                }
            },
            {
                'targets': 3,
                'data': 'jumlah_pegawai',
                'title': 'Jumlah Pegawai',
                'render': function(data, type, row, meta) {
                    return (data != null && data != 'null' && data != '') ? data + " pegawai" : '-';
                }
            },
            {
                'targets': 4,
                'data': 'action',
                'title': 'Action',
                'render': function(data, type, row, meta) {
                    var output = `<button type="button" id="update_cabang" data-id="${data.id_ai_cabang}" class="btn btn-warning btn-sm d-block"><i class="fa fa-edit"></i></button>`
                    output += `<button type="button" id="delete_cabang" data-id="${data.id_ai_cabang}" class="btn btn-danger btn-sm d-block"><i class="fa fa-trash"></i></button>`;
                    
                    return output;
                }
            }
        ]
    });
}