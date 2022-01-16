$(document).ready(function () {
    getRak();
});

function getRak()
{
    var divisi = $('#divisi-user').val();

    $('#dataTable').DataTable({
        "processing": true,
        "serverSide": false,
        "order": false,
        'ajax': {
            'type': 'POST',
            'url': baseUrl+'/rak/list',
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
                'data': 'nama_divisi',
                'title': 'Nama Divisi',
                'render': function(data, type, row, meta) {
                    return (data != null && data != 'null' && data != '') ? data : '-';
                }
            },
            {
                'targets': 1,
                'data': 'jumlah_rak',
                'title': 'Jumlah Rak',
                'render': function(data, type, row, meta) {
                    return (data != null && data != 'null' && data != '') ? data + " rak" : '-';
                }
            },
            {
                'targets': 2,
                'data': 'rak',
                'title': 'Daftar Rak',
                'render': function(data, type, row, meta) {
                    let html = '';
                    let list = data.split('##');

                    list.forEach(element => {
                        html += `<span class="badge badge-primary mx-2 my-1">${element}</span>`
                    })

                    return html
                }
            },
            {
                'targets': 3,
                'data': 'action',
                'title': 'Action',
                'render': function(data, type, row, meta) {
                    if(divisi == 'ADM'){
                        var output = `<button type="button" id="update_pemilik" data-id="${data.id_rak}" class="btn btn-link text-success btn-sm d-block"><i class="fa fa-edit"></i> Edit</button>`
                        output += `<button type="button" id="delete_pemilik" data-id="${data.id_rak}" class="btn btn-link text-danger btn-sm d-block"><i class="fa fa-trash"></i> Hapus</button>`;
                    }else{
                        var output = '<small><i>No action allowed</i></small>'
                    }
                    
                    return output;
                }
            }
        ]
    });
}

$(document).on('click', '#delete_pemilik', function () {
    var id_rak = $(this).data('id')

    Swal.fire({
        title: 'Anda akan menghapus rak ini?',
        text: "Anda yakin ingin menghapus rak ini!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus rak!',
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
                title: `Rak telah dihapus!`,
                confirmButtonText: `Ok`,
            })
            .then((result) => {
                if(result.isConfirmed){
                    $('#dataTable').DataTable().clear();
                    $('#dataTable').DataTable().destroy();

                    getRak()
                }
            })
        }else{
            Swal.fire({
                title: `Rak ini gagal dihapus!`,
            })
        }
    })
})
