var cabang_terpilih = null;
var label_cabang_terpilih = null;

$(document).ready(function () {
    getCabang();
});

$('#show-kantor-cabang').on('change', function() {
    cabang_terpilih = $(this).val();
    label_cabang_terpilih = $('option:selected', this).data('label')

    getGudang(cabang_terpilih);
})

$(document).on('click', '#btn-tambah-gudang', function () {
    $('main').loading();
    $.ajax({
        type: 'POST',
        url: 'gudang/add_gudang_form',
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
    $('#tambah-gudang').modal('hide');
    $('#tambah-gudang, .modal-backdrop').remove();
})

$(document).on('click', '#submit-form-gudang', function () {
    $('#tambah-gudang').loading();

    let id_cabang = $('#form-kantor-cabang-hidden').val()
    let id_terakhir = $('#form-id-gudang-terakhir').val()
    let nama_gudang = $('#nama-gudang').val()
    let jumlah_rak = $('#jumlah-rak').val()
    let level_rak = $('#level-rak').val()

    $.ajax({
        type: 'POST',
        url: 'gudang/add_gudang_process',
        dataType: 'json',
        data: {
            id_cabang: id_cabang,
            id_terakhir: id_terakhir,
            nama_gudang: nama_gudang,
            jumlah_rak: jumlah_rak,
            level_rak: level_rak
        },
        success: function (response) {
            if(response.status == 'ok'){
                $('#form-loading').addClass('d-none');
                $('#form-success').removeClass('d-none');

                setTimeout(function () {
                    $('#tambah-gudang').modal('hide');
                    $('#tambah-gudang, .modal-backdrop').remove();
                    
                    $('#dataTable').DataTable().clear();
                    $('#dataTable').DataTable().destroy();
                    getGudang(id_cabang)
                }, 1000)
            }else{
                $('#form-loading').addClass('d-none');
                $('#form-failed').removeClass('d-none');

                $('#tambah-gudang').loading('stop');
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

function getGudang(cabang)
{
    $('#dataTable').DataTable({
        "processing": true,
        "serverSide": false,
        "order": false,
        'ajax': {
            'type': 'POST',
            'url': 'gudang/list',
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
                targets: [0, 1, 2, 3, 4],
                visible: true
            },
            {
                targets: '_all',
                visible: false
            },
            {
                'targets': 0,
                'data': 'nama_gudang',
                'title': 'Nama Gudang',
                'render': function(data, type, row, meta) {
                    return (data != null && data != 'null' && data != '') ? data : '-';
                }
            },
            {
                'targets': 1,
                'data': 'jumlah',
                'title': 'Jumlah Rak',
                'render': function(data, type, row, meta) {
                    return (data.level != null && data.level != 'null' && data.level != '') ? data.level + " rak" : '-';
                }
            },
            {
                'targets': 2,
                'data': 'jumlah',
                'title': 'Jumlah Sublevel',
                'render': function(data, type, row, meta) {
                    return (data.sublevel != null && data.sublevel != 'null' && data.sublevel != '') ? data.sublevel + " level" : '-';
                }
            },
            {
                'targets': 3,
                'data': 'jumlah',
                'title': 'Total Rak',
                'render': function(data, type, row, meta) {
                    if(data.sublevel == 'null' || data.sublevel == null){
                        data.sublevel = 0;
                    }

                    return data.level * data.sublevel + ' rak'
                }
            },
            {
                'targets': 4,
                'data': 'action',
                'title': 'Action',
                'render': function(data, type, row, meta) {
                    var output = `<button type="button" id="update_gudang" data-id="${data.id_rak}" class="btn btn-link text-success btn-sm d-block"><i class="fa fa-edit"></i> Edit</button>`
                    output += `<button type="button" id="delete_gudang" data-id="${data.id_rak}" class="btn btn-link text-danger btn-sm d-block"><i class="fa fa-trash"></i> Hapus</button>`;
                    
                    return output;
                }
            }
        ]
    });

    var tampil_gudang = $('#tampilan-gudang').hasClass('d-none');
    if(tampil_gudang == true){
        $('#tampilan-gudang').removeClass('d-none');
    }
}

$(document).on('click', '#delete_gudang', function () {
    var id_rak = $(this).data('id')

    Swal.fire({
        title: 'Anda akan menghapus gudang ini?',
        text: "Anda yakin ingin menghapus gudang ini!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus gudang!',
        preConfirm: () => {
            return fetch(`rak/delete/${id_rak}`)
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
                title: `Gudang telah dihapus!`,
                confirmButtonText: `Ok`,
            })
            .then((result) => {
                if(result.isConfirmed){
                    $('#dataTable').DataTable().clear();
                    $('#dataTable').DataTable().destroy();

                    getGudang(cabang_terpilih)
                }
            })
        }else{
            Swal.fire({
                title: `Gudang ini gagal dihapus!`,
            })
        }
    })
})