<?php
require_once('tesu-widget.php');
/**
* Plugin Name: Teenvio - Formulario de suscripción
* Plugin URI: http://www.teenvio.com
* Description: Genera un Widget para conectar con el sistema Teenvio
* Text Domain: tesu_i18n
* Version: 1.1.1
* Author: Teenvio
* Author URI: http://www.teenvio.com
* License: GPL2
*/

add_action('admin_menu', 'tesu_plugin_admin_add_page');
function tesu_plugin_admin_add_page() {
	if ( empty ( $GLOBALS['admin_page_hooks']['teenvio_menu'] ) ){
		add_menu_page('Teenvio', 'Teenvio', 'manage_options', 'teenvio_menu', 'teenvio_menu',plugins_url( 'images/teenvio_20x20.png', __FILE__ ));
	}
	add_submenu_page('teenvio_menu','', 'TeSu Plugin', 'manage_options', 'tesu_plugin', 'tesu_plugin_options_page');
	remove_submenu_page('teenvio_menu','teenvio_menu');
}

function tesu_plugin_options_page(){
	echo "\n<!-- Teenvio Submit Admin -->\n";
	$tpl = file_get_contents(plugins_url( 'tpl/tesu-admin.tpl', __FILE__ ));
	$tpl = str_replace('__#configuracion#__', __('configuracion', 'tesu_i18n' ),$tpl);
	echo $tpl; 
?>	
<div class="tesu-body">
	<form action="options.php" method="post">
		<?php settings_fields('tesu_plugin_options'); ?>
		<?php do_settings_sections('tesu_plugin'); ?>
		 
		<input name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" /><?php echo "<span>".__('si no dispone de cuenta puede crear una', 'tesu_i18n' )." <a href='".__('enlace alta','tesu_i18n')."' target='_blank'> ".__('aqui','tesu_i18n')."</a></span>"; ?>
	</form>
</div>
<?php
	echo "\n<!-- Teenvio Submit Admin -->\n";
}


add_action('admin_init', 'tesu_plugin_admin_init');
function tesu_plugin_admin_init(){
	register_setting( 'tesu_plugin_options', 'tesu_plugin_options', 'tesu_plugin_options_validate' );
	
	add_settings_section('tesu_plugin_main', ' ', 'tesu_plugin_section_text', 'tesu_plugin');
	add_settings_field('tesu_string_user',  __('name', 'tesu_i18n' ), 'tesu_plugin_setting_user', 'tesu_plugin', 'tesu_plugin_main');
	add_settings_field('tesu_string_plan', __('plan', 'tesu_i18n' ), 'tesu_plugin_setting_plan', 'tesu_plugin', 'tesu_plugin_main');
	add_settings_field('tesu_string_pass', __('pass', 'tesu_i18n' ), 'tesu_plugin_setting_password', 'tesu_plugin', 'tesu_plugin_main');
	
	add_settings_field('tesu_string_url_polpriv', __('urlpoliticas', 'tesu_i18n' ), 'tesu_plugin_setting_url_polpriv', 'tesu_plugin', 'tesu_plugin_main');
	add_settings_field('tesu_string_url_conuso',  __('urlcondiciones', 'tesu_i18n' ), 'tesu_plugin_setting_url_conuso', 'tesu_plugin', 'tesu_plugin_main');
	
	add_settings_field('tesu_string_gname',  __('gname', 'tesu_i18n' ), 'tesu_plugin_setting_gname', 'tesu_plugin', 'tesu_plugin_main');
	add_settings_field('tesu_string_gid',  '', 'tesu_plugin_setting_gid', 'tesu_plugin', 'tesu_plugin_main');

}

function tesu_plugin_section_text() {
	//echo null;
}

function tesu_plugin_setting_user() {
	$options = get_option('tesu_plugin_options');
	echo "<input id='tesu_string_user' class='form-required' name='tesu_plugin_options[user]' size='40' type='text' 	value='{$options['user']}' /> <span>".__('obligatorio','tesu_i18n')."</span>";
}
function tesu_plugin_setting_plan() {
	$options = get_option('tesu_plugin_options');
	echo "<input id='tesu_string_plan' class='form-required' name='tesu_plugin_options[plan]' size='40' type='text' value='{$options['plan']}' /> <span>".__('obligatorio','tesu_i18n')."</span>";
}
function tesu_plugin_setting_password() {
	$options = get_option('tesu_plugin_options');
	echo "<input id='tesu_string_pass' class='form-required' name='tesu_plugin_options[pass]' size='40' type='password' 	value='{$options['pass']}' /> <span>".__('obligatorio','tesu_i18n')."</span>";
}
function tesu_plugin_setting_url_polpriv() {
	$options = get_option('tesu_plugin_options');
	echo "<input id='tesu_string_url_polpriv' class='form-required'  name='tesu_plugin_options[url_polpriv]' size='40' type='text' value='{$options['url_polpriv']}' /> <span>".__('obligatorio','tesu_i18n')."</span>";
}
function tesu_plugin_setting_url_conuso() {
	$options = get_option('tesu_plugin_options');
	echo "<input id='tesu_string_url_conuso' name='tesu_plugin_options[url_conuso]' size='40' type='text' 	value='{$options['url_conuso']}' />";
}
function tesu_plugin_setting_gname() {
	$options = get_option('tesu_plugin_options');
	echo "<input id='tesu_string_gname' name='tesu_plugin_options[gname]' size='40' type='text' value='{$options['gname']}' />";
}
function tesu_plugin_setting_gid() {
	$options = get_option('tesu_plugin_options');
	echo "<input id='tesu_string_gid' name='tesu_plugin_options[gid]' size='40' type='hidden' value='{$options['gid']}' />";
}

function tesu_plugin_options_validate($input){	
	$error=false;
	
	$mandatory=array('user','plan','pass','url_polpriv');
	
	foreach($input as $key=>$value){
		$input_name = trim($key);
		if(empty($value) && in_array($input_name,$mandatory)) {
			$error=true;
			$type = 'error';
		        $message = __( 'Complete los datos obligatorios', 'my-text-domain' );
		}
	}		
	
	if($error==true){
		add_action( 'admin_notices', 'tesu_error_datos_vacios' );
	}else{
		require_once 'class/APIClientPOST.php';
		$api=new Teenvio\APIClientPOST($input['user'],$input['plan'],$input['pass']);
		if(!$api->ping()){
			add_action( 'admin_notices', 'tesu_error_connection' );
		}else{
			if(empty($input['gname']))
				$input['gname']="Formulario de Wordpress";
		
			$input['gid'] = $api->saveGroup($input['gname'],__('tesugroupdescription','tesu_i18n'),$input['gid']);
		}
	}
	
	return $input;	
}

function tesu_error_connection() {
    ?>
    <div class="error notice">
        <p><strong>Teenvio Widget</strong> - <?php _e('datosincorrectos','tesu_i18n'); ?></p>
    </div>
    <?php
}



$options = get_option('tesu_plugin_options');
$vacio = false;
$mandatory=array('user','plan','pass','url_polpriv');
foreach($options as $key=>$value){
	$options_name = trim($key);
	if(empty($value) && in_array($options_name,$mandatory)) {
		$vacio=true;
	}
}		
	
if($vacio==true){
	add_action( 'admin_notices', 'tesu_error_connection' );
}else{

	require_once 'class/APIClientPOST.php';
	$api=new Teenvio\APIClientPOST($options['user'],$options['plan'],$options['pass']);
	if(!$api->ping()){
		add_action( 'admin_notices', 'tesu_error_connection' );
	}

}