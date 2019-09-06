$(document).ready(function(){

    max = 4;
    count = 0;
    formGroupStart = '<div class="form-group"> ';
    formGroupEnd = ' </div>';
    invalidForm = '<div class="invalid-feedback">Please provide a valid option: maximum allowed number of characters is 300.</div>';

    $('#add-option').click(function(){

        if(count < max){
            num = count + 1;
            var option = formGroupStart + '<input type="text" class="form-control" name="options[' + count + ']" maxlength="200" placeholder="Option ' + num + '..."  />' + formGroupEnd;
            $('.options').append(option);
            count++;
        } else{
            alert('Maximum number of options has been reached.');
        }

    }); 


    window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('needs-validation');
        var validation = Array.prototype.filter.call(forms, function(form) {
          form.addEventListener('submit', function(event) {
            if (form.checkValidity() === false) {
              event.preventDefault();
              event.stopPropagation();
            }
            form.classList.add('was-validated');
          }, false);
        });
      }, false);



      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      $('#username').on('keyup',

        function checkusername() {
          var url = window.location.href;
          jQuery.ajax({
            url: url + "/checkusername",
            type: "POST",
            data: {username:$('#username').val()},
            success:function(data){
              if(data.status == 'success'){
                $('#username').removeClass('is-invalid');
                $('#username').addClass('is-valid');
                
              } else {
                $('#username').removeClass('is-valid');
                $('#username').addClass('is-invalid');
                
              }
            },
            error:function (e){
              console.log(e);
            }
          });
        }

      );

});