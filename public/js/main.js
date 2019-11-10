function checkEmail(email){
    url = $('#register_url').val();
    token = $('#_token').val();
    email_group = $('#email_group');
    submit_button = $('#submit_button');

    $.ajax({
        url: url,
        method: "POST",
        data: {email: email, _token: token},
        dataType: 'json',
        success: function(c){
            if(c.success==true){
                email_group.removeAttr('class');
                email_group.attr('class','form-group has-success has-feedback');
                submit_button.removeAttr('disabled');
            }else{
                email_group.removeAttr('class');
                email_group.attr('class', 'form-group has-error has-feedback');
                submit_button.attr('disabled',true);
            }
        },
        error: function(e){
            email_group.removeAttr('class');
            email_group.attr('class','form-group has-error has-feedback');
            submit_button.attr('disabled',true);
        }
    });
}

function checkPassword(password){
    url = $('#password_url').val();
    token = $('#_token').val();
    password_group = $('#password_group');
    requirements = $('#requirements');
    reasons = [
        'length','number','capitals','specials'
    ];

    requirements.css('display','block');

    $.ajax({
        url: url,
        method: "POST",
        data: {password: password, _token:token},
        dataType: 'json',
        success: function(c){
            if(c.password==="ok"){
                password_group.removeAttr('class');
                password_group.attr('class','form-group has-success');
                reasons.forEach(function(e){
                    $('#' + e).css('color','green');
                    $('#' + e + '_response').attr('class','fa fa-check');
                })
            }else{
                password_group.removeAttr('class');
                password_group.attr('class','form-group has-error');
                reasons.forEach(function(e){
                    if(c.reason.includes(e)){
                        $('#' + e).css('color','red');
                        $('#' + e + '_response').attr('class','fa fa-times');
                    }else{
                        $('#' + e).css('color','green');
                        $('#' + e + '_response').attr('class','fa fa-check');
                    }
                });
            }
        },
        error: function(e){
            console.log(e);
        }

    });
}

function checkSecondPassword(password1, password2){
    if(password1 === password2){
        $('#password2_group').attr('class','form-group has-success');
    }else{
        $('#password2_group').attr('class','form-group has-error');
    }
}

var email_field = $('#email_register');
var password_field = $('#password');
var password2_field = $('#password2');


email_field.on('keyup',function(){
    checkEmail(email_field.val());
});

password_field.on('keyup', function(){
    checkPassword(password_field.val());
});

password2_field.on('keyup', function(){
    checkSecondPassword(password_field.val(), password2_field.val());
});
