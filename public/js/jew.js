$('[id^=amount_]').on('keyup paste',function(e,_){
    id = e.target.attributes.id.nodeValue.replace('amount_','');


    original_value = $('#original_' + id).val();

    to_add = $('#' + e.target.attributes.id.nodeValue).val();

    if(to_add === "")
    {
        to_add = 0;
    }
    add_to = $('#original_' + id).val();

    value = parseInt(add_to) + parseInt(to_add);

    $('#balance_' + id).val(value);
});
