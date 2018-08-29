<?php

class tesu_widget extends WP_Widget {

	function __construct() {
		parent::__construct('tesu_widget',__('Teenvio Widget', 'tesu_widget_domain'),array( 'description' => __( 'descriptionwidget', 'tesu_i18n' ), ) 
		);
	}

	public function widget( $args, $instance ) {
	    $WidgetReady = get_option('tesu_widget');
        if(isset($WidgetReady) && !empty($WidgetReady)){
            $tesu_data = get_option('tesu_plugin_form');
            $usuario = explode('.',$tesu_data['user']);
            try{
                $api=new Teenvio\APIClientPOST($usuario[0],$usuario[1],$tesu_data['pass']);
            }catch(Teenvio\TeenvioException $e){
            	add_action( 'admin_notices', 'tesu_error_connection' );
            	delete_option('tesu_widget', '');
            	delete_option('tesu_plugin_form');
            	exit();
            }
        
			$title = apply_filters( 'widget_title', $instance['title'] );
			$widgetOU = $args['before_widget'];
	
			if ( ! empty( $title ) )
				$widgetOU .=  $args['before_title'] . $title . $args['after_title'];
			
			$widgetOU .= "\n<!-- Teenvio Submit Form -->\n";
			
			$tesu_widget_fields = get_option('tesu_plugin_form_fields');
            if(!empty($tesu_widget_fields)){        
                $temp_data = str_replace("\\", "",$tesu_widget_fields);
                $camposformulario = json_decode($temp_data);
            }else{
                $camposformulario[] = 'email';
            }
            $formfields='';
            foreach($camposformulario as $campos){
                if($campos->id!='email'){
                    $typefield = 'text';
                }else{
                    $typefield = 'email';
                    $campos->mandatory=true;
                }
                
                if($campos->mandatory){$mandatoryfield=' required ';}else{$mandatoryfield=' ';}
                
                $formfields .= '<div class="form-group">
                                    <div class="col-sm-2">
                                        <label for="'.$campos->id.'" class="control-label">'.__($campos->id,"tesu_i18n").'</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <input type="'.$typefield.'" class="form-control '.$mandatoryfield.'" id="'.$campos->id.'" name="'.$campos->id.'" placeholder="'.__($campos->id,"tesu_i18n").'">
                                    </div>
                                </div><br>';
            }
            
            $checkfields = get_option('tesu_plugin_form_advanced');
            if(isset($checkfields['finalidad']) && !empty($checkfields['finalidad'])){$formfields .='<div>'.$checkfields['finalidad'].'</div>';}
            
            $formfields .= '<div><input name="tesu-con" class="required tesu-con" type="checkbox"> <a href="'.$checkfields['polpriv'].' " target="_blank"> '.$checkfields['labelpolpriv'].' </a></div></br>';
           
            if(isset($checkfields['conuso']) && !empty($checkfields['conuso'])){
                $formfields .= '<div><input name="tesu-conuso" class="tesu-con '.get_option('tesu_plugin_form_group_conuso').'" type="checkbox"> <a href="'.$checkfields['conuso'].' " target="_blank"> '.$checkfields['labelconuso'].' </a></div></br>';
            }
            if(isset($checkfields['avisolegal']) && !empty($checkfields['avisolegal'])){
                $formfields .= '<div><input name="tesu-avisolegal" class="tesu-con '.get_option('tesu_plugin_form_group_avisolegal').'" type="checkbox"> <a href="'.$checkfields['avisolegal'].' " target="_blank"> '.$checkfields['labelavisolegal'].' </a></div></br>';
            }
            
			$tpl = file_get_contents(plugin_dir_path(__FILE__).'tpl/tesu-form.tpl');
			$tpl = str_replace('__#urlloading#__',plugins_url('/images/loading.gif', __FILE__ ),$tpl);
			$tpl = str_replace('__#loading#__', __('loading', 'tesu_i18n' ),$tpl);	
			$tpl = str_replace('__#fields#__', $formfields ,$tpl);
			
			$tpl = str_replace('__#enviar#__', __('enviar', 'tesu_i18n' ),$tpl);
			$tpl = str_replace('__#gracias#__', __('gracias', 'tesu_i18n' ),$tpl);
					
			$advanced = get_option('tesu_plugin_form_advanced');
			$tpl = str_replace('__#url_polpriv#__', $advanced['polpriv'],$tpl);
			if(!empty($advanced['conuso'])){
				$tpl = str_replace('__#url_conuso#__', $advanced['conuso'],$tpl);	
			}else{
				$tpl = str_replace('__#url_conuso#__', " ",$tpl);	
				$tpl = str_replace('__#hide_conuso#__', "display:none;",$tpl);	
			}
			$setWidget='';
			try{
			    $dataplan=$api->getAcountData('JSON');
			}catch(Teenvio\TeenvioException $e){
			    echo "<div id='tesu-warning' class='check_your_data'>\n<!-- Teenvio Submit Form - CHECK CONFIGURATION --></div>";
			    exit();
			}
			if(strstr($dataplan,'gratuito')){$setWidget= "Powered by <a href='http://teenvio.com' target='_blank'> teenvio </a>";}
			$tpl = str_replace('__#tesu#__', $setWidget,$tpl);
		
			tesu_add_scripts();

	        echo $widgetOU;
			
			echo $tpl;
			echo "\n<!-- Teenvio Submit Form -->\n";
			echo $args['after_widget'];
		}else{
			echo "<div id='tesu-warning' class='check_your_data'>\n<!-- Teenvio Submit Form - CHECK CONFIGURATION --></div>";
		}
		
	}

	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}else {
			$title = __( 'New title', 'tesu_widget_domain' );
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<?php 
	}
	
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}
	
}

function tesu_add_scripts(){
	wp_register_script( 'tesu_script',plugins_url( '/js/tesu.js', __FILE__ ), array( 'jquery' ) );
	wp_enqueue_script( 'tesu_script' );
	wp_localize_script( 'tesu_script', 'tesuAjax', array( 'url' => admin_url( 'admin-ajax.php')));
}

function tesu_ajax_save(){
	$data=$_POST;
	$data['gid']= get_option('tesu_plugin_form_groups');
	if (isset($data['email']) && !empty($data['email']) ){
	    if(isset($data['tesu-conuso']) && !empty($data['tesu-conuso']) ){
	        $data['gid'].=",".get_option('tesu_plugin_form_group_conuso');
	        unset($data['tesu-conuso']);
	    }
	    if(isset($data['tesu-avisolegal']) && !empty($data['tesu-avisolegal']) ){
	        $data['gid'].=",".get_option('tesu_plugin_form_group_avisolegal');
	        unset($data['tesu-avisolegal']);
	    }
        $tesu_data = get_option('tesu_plugin_form');
        $usuario = explode('.',$tesu_data['user']);
        try{
            $api=new Teenvio\APIClientPOST($usuario[0],$usuario[1],$tesu_data['pass']);
            $id= $api->saveContact($data);
        }catch(Teenvio\TeenvioException $e){
            	add_action( 'admin_notices', 'tesu_error_connection' );
            	die(json_encode($e));
        }
	}else{
		$retorno="Error";
	}

	die(json_encode($_POST));//$retorno);
	
}
function tesu_get_option($key){
	$data = $_POST;
	if (is_array($data) && isset($data[$key])){
		return stripslashes($data[$key]);
	}else{
		return null;
	}
}



 function tesu_load_translation_files() {
	$plugin_dir = dirname( plugin_basename( __FILE__ ) ) . '/i18n/' ;
	load_plugin_textdomain( 'tesu_i18n', false, $plugin_dir );
 }
