$(document).ready(function(){

    max = 5;
    count = 0;
    formGroupStart = '<div class="form-group"> ';
    formGroupEnd = ' </div>';
    invalidForm = '<div class="invalid-feedback">Please provide a valid option: maximum allowed number of characters is 300.</div>';

    $('#add-download').click(function(){

        if(count < max){
            num = count + 1;
            var option = formGroupStart + '<input type="file" class="form-control" name="uploads[' + count + ']" maxlength="200" placeholder="Option ' + num + '..."  />' + formGroupEnd;
            $('.uploads').append(option);
            count++;
        } else{
            alert('Maximum number of uploads has been reached.');
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

      var selectedTags = [];

      $('#tag-input').on('input keyup',
        function getTags() {
          if(this.value){
            var exist = Array();
            var url = window.location.protocol + '//' + document.location.hostname;
            var selectedTagsUl = $('#selected-tags-ul');
            var selectedTagsUlChildren = selectedTagsUl.children('li').each(
              function(){
                exist.push($(this).text());
              }
            );
            jQuery.ajax({
              url: url + "/suggest/tags",
              type: "POST",
              data: {tag:$('#tag-input').val(), exist: exist},
              success:function(data){
                  if(data.status == 'success'){
                    clearAllTags();
                      suggest(data.results);
                      tagClick();
                  } else {
                    clearAllTags();
                  }
              }, error: function(e){
                console.log(e);
              }
            });
          } else {
            clearAllTags();
          }
      });



    function suggest(arr){

      var tagsUl = $('#tags');
      for(let i = 0; i < arr.length; i++){
        var name = arr[i].name;
        var elm = '<li class="list-group-item tags-li" id="tags-li-' + i + '">' + name + '</li>';
        tagsUl.append(elm);
      }
    }

    function tagClick(){
      var hiddenInput = $('#hidden-tag-input');
      $('.tags-li').on('click', function(e){
        let tagName = $(this).text();
        let tag = '<li class="list-group-item list-group-item-primary selected-tags-li">' + tagName + '</li>';
        $('#selected-tags-ul').append(tag);
        selectedTags.push(tagName);
        hiddenInput.val(selectedTags.join(', '));
        $(this).remove();
        deleteOnClick();
      });
    }

    function clearAllTags(){
      var tagsUl = $('#tags');
      tagsUl.empty();
    }

    function deleteOnClick(){
      var hiddenInput = $('#hidden-tag-input');
      var tag = $('.selected-tags-li');
      tag.on('click', function(){
        var text = $(this).text();
        selectedTags = $.grep(selectedTags, function(element, i){
          return element != text;
        });
        hiddenInput.val(selectedTags.join(', '));
        $(this).remove();
      });
    }



    /**
     * 
     * When a type div is clicked in create art or create contest pages
     * 
     */
    $('.select-types').on('click', function(){

      let typeName = $(this).text();
      let inpt = $('#type_field');
      if(typeName.length > 0){
        inpt.val(typeName);
      }

    });
});