$(document).ready(function () {
    getDivisi();
});

function getDivisi()
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
    var id_divisi = $(this).data('id')

    Swal.fire({
        title: 'Anda akan menghapus divisi ini?',
        text: "Anda yakin ingin menghapus divisi ini!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus divisi!',
        preConfirm: () => {
            return fetch(`divisi/delete/${id_divisi}`)
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

                    getDivisi()
                }
            })
        }else{
            Swal.fire({
                title: `Divisi ini gagal dihapus!`,
            })
        }
    })
})