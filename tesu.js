var tesu={
	init:function(){
		jQuery('#tesu-button').click(function(){
			jQuery('.tesu-error').removeClass('tesu-error');
			jQuery("#tesu-loading").fadeIn();
			tesu.launch();
		});
	},
	launch:function(){
		var error=0;
		var correo = jQuery("#tesu-email");
		var condiciones=jQuery("#tesu-con");
		
		if ( correo.val().length == 0){
			jQuery(".tesu-email").addClass('tesu-error');
			error=1;
		}else if ( correo.val().trim().match(/^[\w-_.]{1,}@[\w-_.]{1,}(\.\w{2,})+$/)==null){
			jQuery(".tesu-email").addClass('tesu-error');
			error=1;
		}
		
		if(!condiciones.is(':checked')){
			jQuery(".tesu-con").addClass('tesu-error');
			error=1;
		}
		
		if (error<=0){
			var form=jQuery('div#tesu-main form');
			var data=form.serialize();

			jQuery.post(tesuAjax.url, data, function(response) {
				if(response!="Error"){
					jQuery('#tesu-main').fadeOut();
					jQuery('#tesu-msg').fadeIn();
				}
				
			});	
		}
		jQuery("#tesu-loading").fadeOut();
	}
};

if (jQuery){
	jQuery(document).ready(function(){
		tesu.init();
	});
}