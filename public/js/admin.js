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
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/admin.js":
/*!*******************************!*\
  !*** ./resources/js/admin.js ***!
  \*******************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {
  $('#edit-button').click(function () {
    forms = $('.enabled-disabled');

    for (i = 0; i < forms.length; i++) {
      if (forms[i].disabled) {
        forms[i].disabled = false;
      } else {
        forms[i].disabled = true;
      }
    }

    if ($('#generate-password').hasClass('disabled')) {
      $('#generate-password').removeClass('disabled');
    } else {
      $('#generate-password').addClass('disabled');
    }
  });
  $('#edit-form-users').on('submit', function () {
    return confirm('Are you sure that you want to edit this user?');
  });
  $('#delete-form-users').on('submit', function () {
    return confirm('Are you sure that you want to delete this user?');
  });
  $('#generate-password').on('click', function () {
    return confirm('Are you sure that you want to generate a new password for this user?');
  });
  $('#edit-form-roles').on('submit', function () {
    return confirm('Are you sure that you want to edit this role?');
  });
  $('#delete-form-roles').on('submit', function () {
    return confirm('Are you sure that you want to delete this role?');
  });
  $('#edit-form-permissions').on('submit', function () {
    return confirm('Are you sure that you want to edit this permission?');
  });
  $('#delete-form-permissions').on('submit', function () {
    return confirm('Are you sure that you want to delete this permission?');
  });
  $('#delete-prequestion').on('submit', function () {
    return confirm('Are you sure that you want to delete this question?');
  });
  $('#add-prequestion').click(function () {
    if (confirm('Are you sure that you want to approve this question?')) {
      forms = $('.enabled-disabled');

      for (i = 0; i < forms.length; i++) {
        if (forms[i].disabled) {
          forms[i].disabled = false;
        }
      }

      $('#add-prequestion-form').submit();
    } else {
      return false;
    }
  });
  $('#edit-form-tags').on('submit', function () {
    return confirm('Are you sure that you want to edit this tag?');
  });
  $('#delete-form-tags').on('submit', function () {
    return confirm('Are you sure that you want to delete this tag?');
  });
  $('#edit-form-reports').on('submit', function () {
    return confirm('Are you sure that you want to edit this report?');
  });
  $('#delete-form-reports').on('submit', function () {
    return confirm('Are you sure that you want to delete this report?');
  });
  $('#edit-form-categories').on('submit', function () {
    return confirm('Are you sure that you want to edit this category?');
  });
  $('#delete-form-categories').on('submit', function () {
    return confirm('Are you sure that you want to delete this category?');
  });
});

/***/ }),

/***/ 1:
/*!*************************************!*\
  !*** multi ./resources/js/admin.js ***!
  \*************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\Firas\xampp\htdocs\laravel\project\resources\js\admin.js */"./resources/js/admin.js");


/***/ })

/******/ });