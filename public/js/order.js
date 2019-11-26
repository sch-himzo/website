var jumper_button = $('#jumper_button');
var badge_button = $('#badge_button');
var shirt_button = $('#shirt_button');
var order_type = $('#order_type');

var internal = $('#internal_button');
var external = $('#external_button');
var internal_field = $('#internal_field');
var existing = $('#existing');
var image = $('#image');
var image_label = $('#image_label');
var font = $('#font');
var font_label = $('#font_label');
var size_label = $('#size_label');
var size = $('#size');

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

var required = "Tervrajz<span class=\"required\">*</span>";
var not_required = "Tervrajz";
var font_required = "Betűtípus<span class=\"required\">*</span>";
var font_not_required = "Betűtípus";
var size_required = "Méret<span class=\"required\">*</span>";
var size_not_required = "Méret";

existing.on('keyup click change', function(){
    if(existing.is(':checked')){
        image.removeAttr('required');
        image.attr('disabled','true');
        image_label.html(not_required);
        font.removeAttr('required');
        font.attr('disabled','true');
        font_label.html(font_not_required);
        size.removeAttr('required');
        size.attr('disabled','true');
        size_label.html(size_not_required);
    }else{
        image.attr('required','true');
        image.removeAttr('disabled');
        image_label.html(required);
        font.attr('required','true');
        font.removeAttr('disabled');
        font_label.html(font_required);
        size.attr('required','true');
        size.removeAttr('disabled');
        size_label.html(size_required);
    }
});
