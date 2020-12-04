/*
 Template Name: Dashor - Responsive Bootstrap 4 Admin Dashboard
 Author: Themesdesign
 Website: www.themesdesign.in
 File: Form Advanced components
 */


!function($) {
    "use strict";

    var AdvancedForm = function() {};
    
    AdvancedForm.prototype.init = function() {

       // Select2
       $(".select2").select2({
           width: '100%'
       });
    },
    //init
    $.AdvancedForm = new AdvancedForm, $.AdvancedForm.Constructor = AdvancedForm
}(window.jQuery),

//initializing
function ($) {
    "use strict";
    $.AdvancedForm.init();
}(window.jQuery);
