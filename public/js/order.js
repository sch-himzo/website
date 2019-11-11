var jumper_button = $('#jumper_button');
var badge_button = $('#badge_button');
var shirt_button = $('#shirt_button');
var order_type = $('#order_type');

var internal = $('#internal_button');
var external = $('#external_button');
var internal_field = $('#internal_field');

internal.click(function(){
    internal.attr('class','internal-select btn btn-primary left');
    external.attr('class','internal-select btn btn-default right');
    internal_field.val('internal');
});

external.click(function(){
    internal.attr('class','internal-select btn btn-default left');
    external.attr('class','internal-select btn btn-primary right');
    internal_field.val('external');
});

jumper_button.click(function(){
    badge_button.attr('class','badge-select btn btn-default left');
    shirt_button.attr('class','badge-select btn btn-default center');
    jumper_button.attr('class','badge-select btn btn-primary right');
    order_type.val('jumper');
});

badge_button.click(function(){
    jumper_button.attr('class','badge-select btn btn-default right');
    shirt_button.attr('class','badge-select btn btn-default center');
    badge_button.attr('class','badge-select btn btn-primary left');
    order_type.val('badge');
});

shirt_button.click(function(){
    badge_button.attr('class','badge-select btn btn-default left');
    jumper_button.attr('class','badge-select btn btn-default right');
    shirt_button.attr('class','badge-select btn btn-primary center');
    order_type.val('shirt');
});
