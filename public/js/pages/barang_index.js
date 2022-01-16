var cabang_terpilih = null;
var label_cabang_terpilih = null;

$(document).ready(function () {
    getBarang()
});

function getBarang()
{
    var divisi_user = $('#divisi-user').val();

    $('#dataTable').DataTable({
        "processing": true,
        "serverSide": false,
        "order": false,
        'ajax': {
            'type': 'POST',
            'url': 'barang/list',
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
                'data': 'action',
                'title': 'Status',
                'render': function(data, type, row, meta) {
                    var output = '';

                    if(data.status == 1){
                        output += '<span class="d-block">Tersedia</span>'
                    }else{
                        output += '<span class="d-block">Dipinjam</span>'
                    }

                    output += `<button type="button" id="cek_status" data-id="${data.uuid}" class="btn d-block my-2 btn-link text-info"><i class="fa fa-eye"></i> Cek Status Log</button>`

                    return output;
                }
            },
            {
                'targets': 5,
                'data': 'action',
                'title': 'Action',
                'render': function(data, type, row, meta) {
                    var output = `<button type="button" id="update_barang" data-id="${data.uuid}" class="btn btn-sm d-block btn-link text-success"><i class="fa fa-edit"></i> Update Barang</button>`
                    
                    if(data.status == 1){
                        output += `<button type="button" id="pinjam_barang" data-id="${data.uuid}" class="btn btn-sm d-block my-2 btn-link text-info"><i class="fa fa-sign-out-alt"></i> Pinjam Barang</button>` 
                    }else{
                        output += `<button type="button" id="kembali_barang" data-id="${data.uuid}" class="btn btn-sm d-block my-2 btn-link text-info"><i class="fa fa-sign-out-alt"></i> Kembali Barang</button>` 
                    }
                    output += `<button type="button" id="delete_barang" data-id="${data.uuid}" class="btn btn-sm d-block btn-link text-danger"><i class="fa fa-trash"></i> Hapus Barang</button>`;

                    if(divisi_user != 'ADM'){
                        output = '<small><i>No action allowed</i></small>'
                    }
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

$(document).on('click', '#cek_status', function () {
    var uuid_barang = $(this).data('id')

    $('main').loading();
    $.ajax({
        type: 'POST',
        url: 'barang/show_status_log',
        dataType: 'json',
        data: {
            'uuid': uuid_barang
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

$(document).on('click', '#log-peminjaman-close', function () {
    $('.modal').modal('hide');
    $('.modal, .modal-backdrop').remove();
})

$(document).on('click', '#pinjam_barang', function () {
    var uuid_barang = $(this).data('id')

    Swal.fire({
        title: 'Anda akan meminjam barang ini?',
        text: "Barang ini akan anda pinjam!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, pinjam barang!',
        preConfirm: () => {
            return fetch(`barang/pinjam_barang/${uuid_barang}`)
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
                title: `Barang ini anda pinjam!`,
                confirmButtonText: `Ok`,
            })
            .then((result) => {
                if(result.isConfirmed){
                    let filter = {
                        cabang: cabang_terpilih
                    }

                    $('#dataTable').DataTable().clear();
                    $('#dataTable').DataTable().destroy();

                    getBarang(filter)
                }
            })
        }else{
            Swal.fire({
                title: `Barang ini gagal dipinjam!`,
            })
        }
    })
})

$(document).on('click', '#kembali_barang', function () {
    var uuid_barang = $(this).data('id')

    Swal.fire({
        title: 'Anda akan mengembalikan barang ini?',
        text: "Barang ini akan anda kembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, kembalikan barang!',
        preConfirm: () => {
            return fetch(`barang/kembali_barang/${uuid_barang}`)
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
                title: `Barang ini anda kembalikan!`,
                confirmButtonText: `Ok`,
            })
            .then((result) => {
                if(result.isConfirmed){
                    let filter = {
                        cabang: cabang_terpilih
                    }
                    
                    $('#dataTable').DataTable().clear();
                    $('#dataTable').DataTable().destroy();

                    getBarang(filter)
                }
            })
        }else{
            Swal.fire({
                title: `Barang ini gagal dikembalikan!`,
            })
        }
    })
})

$(document).on('click', '#delete_barang', function () {
    var id_cabang = $(this).data('id')
    let filter = {
        cabang: cabang_terpilih
    }

    Swal.fire({
        title: 'Anda akan menghapus berkas ini?',
        text: "Anda yakin ingin menghapus berkas ini!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus berkas!',
        preConfirm: () => {
            return fetch(`barang/delete/${id_cabang}`)
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
                title: `Berkas telah dihapus!`,
                confirmButtonText: `Ok`,
            })
            .then((result) => {
                if(result.isConfirmed){
                    $('#dataTable').DataTable().clear();
                    $('#dataTable').DataTable().destroy();

                    getBarang(filter)
                }
            })
        }else{
            Swal.fire({
                title: `Berkas ini gagal dihapus!`,
            })
        }
    })
})