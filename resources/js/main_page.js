$(document).ready(function(){

    var btn = $('#report-btn');

    btn.on('click', function(e){
        e.preventDefault();
        console.log('its working');
        $('#reportModal').modal('show');
    });


});