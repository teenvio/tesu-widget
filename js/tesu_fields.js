jQuery( function() {
    jQuery("li.draggable span.mandatory input[checker]").on('click',function(){
            $(this+":checked").parent().parent().css( "background-color", "red" );
    });
    
    jQuery(".sortable").sortable({
      tolerance: "intersect",
      accept: ".draggable",
      activeClass: "ui-state-default",
      hoverClass: "ui-state-hover"
    });
    
    jQuery(".draggable:not(.obligatorio)").draggable({
        connectToSortable:'.sortable',
        appendTo: "body",
        cursor: "move",
        revert: "invalid",
        containment: 'body',
        start: function() {
        
        },
        stop: function() {
        }
    });

    jQuery("#tesu_submit_fields").on('click',function(event){
        event.preventDefault();
        show_wait();

        var fields=[];
        jQuery("#sortable > li").each(function(index,element){
            var field = {};
            field['id'] = jQuery(element).attr("id");
            if(jQuery(element).find(".mandatory > input").is(":checked")){
                field['mandatory']=true;
            }else{
                field['mandatory']=false;
            }
            
            fields.push(field);
        });

        jQuery("#tesu_fields").val( JSON.stringify(fields));//fields.join());

        var data = jQuery("#tesudata").serialize();
	
		jQuery.post(ajaxurl, data, function(json) {
		    var response = JSON.parse(json);
            if(typeof(response['error']) != "undefined" && response['error'] !== null){
		        var errores = response['error'];
		        jQuery.each(errores,function(index, value){
		            var error = value[0].split('|');
		            jQuery("#tesu_string_"+error[0]).addClass('error');
		            jQuery("#tesu_msn_"+error[0]).html(error[1]);
		       });
		       hide_wait();
			}else{
                location.reload();
			}
		});
        return false;
    });

    jQuery( "ul, li" ).disableSelection();

});