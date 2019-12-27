function updateProgressBar(){
    let token = $('#asdf_token').val();
    let url = $('#asdf_url').val();

    $.ajax({
        url: url,
        data: {_token: token},
        dataType: 'json',
        method: "POST",
        success: function(e){
            let dropdown = "";
            let percentage = Math.round(e.current_stitch*10000/e.total_stitches)/100;
            if(e.state==="Fut"){
                dropdown = '<i class="fa fa-cash-register"></i> &raquo; ' + e.state + ' &raquo; ' + percentage + '%';
            }else{
                dropdown = '<i class="fa fa-cash-register"></i> &raquo; ' + e.state;
            }

            $('#machine_dropdown').html(dropdown);
            $('#machine_progress').html(percentage + '%');
            $('#machine_progress').css('width',percentage + '%');
            $('#machine_progress').attr('class',e.progress_bar);
            $('#machine_state').html(e.state);
            $('#machine_stitches').html(e.total_stitches + "/" + e.current_stitch + " öltés");
        },
        error: function(e){
            console.log(e);
        }
    });
}

setInterval(updateProgressBar, 2000);

