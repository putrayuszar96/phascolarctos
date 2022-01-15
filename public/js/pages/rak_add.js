$(document).on('click', '#back-one', function () {
    history.go(-1);
})

$(document).on('change', '#gudang', function () {
    $('#tambah-pemilik').loading();

    let id_rak = $(this).val();

    $.ajax({
        type: 'POST',
        url: baseUrl+'/rak/add_rak_form_get_list',
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

$(document).on('click', '#submit-form-rak', function () {
    $('#tambah-pemilik').loading();

    let id_divisi = $('#divisi').val()
    let rak_milik = []
    $('input[type=checkbox]:checked').each(function () {
        rak_milik.push($(this).val());
    })

    if(id_divisi == '' || rak_milik.length == 0){
        $('#form-empty').removeClass('d-none');
        setTimeout(function () {
            $('#tambah-pemilik').loading('stop');
        }, 1000)

        setTimeout(function () {
            $('#form-empty').addClass('d-none');
        }, 2000)
    }else{
        $.ajax({
            type: 'POST',
            url: baseUrl+'/rak/add_rak_milik_process',
            dataType: 'json',
            data: {
                id_divisi: id_divisi,
                rak_milik: rak_milik
            },
            success: function (response) {
                if(response.status == 'ok'){
                    $('#form-success').removeClass('d-none');
                    setTimeout(function () {
                        window.location.replace(baseUrl+'/rak');
                    }, 1000)
                }else{
                    $('#form-failed').removeClass('d-none');

                    $('#tambah-pemilik').loading('stop');
                }
            }
        })
    }
})