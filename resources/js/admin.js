
$(document).ready(function(){
    $('#edit-button').click(function(){
        forms = $('.enabled-disabled');
        for(i = 0; i < forms.length; i++){

            if(forms[i].disabled){
                forms[i].disabled = false;
            } else {
                forms[i].disabled = true;
            }
        }
    });

});