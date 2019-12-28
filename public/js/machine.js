Pusher.logToConsole = true;

let pusher = new Pusher('a34e80fa301ec595567d', {
    cluster: 'eu',
    forceTLS: true
});

let channel = pusher.subscribe('machine-update');
channel.bind('machine-update', function(data){
    let dropdown = "";
    let percentage = Math.round(data.message.current_stitch*10000/data.message.total_stitches)/100;
    if(data.message.status==="Fut"){
        dropdown = '<i class="fa fa-cash-register"></i> &raquo; ' + data.message.status + ' &raquo; ' + percentage + '%';
    }else{
        dropdown = '<i class="fa fa-cash-register"></i> &raquo; ' + data.message.status;
    }

    $('#machine_dropdown').html(dropdown);
    $('#machine_progress').html(percentage + '%');
    $('#machine_progress').css('width',percentage + '%');
    $('#machine_progress').attr('class',data.message.progress_bar);
    $('#machine_state').html(data.message.status);
    $('#machine_stitches').html(data.message.total_stitches + "/" + data.message.current_stitch + " öltés");
});

channel.bind('machine-dst', function(data){
    if(data.message.new_design === true){
        document.location.reload();
    }
});
