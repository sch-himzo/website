function currentUsers(){
    var users_table = $('#users_table');
    var token = $('#token').val();
    var url = $('#users_url').val();
    var current_user = $('#current_user_id').val();
    var button_container = $('#btn-container');

    $.ajax({
        url: url,
        method: "POST",
        data: {_token: token},
        dataType: 'json',
        success: function(c){

            out = "";
            button = "";
            if(current_user!=="false" && c.ids.includes(parseInt(current_user))){
                button = "<a href='/user/out' class='btn btn-sm btn-danger'>ELmentem</a>";
            }else{
                button = "<a href='/user/in' class='btn btn-sm btn-success'>Itt vagyok!</a>";
            }

            if(current_user!=="false"){
                button_container.html(button);
            }

            c.users.forEach(function(e){
                out += "<tr>" +
                    "<td style='padding:10px; font-size:16px;'>" + e + "</td>" +
                    "</tr>";
            });

            if(out===""){
                out="<tr>" +
                    "<td style='padding:10px; font-size:16px; font-style:italic;'>Nincs most itt senki :(" +
                    "</td>" +
                    "</tr>";
            }

            users_table.html(out);
        },
        error: function(e){
            console.log(e);
        }
    });
}

$(document).ready(function(){
    currentUsers();
    window.setInterval(currentUsers,500);
});
