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

      var selectedTags = [];

      $('#tag-input').on('input keyup',
        function getTags() {
          if(this.value){
            var exist = Array();
            var url = document.location.href;
            var selectedTagsUl = $('#selected-tags-ul');
            var selectedTagsUlChildren = selectedTagsUl.children('li').each(
              function(){
                exist.push($(this).text());
              }
            );
            jQuery.ajax({
              url: url + "/tags",
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
              },
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
        console.log(selectedTags);
        $(this).remove();
        deleteOnClick();
      });
    }

    function clearAllTags(){
      var tagsUl = $('#tags');
      tagsUl.empty();
    }

    function deleteOnClick(){
      var valueArr = $('#hidden-tag-input').val();
      var tag = $('.selected-tags-li');
      tag.on('click', function(){
        var text = $(this).text();
        selectedTags = $.grep(selectedTags, function(element, i){
          return element != text;
        });
        $(this).remove();
        console.log(selectedTags);
      });
    }

  
});