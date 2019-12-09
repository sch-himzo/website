var search_field = $('#design');
var buttons = $('#buttons');
var order_id = $('#order_id').val();
var html = "";

search_field.on('keyup paste click', function(){
    url = $('#design_url').val();
    token = $('#_token').val();

    $.ajax({
        url: url,
        data: {
            search: search_field.val(),
            _token: token
        },
        type: "POST",
        dataType: 'json',
        success:function(e){
            if(e.empty!==true){
                html="";
                e.forEach(function(element){
                    html += "<a href=\"/designs/" + element.id + "/order/" + order_id + "\" class='modal-big-link'>" +
                        element.name +
                        "</a>";
                });

                buttons.html(html);
            }else{
                buttons.html("");
            }
        }
    });
});
