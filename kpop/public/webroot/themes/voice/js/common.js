function _check_input() {
    var phone = $('#phone').val();
    var password = $('#password').val();
    if (!phone) {
        alert('Vui lòng nhập số điện thoại');
        //$('#mess_error_login').text('Vui lòng nhập số điện thoại');
    } else if (!password) {
        //$('#mess_error_login').text('Vui lòng nhập mật khẩu');
        alert('Vui lòng nhập mật khẩu');
    }else{
        //$('#mess_error_login').text('');
        var url = '/voice/ajaxLogin';
        $.ajax({
            'url': url,
            'data':{phone:phone, password: password},
            'type': 'POST',
            'cache':false,

            'success':function(data){
                data = jQuery.parseJSON(data);
                if(data['error'] == 1){
                    alert(data['message']);
                }else{
                    window.location.href = data['url'];
                }
            }
        });
    }
}


function register() {
    window.location.href = '/voice/register';
}

