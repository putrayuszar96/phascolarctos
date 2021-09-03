$(document).ready(function () {
    getPegawai();
})

$(document).on('click', '#btn-tambah-pegawai', function () {
    $('main').loading();
    $.ajax({
        type: 'POST',
        url: 'user/add_user_form',
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

$(document).on('click', '#cancel-form-pegawai', function () {
    $('#tambah-pegawai').modal('hide');
    $('#tambah-pegawai, .modal-backdrop').remove();
})

$(document).on('click', '#submit-form-pegawai', function () {
    $('#tambah-pegawai').loading();

    let username = $('#username').val();
    let nama_lengkap = $('#nama-pegawai').val();
    let email = $('#email').val()
    let cabang = $('#cabang').val()
    let divisi = $('#divisi').val()

    $.ajax({
        type: 'POST',
        url: 'user/add_user_process',
        dataType: 'json',
        data: {
            username: username,
            nama_lengkap: nama_lengkap,
            email: email,
            cabang: cabang,
            divisi: divisi,
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

                $('#tambah-pegawai').loading('stop');
            }
        }
    })
})

function getPegawai()
{
    $('#dataTable').DataTable({
        "processing": true,
        "serverSide": false,
        "order": false,
        'ajax': {
            'type': 'POST',
            'url': 'user/list',
            'dataSrc': function(json) {
                if (json != null) {
                    if (json.status == 'ok') {
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
                'data': 'nama_lengkap',
                'title': 'Nama Pegawai',
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
                'data': 'nama_divisi',
                'title': 'Divisi',
                'render': function(data, type, row, meta) {
                    return (data != null && data != 'null' && data != '') ? data : '-';
                }
            },
            {
                'targets': 3,
                'data': 'status',
                'title': 'Status',
                'render': function(data, type, row, meta) {
                    return (data == 1) ? "Aktif" : "Tidak Aktif"
                }
            },
            {
                'targets': 4,
                'data': 'action',
                'title': 'Action',
                'render': function(data, type, row, meta) {
                    var output = `<button type="button" id="update_pegawai" data-id="${data.id}" class="btn btn-warning btn-sm d-block"><i class="fa fa-edit"></i></button>`
                    output += `<button type="button" id="delete_pegawai" data-id="${data.id}" class="btn btn-danger btn-sm d-block"><i class="fa fa-trash"></i></button>`;
                    
                    return output;
                }
            }
        ]
    });
}