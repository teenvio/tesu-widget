jQuery( function() {
    
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
    
    jQuery("#tesu_clean").on('click',function(){

		jQuery('#mask-modal').fadeIn(1000);
        calcpos();
		//transition effect
		jQuery("#dialog").fadeIn(2000); 
    });
    jQuery("#tesu_btn_cancelar").on('click',function(){
        jQuery("#dialog").fadeOut(500);
        jQuery('#mask-modal').fadeOut(2000);
    });
    jQuery(window).on('resize', function(){
        calcpos();
    });
});

function calcpos(){
        var maskHeight = jQuery(document).height();
		var maskWidth = jQuery(window).width();
	
		//Set height and width to mask to fill up the whole screen
		jQuery('#mask-modal').css({'width':maskWidth,'height':maskHeight});
    	//Get the window height and width
		var winH = jQuery(window).height();
		var winW = jQuery(window).width();
              
		//Set the popup window to center
		jQuery("#dialog").css('top',  winH/2-jQuery("#dialog").height()/2);
		jQuery("#dialog").css('left', winW/2-jQuery("#dialog").width()/2);
    
}