
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

        if($('#generate-password').hasClass('disabled')){
            $('#generate-password').removeClass('disabled');
        }else{
            $('#generate-password').addClass('disabled');
        }
    });

    
    $('#edit-form').on('submit', function(){
        return confirm('Are you sure that you want to edit this user?');
    });

    $('#delete-form-1').on('submit', function(){
        return confirm('Are you sure that you want to delete this user?');
    });

    $('#delete-form-2').on('submit', function(){
        return confirm('Are you sure that you want to delete this user?');
    });

    $('#generate-password').on('click', function(){
        return confirm('Are you sure that you want to generate a new password for this user?');
    });

});