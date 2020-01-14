
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

    $('#delete-form-users').on('submit', function(){
        return confirm('Are you sure that you want to delete this user?');
    });

    $('#generate-password').on('click', function(){
        return confirm('Are you sure that you want to generate a new password for this user?');
    });

    $('#edit-form-roles').on('submit', function(){
        return confirm('Are you sure that you want to edit this role?');
    });

    $('#delete-form-roles').on('submit', function(){
        return confirm('Are you sure that you want to delete this role?');
    });

    $('#edit-form-permissions').on('submit', function(){
        return confirm('Are you sure that you want to edit this permission?');
    });

    $('#delete-form-permissions').on('submit', function(){
        return confirm('Are you sure that you want to delete this permission?');
    });

    $('#delete-prequestion').on('submit', function(){
        return confirm('Are you sure that you want to delete this question?');
    });

    $('#add-prequestion').click(function(){
        if(confirm('Are you sure that you want to approve this question?')){
            forms = $('.enabled-disabled');
            for(i = 0; i < forms.length; i++){

                if(forms[i].disabled){
                    forms[i].disabled = false;
                }
            }

            $('#add-prequestion-form').submit();

        } else{
            return false;
        }
    });

    $('#edit-form-tags').on('submit', function(){
        return confirm('Are you sure that you want to edit this tag?');
    });

    $('#delete-form-tags').on('submit', function(){
        return confirm('Are you sure that you want to delete this tag?');
    });

    $('#edit-form-reports').on('submit', function(){
        return confirm('Are you sure that you want to edit this report?');
    });

    $('#delete-form-reports').on('submit', function(){
        return confirm('Are you sure that you want to delete this report?');
    });

    $('#edit-form-categories').on('submit', function(){
        return confirm('Are you sure that you want to edit this category?');
    });

    $('#delete-form-categories').on('submit', function(){
        return confirm('Are you sure that you want to delete this category?');
    });

    $('#edit-form-reports').on('submit', function(){
        return confirm('Are you sure that you want to edit this report?');
    });

    $('#delete-form-reports').on('submit', function(){
        return confirm('Are you sure that you want to delete this report?');
    });

    $('#edit-form-answers').on('submit', function(){
        return confirm('Are you sure that you want to edit this answer?');
    });

    $('#delete-form-answers').on('submit', function(){
        return confirm('Are you sure that you want to delete this answer?');
    });
    
    
});