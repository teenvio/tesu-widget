jQuery( function() {
    var allPanels = jQuery('.accordion > dd').hide();
    
    jQuery('.accordion > dt > h4').click(function() {
        jQuery("#tesu_type_group").val(jQuery(this).children().attr('id'));
        jQuery("#submit_group").fadeIn().html();
        allPanels.slideUp();
        jQuery(this).parent().next().slideDown();
        return false;
    });
    
    
    jQuery("#submit_group").click(function(event){
        event.preventDefault();
        
        jQuery(".error").removeClass('error');
        jQuery(".errorMSN").html("");
        
        show_wait();
        var data = jQuery("#tesudata").serialize();
        jQuery.post(ajaxurl, data, function(json) {
		   var response = JSON.parse(json);
            if(typeof(response['error']) != "undefined" && response['error'] !== null){
		      var errores = response['error'];
		      jQuery.each(errores,function(index, value){
		            var error = value[0].split('|');
		            jQuery("#tesu_"+error[0]).addClass('error');
		            jQuery("#tesu_msn_"+error[0]).html(error[1]);
		      });
		       hide_wait();
			}else{
			    location.reload();
			}
		});
        return false;
        
    });

});