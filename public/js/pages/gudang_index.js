$(document).ready(function () {
    getGudang();
});

function getGudang()
{
    var divisi = $('#divisi-user').val();
    
    $('#dataTable').DataTable({
        "processing": true,
        "serverSide": false,
        "order": false,
        'ajax': {
            'type': 'POST',
            'url': baseUrl+'/gudang/list',
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
                'data': 'nama_gudang',
                'title': 'Nama Gudang',
                'render': function(data, type, row, meta) {
                    return (data != null && data != 'null' && data != '') ? data : '-';
                }
            },
            {
                'targets': 1,
                'data': 'kode_gudang',
                'title': 'Kode Gudang',
                'render': function(data, type, row, meta) {
                    return (data != null && data != 'null' && data != '') ? data : '-';
                }
            },
            {
                'targets': 2,
                'data': 'jumlah',
                'title': 'Jumlah Rak',
                'render': function(data, type, row, meta) {
                    return (data.level != null && data.level != 'null' && data.level != '') ? data.level + " rak" : '-';
                }
            },
            {
                'targets': 3,
                'data': 'jumlah',
                'title': 'Jumlah Sublevel',
                'render': function(data, type, row, meta) {
                    return (data.sublevel != null && data.sublevel != 'null' && data.sublevel != '') ? data.sublevel + " level" : '-';
                }
            },
            {
                'targets': 4,
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
                'targets': 5,
                'data': 'action',
                'title': 'Action',
                'render': function(data, type, row, meta) {
                    if(divisi == 'ADM'){
                        var output = `<button type="button" id="update_gudang" data-id="${data.id_rak}" class="btn btn-link text-success btn-sm d-block"><i class="fa fa-edit"></i> Edit</button>`
                        output += `<button type="button" id="delete_gudang" data-id="${data.id_rak}" class="btn btn-link text-danger btn-sm d-block"><i class="fa fa-trash"></i> Hapus</button>`;
                    }else{
                        var output = '<small><i>No action allowed</i></small>'
                    }
                    
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
            return fetch(`gudang/delete/${id_rak}`)
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

                    getGudang()
                }
            })
        }else{
            Swal.fire({
                title: `Gudang ini gagal dihapus!`,
            })
        }
    })
})