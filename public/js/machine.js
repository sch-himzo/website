let pusher = new Pusher('a34e80fa301ec595567d', {
    cluster: 'eu',
    forceTLS: true
});

let previous_state = $('#asdf_state').val();

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

    if(previous_state !== data.message.state){
        let n;
        switch(data.message.state){
            case "0":
                n = new Notification('Hímzés kész', {body: 'Végzett a hímzéssel a hímzőgép :)', dir: 'ltr'});
                break;

            case "1":
                n = new Notification('Hímzés elindítva', {body: 'El lett indítva a hímzőgép', dir: 'ltr'});
                break;

            case "2":
                n = new Notification('Géphiba! :(', {body: 'Valami elbaszódott a hímzőgéppel :( Ajánlott a hímzőgép megtekintése in real life, nehogy para legyen', dir: 'ltr'});
                break;

            case "3":
                n = new Notification('Hímzés kész', {body: 'Végzett a hímzéssel a hímzőgép :)', dir: 'ltr'});
                break;

            case "4":
                n = new Notification('Hímzés megállítva', {body: 'Meg lett állítva a hímzőgép a gombbal', dir: 'ltr'})
                break;

            case "5":
                n = new Notification('Tervezett stop', {body: 'Előre beállított stop következett be, ideje applikálni/cérnát cserélni :)', dir: 'ltr'})
                break;

            case "6":
                n = new Notification('Szálszakadás', {body: 'Szálszakadás more :(', dir:'ltr'});
                break;
        }
        n.onclick = function(event){
            event.preventDefault();
            window.open('http://himzo.sch.bme.hu/machines/status');
        }
    }

    previous_state = data.message.state;
});

channel.bind('machine-dst', function(data){
    if(data.message.new_design === true){
        document.location.reload();
    }
});
