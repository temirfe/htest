/**
 * Created by Temirbek on 9/23/2015.
 */

$('#mybut').click(function(){
    console.log('yo');
    //

});
/*$('#contact-form').yiiActiveForm('updateAttribute', 'contactform-subject', ["I have an error..."]);
$('#contact-form').yiiActiveForm('add', {
    id: 'contactform-address',
    name: 'address',
    container: '.field-contactform-address',
    input: '#contactform-address',
    error: '.help-block',
    validate:  function (attribute, value, messages, deferred, $form) {
        yii.validation.required(value, messages, {message: "Validation Message Here"});
    }
});*/
/*
jQuery(window).on('load', function () {


});
*/
/*setTimeout(function(){
    $('#contact-form').yiiActiveForm('updateAttribute', 'contactform-subject', ["I have an error..."]);
}, 1000);
setTimeout(function(){
    $('#contact-form').yiiActiveForm('add', {
        id: 'contactform-address',
        name: 'address',
        container: '.field-contactform-address',
        input: '#contactform-address',
        error: '.help-block',
        validate:  function (attribute, value, messages, deferred, $form) {
            yii.validation.required(value, messages, {message: "Validation Message Here"});
        }
    });
}, 1000);*/
//$('#contact-form').yiiActiveForm('validateAttribute', 'contactform-name');

$("document").ready(function () {
    $(document).on("change", "#filter-form :input", function () {
        //$("#filter-form").yiiActiveForm('submitForm');
    });
});

$('#filter-form').on('beforeSubmit', function (e) {
    var emptyinputs = $(this).find('input').filter(function(){
        return !$.trim(this.value).length;  // get all empty fields
    }).prop('disabled',true);
    return true;
});