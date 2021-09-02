$(document).on('click', '#do-login', function () {
    let email = $('#email').val();
    let password = $('#password').val();

    $('#processing').removeClass('d-none');

    $.ajax({
        type: "POST",
        url: "auth/do_login",
        dataType: 'json',
        data: {
            'email': email,
            'password': password
        },
        success: function (response) {
            console.log(response)
            if(response.status == 'ok'){
                $('#processing').addClass('d-none');
                $('#success').removeClass('d-none');
            }else{
                let message = ' (Kesalahan: <span>'+response.data.data+'</span>)'
                $('#processing').addClass('d-none');
                $('#failed').removeClass('d-none');
                $('#failed').append(message)
            }
        }
    })
})