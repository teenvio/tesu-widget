<?php
/**
* @package  Tesu_Admin_Settings
* 
* Plugin Name: Teenvio - Formulario de suscripción
* Description: Genera un Widget para conectar con el sistema Teenvio
* Text Domain: tesu_i18n
* Version: 2.1
* Author: Teenvio
* Author URI: http://www.teenvio.com
* License: GPL2
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
     die;
}

apply_filters('admin_referrer_policy','origin');

foreach ( glob( plugin_dir_path( __FILE__ ) . '*.php' ) as $file ) {
    include_once $file;
}

$isWidgetReady = get_option('tesu_widget');

if($isWidgetReady){add_action( 'widgets_init', 'tesu_plugin_load_widget' );}

add_action( 'plugins_loaded', 'tesu_pluging_admin_settings' );

add_action('wp_ajax_tesu_login_save_ajax', 'tesu_login_save_ajax');
add_action('wp_ajax_tesu_advanced_save_ajax', 'tesu_advanced_save_ajax');
add_action('wp_ajax_tesu_field_save_ajax', 'tesu_field_save_ajax');
add_action('wp_ajax_tesu_groups_save_ajax', 'tesu_groups_save_ajax');


/**
 * Starts the plugin.
 */
function tesu_pluging_admin_settings() {
    $plugin = new TesuPlugin( new TesuPlugin_Page() );
    $plugin->init();
    
    $tesu_advanced_option = get_option('tesu_plugin_form_advanced');
    $tesu_fields_option = get_option('tesu_plugin_form_fields');
    $tesu_group_option = get_option('tesu_plugin_form_groups');
    if(isset($tesu_advanced_option) && !empty($tesu_advanced_option)){
        if(isset($tesu_fields_option) && !empty($tesu_fields_option)){ 
            if(isset($tesu_group_option) && !empty($tesu_group_option)){
                update_option('tesu_widget', "allok");
            }
        }
    }
}


function tesu_plugin_load_widget() {
  	register_widget( 'tesu_widget' );
    add_action('after_setup_theme','tesu_load_translation_files');
    add_action('wp_ajax_tesu_ajax_save', 'tesu_ajax_save' );
    add_action('wp_ajax_nopriv_tesu_ajax_save', 'tesu_ajax_save' );
}

function tesu_login_save_ajax() {
    check_ajax_referer('tesu-plugin-login-option', 'security');
    $data = $_POST;
    unset($data['security'], $data['action']);
    
    $result=array();
    $result['error']=array();
    $error = array();
    $ok = array();
   
    if(!isset($data['user']) || empty($data['user'])){
        array_push($error,array("user|". __('campo obligatorio', 'tesu_i18n' )));
    }
    if(!isset($data['pass']) || empty($data['pass'])){
        array_push($error,array("pass|". __('campo obligatorio', 'tesu_i18n' )));
    }
    
    if(empty($error)){
        $usuario = explode('.',$data['user']);
        if(count($usuario)>1){
        	try{
        	    $api=new Teenvio\APIClientPOST($usuario[0],$usuario[1],$data['pass']);
                $tesu_data = get_option('tesu_plugin_form');
                if(empty($tesu_data['login']) || $tesu_data['login']!=true){
                    $data['login']=true;
                    add_option('tesu_plugin_form',$data);
                }else{
                    $tesu_data['user']=$data['user'];
                    $tesu_data['pass']=$data['pass'];
                    update_option( 'tesu_plugin_form', $tesu_data);
                }
        	    array_push($ok,array("general|". __('correcto', 'tesu_i18n' )));
            }catch(Teenvio\TeenvioException $e){
                array_push($error,array("user| "));
                array_push($error,array("pass| "));
                array_push($error,array("general|". __("error - " .substr($e,51,7), 'tesu_i18n' )));
        	}
        }else{
             array_push($error,array("user|". __('usuario no valido', 'tesu_i18n' )));
        }
    }
	
	if(!empty($error)){$result['error']=$error;}
	if(!empty($ok)){$result['ok']=$ok;}

    die(json_encode($result));
}

function tesu_advanced_save_ajax() {
    check_ajax_referer('tesu-plugin-advanced-option', 'security');
    $data = $_POST;
    unset($data['security'], $data['action']);
    
    $result=array();
    $result['error']=array();
    $error = array();
    $ok = array();
    
    if(!isset($data['polpriv']) || empty($data['polpriv'])){
        array_push($error,array("polpriv|". __('campo obligatorio', 'tesu_i18n' )));
    }
    if(isset($data['conuso']) ){
        if(!empty($data['conuso'])){
            if(!isValidUrl($data['conuso'])){
                array_push($error,array("conuso|". __('la url no es valida', 'tesu_i18n' )));
            }
        }
    }
    if(isset($data['avisolegal']) ){
        if(!empty($data['avisolegal'])){
            if(!isValidUrl($data['conuso'])){
                array_push($error,array("conuso|". __('la url no es valida', 'tesu_i18n' )));
            }
        }
    }
    if(empty($error)){
        if(isValidUrl($data['polpriv'])){
            $tesu_data = get_option('tesu_plugin_form_advanced');
            if(empty($tesu_data['polpriv']) || $tesu_data['polpriv']!=true){
                add_option('tesu_plugin_form_advanced',$data);
            }else{
                if(isset($data['finalidad']) && !empty($data['finalidad'])){
                    $tesu_data['finalidad']=$data['finalidad'];
                }
                if(isset($data['labelpolpriv']) && !empty($data['labelpolpriv'])){
                    $tesu_data['labelpolpriv']=$data['labelpolpriv'];
                }
                if(isset($data['labelconuso']) && !empty($data['labelconuso'])){
                    $tesu_data['labelconuso']=$data['labelconuso'];
                }
                if(isset($data['labelavisolegal']) && !empty($data['labelavisolegal'])){
                    $tesu_data['labelavisolegal']=$data['labelavisolegal'];
                }
              
                $tesu_data['polpriv']=$data['polpriv'];
                if(isset($data['conuso']) ){
                    $tesu_data['conuso']=$data['conuso'];
                }
                if(isset($data['avisolegal'])  ) { 
                    $tesu_data['avisolegal']=$data['avisolegal'];
                }
                update_option( 'tesu_plugin_form_advanced', $tesu_data);
            }
            
            $tesu_user = get_option('tesu_plugin_form');
            $usuario = explode('.',$tesu_user['user']);
            try{
                $api=new Teenvio\APIClientPOST($usuario[0],$usuario[1],$tesu_user['pass']);
                
                $tesu_group_conuso = get_option('tesu_plugin_form_group_conuso');
                if(isset($tesu_group_conuso) && !empty($tesu_group_conuso)){
                    $api->saveGroup($tesu_data['labelconuso'],'Grupo automático creado desde Wordpress',$tesu_group_conuso);
                }else{
                    if(!empty($tesu_data['conuso']) ){
                        $idgroup = $api->saveGroup($tesu_data['labelconuso'],'Grupo automático creado desde Wordpress');
                        add_option('tesu_plugin_form_group_conuso', $idgroup);
                    }
                }
                 
                $tesu_group_avisolegal = get_option('tesu_plugin_form_group_avisolegal');
                if(isset($tesu_group_avisolegal) && !empty($tesu_group_avisolegal)){
                    $api->saveGroup($tesu_data['labelavisolegal'],'Grupo automático creado desde Wordpress',$tesu_group_avisolegal);
                }else{
                    if(!empty($tesu_data['avisolegal']) ){
                        $idgroup = $api->saveGroup($tesu_data['labelavisolegal'],'Grupo automático creado desde Wordpress');
                        add_option('tesu_plugin_form_group_avisolegal', $idgroup); 
                    }
                    
                }   
            }catch(Teenvio\TeenvioException $e){
                array_push($error,array("general|". __('usuario o contraseña no validos', 'tesu_i18n' )));
            }
            
            array_push($ok,array("general|". get_option('tesu_plugin_form_advanced')));
        }else{
           array_push($error,array("polpriv|". __('la url no es valida', 'tesu_i18n' ))); 
        }
    }
	
	if(!empty($error)){$result['error']=$error;}
	if(!empty($ok)){$result['ok']=$ok;}

    die(json_encode($result));
}

function tesu_field_save_ajax() {
    check_ajax_referer('tesu-plugin-fields-option', 'security');
    $data = $_POST;
    unset($data['security'], $data['action']);
    $error = array();
    $ok = array();
    
    if(empty($data['tesu_fields'])){
        array_push($error,array("general|". __('error inesperado', 'tesu_i18n' ))); 
    }else{
       update_option('tesu_plugin_form_fields', $data['tesu_fields']); 
       array_push($ok,array("general|". __('correcto', 'tesu_i18n' ))); 
    }
    
    if(!empty($error)){$result['error']=$error;}
	if(!empty($ok)){$result['ok']=$ok;}

    die(json_encode($result));
}

function tesu_groups_save_ajax() {
    check_ajax_referer('tesu-plugin-groups-option', 'security');
    $data = $_POST;
    unset($data['security'], $data['action']);
    
    $error = array();
    $ok = array();

    if(empty($data['type_group'])){
       array_push($error,array("general|". __('no hay typegroup', 'tesu_i18n' ))); 
    }else{
        switch ($data['type_group']){
            case 'existinggroup':
                if(empty($data['groupList']) || $data['groupList']<=0){
                    array_push($error,array("groupList|". __('campo obligatorio', 'tesu_i18n' )));  
                }else{
                    update_option('tesu_plugin_form_groups', $data['groupList']); 
                    array_push($ok,array("general|". __('correcto', 'tesu_i18n' ))); 
                }
                break;
            case 'newgroup':
                if(empty($data['new_name'])){
                    array_push($error,array("new_name|". __('campo obligatorio', 'tesu_i18n' )));  
                }else{
                    $tesu_user = get_option('tesu_plugin_form');
                    $usuario = explode('.',$tesu_user['user']);
                    try{
                        $api=new Teenvio\APIClientPOST($usuario[0],$usuario[1],$tesu_user['pass']);
                		$idgroup = $api->saveGroup($data['new_name'],$data['new_description']);
                		if($idgroup){
                		    update_option('tesu_plugin_form_groups', $idgroup); 
                            array_push($ok,array("general|". __('correcto', 'tesu_i18n' ))); 
                		}
                    }catch(Teenvio\TeenvioException $e){
                	    array_push($error,array("general|". __('usuario o contraseña no validos', 'tesu_i18n' )));
                	}
                }
                break;
            default:
                array_push($error,array("general|". __('seleccionar un grupo', 'tesu_i18n' ))); 
        }
    }
   
    if(!empty($error)){$result['error']=$error;}
	if(!empty($ok)){$result['ok']=$ok;}

    die(json_encode($result));
}

function isValidUrl($url){
    $regex = "((https?|ftp)\:\/\/)?"; // SCHEME 
    $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass 
    $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP 
    $regex .= "(\:[0-9]{2,5})?"; // Port 
    $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path 
    $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 
    $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor 

    if(preg_match("/^$regex$/i", $url)){ // `i` flag for case-insensitive
        return true; 
    }else{
        return false;
    } 
}