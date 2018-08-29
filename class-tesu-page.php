<?php
/**
 * Creates the submenu page for the plugin.
 *
 * Provides the functionality necessary for rendering the page corresponding
 * to the submenu with which this page is associated.
 *
 * @package Tesu_Admin_Settings
 */
class TesuPlugin_Page {
    public function clean(){
        delete_option('tesu_plugin_form');
        delete_option('tesu_plugin_form_advanced');
        delete_option('tesu_plugin_form_fields');
        delete_option('tesu_plugin_form_groups');
        delete_option('tesu_widget');
        unregister_widget('tesu_widget');
        $widgets = get_option('sidebars_widgets');
    	foreach($widgets as $widget_zone=>&$widget_data){
    		$rowtodelete=array();
    
    		foreach($widget_data as $id_row=>$value){
    			if(strpos($value, "tesu_widget")!==false){
    				$rowtodelete[]=$id_row;
    			}
    		}
    		if(count($rowtodelete)>0){
    			foreach($rowtodelete as $key=>$idtodelete){
    				unset($widget_data[$idtodelete]);
    			}
    		}
    	}
    	update_option('sidebars_widgets', $widgets);	
        echo '<script>window.location.replace("admin.php?page=tesu_plugin&tab=login");</script>';
    }
    public function login(){
        wp_enqueue_script( 'tesu_login', plugin_dir_url( __FILE__ ) . 'js/tesu_login.js?load=1', array( 'jquery' ) );
        $this->head_render('login');
        $tpl = file_get_contents(plugin_dir_path(__FILE__). 'tpl/tesu-login.tpl');
        $tpl = str_replace('__#name#__',  __('name', 'tesu_i18n' ) ,$tpl);
        $tpl = str_replace('__#pass#__',  __('pass', 'tesu_i18n' ) ,$tpl);
        $tpl = str_replace('__#security#__', wp_create_nonce('tesu-plugin-login-option'),$tpl);
        $tpl = str_replace('__#texto_acceso#__',  __('texto acceso', 'tesu_i18n' ) ,$tpl);
        $tesu_data = get_option('tesu_plugin_form');
        if(empty($tesu_data['login']) || $tesu_data['login']!=true){
            $tpl = str_replace('__#val_name#__',  '' ,$tpl);
            $tpl = str_replace('__#val_pass#__',  '' ,$tpl);
            $tpl_footer = file_get_contents(plugin_dir_path(__FILE__). 'tpl/tesu-login-new-footer.tpl');
            $tpl_footer = str_replace('__#acceder#__', __('acceder','tesu_i18n'),$tpl_footer);
            $tpl_footer = str_replace('__#recuperardatos#__', __('Recuperar datos de acceso','tesu_i18n'),$tpl_footer);
            $tpl_footer = str_replace('__#sinopuedecrear#__',__('si no dispone de cuenta puede crear una', 'tesu_i18n' ),$tpl_footer);
            $tpl_footer = str_replace ('__#urlalta#__',__('enlace alta','tesu_i18n'),$tpl_footer);
            $tpl_footer = str_replace ('__#aqui#__',__('aqui','tesu_i18n'),$tpl_footer);
        }else{
            $tpl_footer = file_get_contents(plugin_dir_path(__FILE__). 'tpl/tesu-login-update-footer.tpl');
            $tpl_footer = str_replace('__#limpiar_cuenta#__',  __('limpiar cuenta','tesu_i18n') ,$tpl_footer);
            $tpl_footer = str_replace('__#esto_limpiara_todos_los_campos#__',  __('esto limpiara todos los campos','tesu_i18n') ,$tpl_footer);
            $tpl_footer = str_replace('__#cancelar#__',  __('cancelar','tesu_i18n') ,$tpl_footer);
            $tpl_footer = str_replace('__#actualizar#__', __('actualizar','tesu_i18n'),$tpl_footer);
            $tpl = str_replace('__#val_name#__',  $tesu_data['user'] ,$tpl);
            $tpl = str_replace('__#val_pass#__',  $tesu_data['pass'] ,$tpl);
            
        }
        $tpl = str_replace('__#campo obligatorio#__',__('campo obligatorio','tesu_i18n'),$tpl);
        echo $tpl;
        echo $tpl_footer;
        $this->footer_render();
    }   
  
    public function advanced(){
        wp_enqueue_script( 'tesu_advanced', plugin_dir_url( __FILE__ ) . 'js/tesu_advanced.js?load=1', array( 'jquery' ) );
        $this->head_render('advanced');
        $tpl = file_get_contents(plugin_dir_path(__FILE__). 'tpl/tesu-advanced.tpl');
        $tpl = str_replace('__#texto_advanced#__',  __('texto advanced', 'tesu_i18n' ) ,$tpl);
        
        $tpl = str_replace('__#txtfinalidad#__',  __('txtfinalidad', 'tesu_i18n' ) ,$tpl);
        
        $tesu_data_ad = get_option('tesu_plugin_form_advanced');
        if(isset($tesu_data_ad['finalidad']) && !empty($tesu_data_ad['finalidad'])){
            $tpl = str_replace('__#finalidad#__',  $tesu_data_ad['finalidad'],$tpl);
        }else{
            $tpl = str_replace('__#finalidad#__',  '' ,$tpl);
        }
//labels        
        if(isset($tesu_data_ad['labelpolpriv']) && !empty($tesu_data_ad['labelpolpriv'])){
            $tpl = str_replace('__#txturlpoliticas#__',  $tesu_data_ad['labelpolpriv'],$tpl);
        }else{
            $tpl = str_replace('__#txturlpoliticas#__',  __('urlpoliticas', 'tesu_i18n' ) ,$tpl);
        }
        
        if(isset($tesu_data_ad['labelconuso']) && !empty($tesu_data_ad['labelconuso'])){
            $tpl = str_replace('__#txturlcondiciones#__',  $tesu_data_ad['labelconuso'] ,$tpl);
        }else{
            $tpl = str_replace('__#txturlcondiciones#__',  __('urlcondiciones', 'tesu_i18n' ) ,$tpl);
        }
        
        if(isset($tesu_data_ad['labelavisolegal']) && !empty($tesu_data_ad['labelavisolegal'])){
            $tpl = str_replace('__#txturlavisolegal#__',  $tesu_data_ad['labelavisolegal'] ,$tpl);
        }else{
            $tpl = str_replace('__#txturlavisolegal#__',  __('urlavisolegal', 'tesu_i18n' ) ,$tpl);
        }

        if(isset($tesu_data_ad['polpriv']) && !empty($tesu_data_ad['polpriv'])){
            $tpl = str_replace('__#urlpoliticas#__',  $tesu_data_ad['polpriv'],$tpl);
            $tpl = str_replace('__#exurlpoliticas#__',  '' ,$tpl);
            $tpl = str_replace('__#guardar#__',  __('actualizar', 'tesu_i18n' ) ,$tpl);
        }else{
            $tpl = str_replace('__#urlpoliticas#__',  '',$tpl);
            $tpl = str_replace('__#exurlpoliticas#__',  __('exurl', 'tesu_i18n' ) ,$tpl);    
            $tpl = str_replace('__#guardar#__',  __('guardar', 'tesu_i18n' ) ,$tpl);
        }
        
        if(isset($tesu_data_ad['conuso']) && !empty($tesu_data_ad['conuso'])){
            $tpl = str_replace('__#urlconuso#__',  $tesu_data_ad['conuso'],$tpl);
            $tpl = str_replace('__#exurlconuso#__',  '' ,$tpl);    
        }else{
            $tpl = str_replace('__#urlconuso#__',  '',$tpl);
            $tpl = str_replace('__#exurlconuso#__',  __('exurl', 'tesu_i18n' ) ,$tpl);    
        }
        
        if(isset($tesu_data_ad['avisolegal']) && !empty($tesu_data_ad['avisolegal'])){
            $tpl = str_replace('__#urlavisolegal#__',  $tesu_data_ad['avisolegal'],$tpl);
            $tpl = str_replace('__#exurlavisolegal#__',  '' ,$tpl);    
        }else{
            $tpl = str_replace('__#urlavisolegal#__',  '',$tpl);
            $tpl = str_replace('__#exurlavisolegal#__',  __('exurl', 'tesu_i18n' ) ,$tpl);    
        }
        
        $tpl = str_replace('__#guardar#__',  __('guardar', 'tesu_i18n' ) ,$tpl);
        
        $tpl = str_replace('__#security#__', wp_create_nonce('tesu-plugin-advanced-option'),$tpl);
        $tpl = str_replace('__#campo obligatorio#__',__('campo obligatorio','tesu_i18n'),$tpl);
        echo $tpl;
        $this->footer_render();
    }
    
    public function fields(){
        $camposdisponibles = array('nombre','apellidos','observaciones','empresa','edireccion','ecpostal','eciudad','eprovincia','epais','teltrabajo','moviltrabajo','direccion','cpostal','ciudad','provincia','telperso','movilperso','cumple');
        $tesu_data = get_option('tesu_plugin_form_fields');
        if(!empty($tesu_data)){   
            $temp_data = str_replace("\\", "",$tesu_data);
            $camposformulario = json_decode($temp_data);
            $namebtn ='actualizar';
        }else{
            $efield = new stdClass();
            $efield->id = 'email';
            $efield->mandatory=true;
            $camposformulario[] = $efield;
            $namebtn ='guardar'; 
        }

        foreach($camposformulario as $campos){
            if($campos->id == 'email'){
                $txtcamposformulario .= "<li id='".$campos->id."' class='ui-state-default obligatorio draggable'>".__($campos->id,"tesu_i18n")."</li>";
            }else{
                $txtcamposformulario .= "<li id='".$campos->id."' class='ui-state-default draggable'>".__($campos->id,'tesu_i18n')." <span class='mandatory'><input type='checkbox' ";
                if($campos->mandatory){
                    $txtcamposformulario .= "checked='checked' ";
                }
                $txtcamposformulario .= "value='mandatory'> ".__("obligatorio","tesu_i18n")."</span></li>";
            }
            //Eliminar el campo de la zona de los disponibles
            if(($key = array_search($campos->id, $camposdisponibles)) !== false) {
                unset($camposdisponibles[$key]);
            }
            
        }
//Pintamos los disponibles      
        foreach($camposdisponibles as $campos){
            $txtcamposdisponibles .= "<li id='".$campos."' class='ui-state-default draggable'>".__($campos,'tesu_i18n')." <span class='mandatory'><input type='checkbox' value='mandatory'> ".__("obligatorio","i18n")."</span></li>";
        }
/**/
        wp_enqueue_script( 'jquery' );
        wp_enqueue_script( 'jquery-ui-core' );
        wp_enqueue_script( 'jquery-ui-droppable' );
        wp_enqueue_script( 'jquery-ui-draggable');
        wp_enqueue_script( 'jquery-ui-sortable');
        wp_enqueue_script( 'tesu_fields', plugin_dir_url( __FILE__ ) . 'js/tesu_fields.js?load=1', array( 'jquery' ) );
        $this->head_render('fields');
        $tpl = file_get_contents(plugin_dir_path(__FILE__). 'tpl/tesu-fields.tpl');
        $tpl = str_replace('__#texto campos#__',  __('texto campos', 'tesu_i18n' ),$tpl);
        $tpl = str_replace('__#campos disponibles#__',  __('campos disponibles', 'tesu_i18n' ),$tpl);
        $tpl = str_replace('__#campos del formulario#__',  __('campos del formulario', 'tesu_i18n' ),$tpl);
        $tpl = str_replace('__#camposdisponibles#__', $txtcamposdisponibles,$tpl);
        $tpl = str_replace('__#camposformulario#__', $txtcamposformulario,$tpl);
        $tpl = str_replace('__#security#__', wp_create_nonce('tesu-plugin-fields-option'),$tpl);
        $tpl = str_replace('__#guardar#__',  __($namebtn, 'tesu_i18n' ) ,$tpl);
        echo $tpl;
        $this->footer_render();
    }   
    
    public function groups(){
        $this->head_render('groups');
        wp_enqueue_script( 'tesu_groups', plugin_dir_url( __FILE__ ) . 'js/tesu_groups.js?load=1', array( 'jquery' ) );
        
        $namebtn = 'guardar';
        
        $tesu_data = get_option('tesu_plugin_form');
        $usuario = explode('.',$tesu_data['user']);
        try{
            $api=new Teenvio\APIClientPOST($usuario[0],$usuario[1],$tesu_data['pass']);
        }catch(Teenvio\TeenvioException $e){
            	add_action( 'admin_notices', 'tesu_error_connection' );
        }
        $aGroupList = json_decode($api->getGroupList());
        $activeGroup = get_option('tesu_plugin_form_groups');
        foreach($aGroupList as $group){
            $val.= "<option value='".$group->id."' ";
            if($activeGroup == $group->id){$val.="selected='selected'"; $namebtn = 'actualizar';$activeNameGroup=$group->name;}
            $val.= ">" . $group->name."</option>";
        }
         
        
        $tpl = file_get_contents(plugin_dir_path(__FILE__). 'tpl/tesu-groups.tpl');
        $tpl = str_replace('__#grupos#__',  __('grupos', 'tesu_i18n' ) ,$tpl);
        $tpl = str_replace('__#texto grupos#__',  __('texto grupos', 'tesu_i18n' ) ,$tpl);
        if(!empty($activeGroup)){
            $tpl = str_replace('__#destino grupos#__',  __('destino grupos', 'tesu_i18n' ) . "<strong>".$activeNameGroup."</strong>" ,$tpl);
        }else{
             $tpl = str_replace('__#destino grupos#__', '' ,$tpl);
        }
        $tpl = str_replace('__#grupo existente#__',  __('grupo existente', 'tesu_i18n' ) ,$tpl);
        $tpl = str_replace('__#grupo nuevo#__',  __('nuevo grupo', 'tesu_i18n' ) ,$tpl);
        $tpl = str_replace('__#selecciona grupo#__',  __('selecciona grupo', 'tesu_i18n' ) ,$tpl);
        $tpl = str_replace('__#seleccione#__',  __('seleccione', 'tesu_i18n' ) ,$tpl);
        $tpl = str_replace('__#campo obligatorio#__',  __('campo obligatorio', 'tesu_i18n' ) ,$tpl);
        $tpl = str_replace('__#descripcion#__',  __('descripcion', 'tesu_i18n' ) ,$tpl);
        $tpl = str_replace('__#nombre#__',  __('nombre', 'tesu_i18n' ) ,$tpl);
        $tpl = str_replace('__#security#__', wp_create_nonce('tesu-plugin-groups-option'),$tpl);
        $tpl = str_replace('__#guardar#__',  __($namebtn, 'tesu_i18n' ) ,$tpl);
        $tpl = str_replace('__#opciones grupos#__', $val, $tpl);
        $tpl = str_replace('__#campo obligatorio#__',__('campo obligatorio','tesu_i18n'),$tpl);
        echo $tpl;
        
        $this->footer_render();
    }
    
    private function head_render($active_tab) {
        // Code displayed before the tabs (outside)
        echo "\n<!-- Teenvio Submit Admin -->\n";
	    $tpl = file_get_contents(plugin_dir_path(__FILE__).'tpl/tesu-head.tpl');
	    $tpl = str_replace('__#configuracion#__', __('configuracion', 'tesu_i18n' ),$tpl);
	    $tpl = str_replace('__#logo_head#__', plugins_url('/images/teenvio_head.png',__FILE__ ),$tpl);
	    $tpl = str_replace('__#logo_loading#__', plugins_url('/images/loading.gif',__FILE__ ),$tpl);
	    echo $tpl; 
?>
    <div class="tesu-body">
<?php 
        $this->tesu_icons(); 
?>
        <form id="tesudata" action="options.php" method="post">
            <div id="tesu-main">
                 <div id="saved"></div>
<?php
        $this->page_tabs($active_tab);
    }
    
    private function footer_render(){ 
        echo "</div></form></div>";
    }
    
    private function page_tabs( $current = 'login' ) {
        $tabs = array(
            'login'   => __( 'acceso', 'tesu_i18n' ), 
            'advanced'  => __( 'privacidad', 'tesu_i18n' ),
            'fields'  => __( 'campos', 'tesu_i18n' ),
            'groups'  => __( 'grupo', 'tesu_i18n' )
        );
        $html = '<h2 class="nav-tab-wrapper">';

        foreach( $tabs as $tab => $name ){
            $class = ( $tab == $current ) ? 'nav-tab-active' : '';
            $html .= '<a class="nav-tab ' . $class . '" href="?page=tesu_plugin&tab=' . $tab . '">' . $name . '</a>';
        }
        $html .= '</h2>';
        echo $html;
    }
    
    private function script_load(){
        wp_enqueue_script( 'jquery' );
        wp_enqueue_script( 'jquery-ui-core' );
        wp_enqueue_script( 'jquery-ui-droppable' );
        wp_enqueue_script( 'jquery-ui-draggable');
        wp_enqueue_script( 'tesu_fields', plugin_dir_url( __FILE__ ) . '/js', array( 'jquery' ) );
    }
    
    private function tesu_icons(){
        $allok=true;
        
        echo "<div id='tesu-icon-header'>";
        $pathOK = plugins_url('images/caja-ok.svg',__FILE__ );
        $pathKO = plugins_url('images/caja-ko.svg',__FILE__ );
    
        echo "<div class='tesucaja'><img tesuhref='?page=tesu_plugin&tab=login' class='nav-tesu tesulogocaja' src='";
        $tesu_data = get_option('tesu_plugin_form');
        if(empty($tesu_data['login']) || $tesu_data['login']!=true){
            echo $pathKO;
             $allok=false;
        }else{
            echo $pathOK;
        }
        echo "'><br><span>".__('acceso', 'tesu_i18n' )."</span></div>";
    
        echo "<div class='tesucaja'><img tesuhref='?page=tesu_plugin&tab=advanced' class='nav-tesu tesulogocaja' src='";
        
        $tesu_advanced_option = get_option('tesu_plugin_form_advanced');
        if(!empty($tesu_advanced_option)){echo $pathOK;}else{echo $pathKO;$allok=false;}
        echo "'><br><span>".__('privacidad', 'tesu_i18n' )."</span></div>";
        
        echo "<div class='tesucaja'><img tesuhref='?page=tesu_plugin&tab=fields' class='nav-tesu tesulogocaja' src='";
        $tesu_fields_option = get_option('tesu_plugin_form_fields');
        if(!empty($tesu_fields_option)){echo $pathOK;}else{echo $pathKO;$allok=false;}
        echo "'><br><span>".__('campos', 'tesu_i18n' )."</span></div>";
        
        echo "<div class='tesucaja'><img tesuhref='?page=tesu_plugin&tab=groups' class='nav-tesu tesulogocaja' src='";
        $tesu_group_option = get_option('tesu_plugin_form_groups');
        if(!empty($tesu_group_option)){echo $pathOK;}else{echo $pathKO;$allok=false;}
        echo "'><br><span>".__('grupo', 'tesu_i18n' )."</span></div>";
        
        if($allok){
            //echo "<div class='tesucaja'><img class='tesulogocaja' src='". plugins_url('images/check_nivel_ok.png',__FILE__ )."'></div>";
            //echo "<div class='tesucajagrande'><span style='color:#5cb85c;font-size:18px;'>".__('todo completo', 'tesu_i18n' )."</span></div>";
            echo "<div class='tesucajagrande'>
                    <img class='tesulogocaja' src='". plugins_url('images/check_nivel_ok.png',__FILE__ )."'>
                    <span style='color:#5cb85c;font-size:18px;'>".__('todo completo', 'tesu_i18n' )."</span>
                </div>";
            
        }else{
            //echo "<div class='tesucaja'><img class='tesulogocaja' src='". plugins_url('images/check_nivel_ko.png',__FILE__ )."'></div>";
            //echo "<div class='tesucajagrande'><span style='color:#f0ad4e;font-size:18px;'>".__('complete las tareas', 'tesu_i18n' )."</span></div>";
            echo "<div class='tesucajagrande'>
                    <div style='color:#f0ad4e;font-size:18px;float:left;padding-top:25px;padding-rigth:15px;'>".__('complete las tareas', 'tesu_i18n' )."</div>
                    <img class='tesulogocaja' src='". plugins_url('images/check_nivel_ko.png',__FILE__ )."'>
                </div>";
            
        }
        
        $tesu_widget = get_option('tesu_widget');
        if($tesu_widget){
            update_option( 'tesu_widget', $allok);
        }else{
            add_option('tesu_widget', $allok);
        }
        
        echo "</div>";
    }
}