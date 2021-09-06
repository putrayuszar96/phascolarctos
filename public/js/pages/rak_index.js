var cabang_terpilih = null;
var label_cabang_terpilih = null;

$(document).ready(function () {
    getCabang();
});

$('#show-kantor-cabang').on('change', function() {
    cabang_terpilih = $(this).val();
    label_cabang_terpilih = $('option:selected', this).data('label')

    getRak(cabang_terpilih);
})

$(document).on('click', '#btn-tambah-rak', function () {
    $('main').loading();
    $.ajax({
        type: 'POST',
        url: 'rak/add_rak_form',
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

$(document).on('click', '#cancel-form-rak', function () {
    $('#tambah-pemilik').modal('hide');
    $('#tambah-pemilik, .modal-backdrop').remove();
    $('#gudang').val('null').change();
    $('#daftar-rak-container').empty();
})

$(document).on('click', '#submit-form-rak', function () {
    $('#tambah-pemilik').loading();

    let id_cabang = $('#form-kantor-cabang-hidden').val();
    let id_divisi = $('#divisi').val()
    let rak_milik = []
    $('input[type=checkbox]:checked').each(function () {
        rak_milik.push($(this).val());
    })

    $.ajax({
        type: 'POST',
        url: 'rak/add_rak_milik_process',
        dataType: 'json',
        data: {
            id_cabang: id_cabang,
            id_divisi: id_divisi,
            rak_milik: rak_milik
        },
        success: function (response) {
            if(response.status == 'ok'){
                setTimeout(function () {
                $('#tambah-pemilik').modal('hide');
                $('#tambah-pemilik, .modal-backdrop').remove();
                $('#tambah-pemilik').loading('stop');
                
                $('#dataTable').DataTable().clear();
                $('#dataTable').DataTable().destroy();

                getRak(id_cabang)
            }, 1000)
            }else{
                $('#form-loading').addClass('d-none');
                $('#form-failed').removeClass('d-none');

                $('#tambah-pemilik').loading('stop');
            }
        }
    })
})

$(document).on('change', '#gudang', function () {
    $('#tambah-pemilik').loading();

    let id_rak = $(this).val();

    $.ajax({
        type: 'POST',
        url: 'rak/add_rak_form_get_list',
        dataType: 'json',
        data: {
            id_rak: id_rak,
        },
        success: function (response) {
            if(response.status == 'ok'){
                $('#daftar-rak-container').empty()
                response.list.forEach(element => {
                    let html = ''
                    let value = element.split(".")

                    html += `
                        <input type="checkbox" id="list-${value[0]}-${value[1]}" name="list[]" value="${element}" />
                        <label for="list-${value[0]}-${value[1]}">${element}</label>
                    `

                    $('#daftar-rak-container').append(html)
                });
            }else{
                console.log(response.status)
            }

            $('#tambah-pemilik').loading('stop');
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

function getRak(cabang)
{
    console.log(cabang)
    $('#dataTable').DataTable({
        "processing": true,
        "serverSide": false,
        "order": false,
        'ajax': {
            'type': 'POST',
            'url': 'rak/list',
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
                    var output = `<button type="button" id="update_pemilik" data-id="${data.id_rak}" class="btn btn-link text-success btn-sm d-block"><i class="fa fa-edit"></i> Edit</button>`
                    output += `<button type="button" id="delete_pemilik" data-id="${data.id_rak}" class="btn btn-link text-danger btn-sm d-block"><i class="fa fa-trash"></i> Hapus</button>`;
                    
                    return output;
                }
            }
        ]
    });

    var tampil_rak = $('#tampilan-rak').hasClass('d-none');
    if(tampil_rak == true){
        $('#tampilan-rak').removeClass('d-none');
    }
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

                    getRak(cabang_terpilih)
                }
            })
        }else{
            Swal.fire({
                title: `Rak ini gagal dihapus!`,
            })
        }
    })
})
