
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

    
    $('#edit-form-users').on('submit', function(){
        return confirm('Are you sure that you want to edit this user?');
    });

    $('#delete-form-users-1').on('submit', function(){
        return confirm('Are you sure that you want to delete this user?');
    });

    $('#delete-form-users-2').on('submit', function(){
        return confirm('Are you sure that you want to delete this user?');
    });

    $('#generate-password').on('click', function(){
        return confirm('Are you sure that you want to generate a new password for this user?');
    });

    $('#edit-form-roles').on('submit', function(){
        return confirm('Are you sure that you want to edit this role?');
    });

    $('#delete-form-roles-1').on('submit', function(){
        return confirm('Are you sure that you want to delete this role?');
    });

    $('#delete-form-roles-2').on('submit', function(){
        return confirm('Are you sure that you want to delete this role?');
    });

    $('#edit-form-permissions').on('submit', function(){
        return confirm('Are you sure that you want to edit this permission?');
    });

    $('#delete-form-permissions-1').on('submit', function(){
        return confirm('Are you sure that you want to delete this permission?');
    });

    $('#delete-form-permissions-2').on('submit', function(){
        return confirm('Are you sure that you want to delete this permission?');
    });


});