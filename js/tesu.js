var tesu={
	init:function(){
		jQuery('.tesu-button').on('click',function(){
			var tesumain = jQuery(this).closest('div.tesu-main');
			tesumain.find('> form > .tesu-loading').fadeIn();
			tesumain.find('> form .tesu-error').removeClass('tesu-error');
            
			tesu.launch(tesumain);
			
		});
	},
	launch:function(tesumain){
		var error=0;
		var form = tesumain.find('> form');
		var mandatoryfields = form.find('input.required');

        mandatoryfields.each(function(index, obj){
            var fieldtype = jQuery(this).attr('type');
            switch(fieldtype){
                case 'checkbox':
                    if(!jQuery(this).prop('checked')){
                        jQuery(this).parent().addClass('tesu-error');
                        error=1; 
                    }
                    break;
                default:
                    if(jQuery(this).val().length === 0){
                        jQuery(this).parent().addClass('tesu-error');
                        error=1;
                    }
            }
        });
		
		if(error!==0){
		    form.find('> .tesu-loading').fadeOut();
		}else{
		    var fields = form.serialize();
            jQuery.post(tesuAjax.url, fields, function(response) {
			    
			    form.find('> .tesu-loading').fadeOut();
				
				if(response!="Error"){
					form.fadeOut();
					tesumain.find('> .tesu-msg').fadeIn();
				}
				
			});	
		}
	}
};

if (jQuery){
	jQuery(document).ready(function(){
		tesu.init();
	});
}