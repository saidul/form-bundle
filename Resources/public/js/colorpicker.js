/**
 * Initialization of jquery colorpicker
 * 
 * @author Nikolay Georgiev
 * @version 1.0
 */
jQuery(document).ready(function(){
    
    // Searching for colorpicker elements
    jQuery('.neutron-colorpicker').each(function(key, value){  
    	var options = jQuery(this).data('options');  console.log(options);

        var el = jQuery('#' + options.id);
        var picker = jQuery('#neutron-colorpicker-widget-' + options.id);

        picker.find('div').css({
            backgroundColor: '#' + el.val()
        });

        options.color = el.val();

        options.onSubmit = function(hsb, hex, rgb, element) {
            el.val(hex); 
            picker.find('div').css({
                backgroundColor: '#' + hex
            });
            picker.ColorPickerHide();
        };

        picker.ColorPicker(options);
    });
});


