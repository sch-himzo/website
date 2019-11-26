var token = $('#_token').val();
var search_url = $('#url').val();

function setuser(id,name,email){
    $('#name').val(name);
    $('#autocomplete').css('display','none');
    $('#user_id').val(id);
    $('#email').val(email);
}

$('#name').on('paste keyup click',function(){
    data = {
        'name':$('#name').val(),
        '_token':token
    };
    url = search_url;

    $.ajax({
        url: url,
        data: data,
        dataType: 'json',
        type: 'POST',
        success: function(e){
            autocomplete = "";

            e.forEach(function(c){
                autocomplete += "<a onclick=\"setuser(" + c.id + ",\'" + c.name + "\',\'" + c.email + "\')\" href=\"#\" class=\"auto-link\">" + c.name + "</a>";
            });

            $('#autocomplete').css('display','block');
            $('#autocomplete').html(autocomplete);
        },
        error: function(c){
            console.log(c);
        }
    });
});
