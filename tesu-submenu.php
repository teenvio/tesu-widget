<?php
/**
 * Creates the submenu item for the plugin.
 *
 * Registers a new menu item under 'Tools' and uses the dependency passed into
 * the constructor in order to display the page corresponding to this menu item.
 *
 * @package Tesu_Admin_Settings
 */
class TesuPlugin {
 
    /**
     * A reference the class responsible for rendering the submenu page.
     *
     * @var    TesuPlugin_Page
     * @access private
     */
    private $tesuplugin_page;
 
    /**
     * Initializes all of the partial classes.
     *
     * @param TesuPlungin_Page $tesuplugin_page A reference to the class that renders the
     *                                                                   page for the plugin.
     */
    public function __construct( $tesuplugin_page ) {
        $plugin_dir = dirname( plugin_basename( __FILE__ ) ) . '/i18n/' ;
	    load_plugin_textdomain( 'tesu_i18n', false, $plugin_dir );
        
        $this->tesuplugin = $tesuplugin_page;
    }
    
    public function init() {
        add_action( 'admin_menu', array( $this, 'add_options_page' ) );
    }
 
    /**
     * Creates the submenu item and calls on the Submenu Page object to render
     * the actual contents of the page.
     */
    public function add_options_page() {
        if ( empty ( $GLOBALS['admin_page_hooks']['teenvio_menu'] ) ){
    		add_menu_page('Teenvio', 'Teenvio', 'manage_options', 'teenvio_menu', 'teenvio_menu',plugins_url( 'images/teenvio_20x20.png', __FILE__ ));
        }
        
        $options = get_option('tesu_plugin_form');

        if(!empty( $_GET['tab'] )){
            if((empty($options['login']) || $options['login']!=true)){
                $tab = 'login';
                if(esc_attr( $_GET['tab'])!='login'){
                    echo '<script>window.location.replace("admin.php?page=tesu_plugin&tab=login");</script>';
                }
            }else{
                $tab = esc_attr( $_GET['tab'] );
            }   
        }else{    
            if((empty($options['login']) || $options['login']!=true)){
                $tab = 'login';
            }else{
                $tab = 'advanced';
            }
        }
        //add_options_page
        add_submenu_page('teenvio_menu','', 'TeSu Plugin', 'manage_options', 'tesu_plugin', array( $this->tesuplugin, $tab ));
        remove_submenu_page('teenvio_menu','teenvio_menu');
    }
}