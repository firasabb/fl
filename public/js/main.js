/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 2);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/main.js":
/*!******************************!*\
  !*** ./resources/js/main.js ***!
  \******************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {
  max = 4;
  count = 0;
  formGroupStart = '<div class="form-group"> ';
  formGroupEnd = ' </div>';
  invalidForm = '<div class="invalid-feedback">Please provide a valid option: maximum allowed number of characters is 300.</div>';
  $('#add-option').click(function () {
    if (count < max) {
      num = count + 1;
      var option = formGroupStart + '<input type="text" class="form-control" name="options[' + count + ']" maxlength="200" placeholder="Option ' + num + '..."  />' + formGroupEnd;
      $('.options').append(option);
      count++;
    } else {
      alert('Maximum number of options has been reached.');
    }
  });
  window.addEventListener('load', function () {
    var forms = document.getElementsByClassName('needs-validation');
    var validation = Array.prototype.filter.call(forms, function (form) {
      form.addEventListener('submit', function (event) {
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
  $('#username').on('keyup', function checkusername() {
    var url = window.location.href;
    jQuery.ajax({
      url: url + "/checkusername",
      type: "POST",
      data: {
        username: $('#username').val()
      },
      success: function success(data) {
        if (data.status == 'success') {
          $('#username').removeClass('is-invalid');
          $('#username').addClass('is-valid');
        } else {
          $('#username').removeClass('is-valid');
          $('#username').addClass('is-invalid');
        }
      },
      error: function error(e) {
        console.log(e);
      }
    });
  });
  var selectedTags = [];
  $('#tag-input').on('input keyup', function getTags() {
    if (this.value) {
      var exist = Array();
      var url = document.location.href;
      var selectedTagsUl = $('#selected-tags-ul');
      var selectedTagsUlChildren = selectedTagsUl.children('li').each(function () {
        exist.push($(this).text());
      });
      jQuery.ajax({
        url: url + "/tags",
        type: "POST",
        data: {
          tag: $('#tag-input').val(),
          exist: exist
        },
        success: function success(data) {
          if (data.status == 'success') {
            clearAllTags();
            suggest(data.results);
            tagClick();
          } else {
            clearAllTags();
          }
        }
      });
    } else {
      clearAllTags();
    }
  });

  function suggest(arr) {
    var tagsUl = $('#tags');

    for (var i = 0; i < arr.length; i++) {
      var name = arr[i].name;
      var elm = '<li class="list-group-item tags-li" id="tags-li-' + i + '">' + name + '</li>';
      tagsUl.append(elm);
    }
  }

  function tagClick() {
    var hiddenInput = $('#hidden-tag-input');
    $('.tags-li').on('click', function (e) {
      var tagName = $(this).text();
      var tag = '<li class="list-group-item list-group-item-primary selected-tags-li">' + tagName + '</li>';
      $('#selected-tags-ul').append(tag);
      selectedTags.push(tagName);
      console.log(selectedTags);
      $(this).remove();
      deleteOnClick();
    });
  }

  function clearAllTags() {
    var tagsUl = $('#tags');
    tagsUl.empty();
  }

  function deleteOnClick() {
    var valueArr = $('#hidden-tag-input').val();
    var tag = $('.selected-tags-li');
    tag.on('click', function () {
      var text = $(this).text();
      selectedTags = $.grep(selectedTags, function (element, i) {
        return element != text;
      });
      $(this).remove();
      console.log(selectedTags);
    });
  }
});

/***/ }),

/***/ 2:
/*!************************************!*\
  !*** multi ./resources/js/main.js ***!
  \************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\Firas\xampp\htdocs\laravel\project\resources\js\main.js */"./resources/js/main.js");


/***/ })

/******/ });