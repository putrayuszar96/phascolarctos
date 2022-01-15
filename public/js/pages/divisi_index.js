var cabang_terpilih = null;
var label_cabang_terpilih = null;

$(document).ready(function () {
    getDivisi();
});

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
    let id_cabang = $('#form-kantor-cabang-hidden').val()

    $.ajax({
        type: 'POST',
        url: 'divisi/add_divisi_process',
        dataType: 'json',
        data: {
            nama: nama,
            id_cabang: id_cabang
        },
        success: function (response) {
            if(response.status == 'ok'){
                $('#form-loading').addClass('d-none');
                $('#form-success').removeClass('d-none');
                $('#tambah-divisi').loading('stop');

                setTimeout(function () {
                    $('#tambah-divisi').modal('hide');
                    $('#tambah-divisi, .modal-backdrop').remove();
                    
                    $('#dataTable').DataTable().clear();
                    $('#dataTable').DataTable().destroy();
                    getDivisi(id_cabang)
                }, 1000)
            }else{
                $('#form-loading').addClass('d-none');
                $('#form-failed').removeClass('d-none');

                $('#tambah-divisi').loading('stop');
            }
        }
    })
})

function getDivisi(cabang)
{
    var divisi_user = $('#divisi-user').val();

    $('#dataTable').DataTable({
        "processing": true,
        "serverSide": false,
        "order": false,
        'ajax': {
            'type': 'POST',
            'url': 'divisi/list',
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
                'data': 'jumlah_pegawai',
                'title': 'Jumlah Pegawai',
                'render': function(data, type, row, meta) {
                    return (data != null && data != 'null' && data != '') ? data : '-';
                }
            },
            {
                'targets': 2,
                'data': 'jumlah_pegawai',
                'title': 'Jumlah Rak',
                'render': function(data, type, row, meta) {
                    return (data != null && data != 'null' && data != '') ? data + " orang" : '-';
                }
            },
            {
                'targets': 3,
                'data': 'action',
                'title': 'Action',
                'render': function(data, type, row, meta) {
                    if(divisi_user == 'ADM'){
                        var output = `<button type="button" id="update_divisi" data-id="${data.id_ai_divisi}" class="btn btn-link text-success btn-sm d-block"><i class="fa fa-edit"></i> Edit</button>`
                        output += `<button type="button" id="delete_divisi" data-id="${data.id_ai_divisi}" class="btn btn-link text-danger btn-sm d-block"><i class="fa fa-trash"></i> Hapus</button>`;
                    }else{
                        var output = '<small><i>No action allowed</i></small>'
                    }
                    
                    return output;
                }
            }
        ]
    });
}

$(document).on('click', '#delete_divisi', function () {
    var id_cabang = $(this).data('id')

    Swal.fire({
        title: 'Anda akan menghapus divisi ini?',
        text: "Anda yakin ingin menghapus divisi ini!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus divisi!',
        preConfirm: () => {
            return fetch(`divisi/delete/${id_cabang}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(response.statusText)
                }
                return response.json()
            })
            .catch(error => {
                Swal.showValidationMessage(
                    `Request failed: ${error}`
                )
            })
        },
        allowOutsideClick: () => !Swal.isLoading()
    })
    .then((result) => {
        if (result.value.isConfirmed) {
            Swal.fire({
                title: `Divisi telah dihapus!`,
                confirmButtonText: `Ok`,
            })
            .then((result) => {
                if(result.isConfirmed){
                    $('#dataTable').DataTable().clear();
                    $('#dataTable').DataTable().destroy();

                    getDivisi(cabang_terpilih)
                }
            })
        }else{
            Swal.fire({
                title: `Divisi ini gagal dihapus!`,
            })
        }
    })
})