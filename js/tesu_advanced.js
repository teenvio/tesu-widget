jQuery( function() {
    jQuery("#tooglepolpriv").click(function(){
        if( jQuery('[name="labelpolpriv"]').is('[readonly]') ) { 
            jQuery('[name="labelpolpriv"]').removeAttr('readonly').focus();
        }else{
            jQuery('[name="labelpolpriv"]').attr('readonly',true);
        }
    });
    
    jQuery("#toogleconuso").click(function(){
        if( jQuery('[name="labelconuso"]').is('[readonly]')){
            jQuery('[name="labelconuso"]').removeAttr('readonly').focus();
        }else{
            jQuery('[name="labelconuso"]').attr('readonly',true);
        }
    });
    
    jQuery("#toogleavisolegal").click(function(){
        if( jQuery('[name="labelavisolegal"]').is('[readonly]')){
            jQuery('[name="labelavisolegal"]').removeAttr('readonly').focus();
        }else{
            jQuery('[name="labelavisolegal"]').attr('readonly',true);
        }
    });
    
    
    
    jQuery("#tesudata").submit(function(event){
        event.preventDefault();
        
        jQuery(".error").removeClass('error');
        jQuery(".errorMSN").html("");
        
        show_wait();
        var data = jQuery("#tesudata").serialize();
        
	    jQuery.post(ajaxurl, data, function(json) {
		   var response = JSON.parse(json);
		   if(typeof(response['ok']) != "undefined" && response['ok'] !== null){
		     location.reload();
		   }else{
            if(typeof(response['error']) != "undefined" && response['error'] !== null){
		      var errores = response['error'];
		      jQuery.each(errores,function(index, value){
		            var error = value[0].split('|');
		            jQuery("#tesu_string_"+error[0]).addClass('error');
		            jQuery("#tesu_msn_"+error[0]).html(error[1]);
		       });
		       hide_wait();
			}
		   }
		});
		
        return false;
    });
});