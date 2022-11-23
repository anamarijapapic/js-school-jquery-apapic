<?php
/**
 * @package   WPNotify
 * @author    Zoran Ugrina
 * @link      http://www.zugrina.com
 *
 * Plugin Name:       WPNotify
 * Description:       Worker plugin
 * Version:           1.0.1
 * Author:            Zoran Ugrina
 * Author URI:        http://www.zugrina.com
 * Text Domain:       wpnotify
 */

class WPNotify{

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Initialize the plugin
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

		$plugin_menu_action_hook = (is_multisite()) ? 'network_admin_menu' : 'admin_menu';

		add_action( $plugin_menu_action_hook, array( $this, 'plugin_settings_page' ) );
		add_action( 'admin_init', array( $this, 'plugin_page_init' ) );
		add_action( 'init', array( $this, 'fetch_updates' ) );
		add_action( 'network_admin_edit_wpnotify', array( $this, 'save_network_options') );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Fetch WP core update
	 */
	private function check_wp_version(){
		global $wp_version;
		do_action( "wp_version_check" ); // force WP to check its core for updates
		$update_core = get_site_transient( "update_core" ); // get information of updates

		$current_wp_version = $wp_version;
		$latest_wp_version = $wp_version;

		if ( 'upgrade' == $update_core->updates[0]->response ) { // is WP core update available?
			require_once( ABSPATH . WPINC . '/version.php' ); // Including this because some plugins can mess with the real version stored in the DB.
			$latest_wp_version = $update_core->updates[0]->current; // The new WP core version
		}
		return array(
			'current_wp_version' => $current_wp_version,
			'latest_wp_version' => $latest_wp_version,
		);
	}

	/**
	 * Fetch plugins updates
	 */
	private function check_plugins_version(){
		global $wp_version;
		$plugins_updates = array();
		$cur_wp_version = preg_replace( '/-.*$/', '', $wp_version );
		do_action( "wp_update_plugins" ); // force WP to check plugins for updates
		$update_plugins = get_site_transient( 'update_plugins' ); // get information of updates
		if ( !empty( $update_plugins->response ) ) { // any plugin updates available?
			$plugins_need_update = $update_plugins->response; // plugins that need updating
			if ( count( $plugins_need_update ) >= 1 ) { // any plugins need updating?
				require_once( ABSPATH . 'wp-admin/includes/plugin-install.php' ); // Required for plugin API
				require_once( ABSPATH . WPINC . '/version.php' ); // Required for WP core version
				$counter = 0;
				foreach ( $plugins_need_update as $key => $data ) { // loop through the plugins that need updating
					$plugin_info = get_plugin_data( WP_PLUGIN_DIR . "/" . $key ); // get local plugin info

					if ( 'wp-migrate-db-pro' === $data->slug && class_exists( 'DeliciousBrains\WPMDB\WPMigrateDB' ) ) {
						$wpmdb_instance = DeliciousBrains\WPMDB\Container::getInstance();

						if ( ! empty( $wpmdb_instance ) ) {
							remove_filter( 'plugins_api', array( $wpmdb_instance->providers['DeliciousBrains\WPMDB\Pro\ServiceProvider']->pro_plugin_manager, 'short_circuit_wordpress_org_plugin_info_request' ), 10, 3 );
						}
					}

					$info = plugins_api( 'plugin_information', array( 'slug' => $data->slug ) ); // get repository plugin info

					if ( 'wp-migrate-db-pro' === $data->slug && class_exists( 'DeliciousBrains\WPMDB\WPMigrateDB' ) ) {
						$wpmdb_instance = DeliciousBrains\WPMDB\Container::getInstance();

						if ( ! empty( $wpmdb_instance ) ) {
							add_filter( 'plugins_api', array( $wpmdb_instance->providers['DeliciousBrains\WPMDB\Pro\ServiceProvider']->pro_plugin_manager, 'short_circuit_wordpress_org_plugin_info_request' ), 10, 3 );
						}
					}

					if ( isset( $info->tested ) && version_compare( $info->tested, $wp_version, '>=' ) ) {
						$compat = sprintf( __( 'Compatibility with WordPress %1$s: 100%% (according to its author)' ), $cur_wp_version );
					}
					elseif ( isset( $info->compatibility[$wp_version][$data->new_version] ) ) {
						$compat = $info->compatibility[$wp_version][$data->new_version];
						$compat = sprintf( __( 'Compatibility with WordPress %1$s: %2$d%% (%3$d "works" votes out of %4$d total)' ), $wp_version, $compat[0], $compat[2], $compat[1] );
					}
					else {
						$compat = sprintf( __( 'Compatibility with WordPress %1$s: Unknown' ), $wp_version );
					}

					$plugin_information = array();

					if(is_object($info) && !is_wp_error($info)){
						$plugin_information = array(
							'name' => $info->name,
							'slug' => $info->slug,
							'version' => $info->version,
							'last_updated' => $info->last_updated,
							'sections' => $info->sections
						);

						$plugins_updates[$counter]['plugin_current_version'] = $plugin_info['Version'];
						$plugins_updates[$counter]['plugin_new_version'] = $data->new_version;
						$plugins_updates[$counter]['compatibility'] = $compat;
						$plugins_updates[$counter]['plugin_info'] = $plugin_information;
						$counter++;
					}
				}
			}
		}
		return $plugins_updates;
	}

	/**
	 * Fetch all updates
	 */
	public function fetch_updates(){
		if( isset($_GET['wpnotify_api_key']) ){
			$option = get_site_option( 'wpnotify' );
			$api_key = $option['api_key'];
			if($_GET['wpnotify_check_api_key']){
				if($_GET['wpnotify_api_key'] == $api_key){
					header("Content-type: application/json");
					echo json_encode(array('success' => true));
					die;
				}
				wp_die( '422', '', array('response' => 422) );
			}
			if($_GET['wpnotify_api_key'] == $api_key){
				$updates = array(
					'wordpress_core' => $this->check_wp_version(),
					'plugins' => $this->check_plugins_version()
				);
				// set header as json
				header("Content-type: application/json");
				echo json_encode($updates);
				die;
			}else{
				wp_die( '422', '', array('response' => 422) );
			}
		}
	}

	/**
	 * Add options page
	 */
	public function plugin_settings_page(){

		$parent_slug = (is_multisite()) ? 'settings.php' : 'options-general.php';

	    add_submenu_page(
	    	$parent_slug,
	        'WPNotify Settings',
	        'WPNotify Settings',
	        'manage_options',
	        'wpnotify-settings',
	        array( $this, 'wpnotify_admin_page' )
	    );
	}

	/**
	 * Options page callback
	 */
	public function wpnotify_admin_page(){ ?>
	    <div class="wrap">
	        <h2><?php _e('WPNotify Settings', 'wpnotify'); ?></h2>

	        <?php $form_url = (is_multisite()) ? network_admin_url( 'edit.php?action=wpnotify' ) : admin_url( 'options.php' ); ?>

	        <form method="post" action="<?php echo $form_url; ?>">
	        <?php
	            // This prints out all hidden setting fields
	            settings_fields( 'wpnotify_option_group' );
	            do_settings_sections( 'wpnotify-settings' );
	            submit_button();
	        ?>
	        </form>
	    </div>
	    <?php
	}

	/**
	 * Register and add settings
	 */
	public function plugin_page_init(){
	    register_setting(
	        'wpnotify_option_group', // Option group
	        'wpnotify', // Option name
	        array( $this, 'sanitize_plugin_page_field' ) // Sanitize
	    );

	    add_settings_section(
	        'wpnotify_field_section', // ID
	        '', // Title
	        '', // Callback
	        'wpnotify-settings' // Page
	    );

	    add_settings_field(
	        'wpnotify_api_key', // ID
	        __('Add your API Key', 'wpnotify'), // Title
	        array( $this, 'wpnotify_field_callback' ), // Callback
	        'wpnotify-settings', // Page
	        'wpnotify_field_section' // Section
	    );
	}

	/**
	 * Sanitize each setting field as needed
	 */
	public function sanitize_plugin_page_field( $input ){
	    $new_input = array();

	    $new_input['api_key'] = md5(uniqid(rand(), true));

	    return $new_input;
	}

	/**
	 * Field Callback
	 */
	public function wpnotify_field_callback(){
		$option = get_site_option( 'wpnotify' );
	    $input = '<input style="width:300px;" id="wpnotify_api_key" name="wpnotify[api_key]" value="'.$option['api_key'].'" readonly>';
	    $input .= '<p><em>'.__('To generate or refresh your API key please click on button "Save Changes"!', 'wpnotify').'</em></p>';
	    echo $input;
	}

	/**
	 * Save multiste option in DB
	 */
	public function save_network_options(){
        $option_value = md5(uniqid(rand(), true));
		$option_value = array( 'api_key' => $option_value );
		update_site_option( 'wpnotify', $option_value );
	  	wp_redirect(add_query_arg(array('page' => 'wpnotify-settings', 'updated' => 'true'), network_admin_url('settings.php')));
 		exit;
	}

}

WPNotify::get_instance();