<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://flashsama.me
 * @since      1.0.0
 *
 * @package    Fla_emploi
 * @subpackage Fla_emploi/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Fla_emploi
 * @subpackage Fla_emploi/includes
 * @author     salaheddine El Ahoubi <flashsama@gmail.com>
 */
class Fla_emploi {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Fla_emploi_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'FLA_EMPLOI_VERSION' ) ) {
			$this->version = FLA_EMPLOI_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'fla_emploi';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Fla_emploi_Loader. Orchestrates the hooks of the plugin.
	 * - Fla_emploi_i18n. Defines internationalization functionality.
	 * - Fla_emploi_Admin. Defines all hooks for the admin area.
	 * - Fla_emploi_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-fla_emploi-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-fla_emploi-i18n.php';
		/**
		 * The class responsible for requiring plugins
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-tgm-plugin-activation.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-fla_emploi-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-fla_emploi-public.php';

		$this->loader = new Fla_emploi_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Fla_emploi_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Fla_emploi_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Fla_emploi_Admin( $this->get_plugin_name(), $this->get_version() );

		//create_emploi_post_type
		$this->loader->add_action( 'init', $plugin_admin, 'create_emploi_post_type' );
		//create_entreprise_post_type
		$this->loader->add_action( 'init', $plugin_admin, 'create_entreprise_post_type' );
		//create_sollicitation_post_type
		$this->loader->add_action( 'init', $plugin_admin, 'create_sollicitation_post_type' );


		$this->loader->add_action( 'init', $plugin_admin, 'fla_emploi_register_fields' );
		$this->loader->add_action( 'init', $plugin_admin, 'fla_emploi_add_role' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'fla_emploi_diable_admin_for_manager' );
		

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'tgmpa_register', $plugin_admin, 'fla_emploi_register_required_plugins' );
		//add_action( 'tgmpa_register', 'my_theme_register_required_plugins' );

		

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Fla_emploi_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		
		/*ajax*/

		$this->loader->add_action( 'wp_ajax_update_entreprise', $plugin_public, 'fla_emploi_update_entreprise' );
		$this->loader->add_action( 'wp_ajax_update_emploi_data', $plugin_public, 'fla_emploi_update_emploi_data' );
		$this->loader->add_action( 'wp_ajax_update_sollicitation_data', $plugin_public, 'fla_emploi_update_sollicitation_data' );
		$this->loader->add_action( 'wp_ajax_add_new_emploi', $plugin_public, 'fla_emploi_add_new_emploi' );
		$this->loader->add_action( 'wp_ajax_add_new_sollicitation', $plugin_public, 'fla_emploi_add_new_sollicitation' );
		$this->loader->add_action( 'wp_ajax_delete_emploi', $plugin_public, 'fla_emploi_delete_emploi' );
		$this->loader->add_action( 'wp_ajax_delete_sollicitation', $plugin_public, 'fla_emploi_delete_sollicitation' );
		$this->loader->add_action( 'wp_ajax_archive_emploi', $plugin_public, 'fla_emploi_archive_emploi' );
		$this->loader->add_action( 'wp_ajax_archive_sollicitation', $plugin_public, 'fla_emploi_archive_sollicitation' );
		$this->loader->add_action( 'wp_ajax_getResultCountsBycontrat', $plugin_public, 'fla_emploi_get_result_counts_by_contrat' );
		

		//filter
		$this->loader->add_filter('single_template', $plugin_public, 'fla_emploi_single_custom_post_template', 10, 3);
		$this->loader->add_filter('ajax_query_attachments_args', $plugin_public, 'fla_emploi_show_current_user_attachments', 10, 3);
		$this->loader->add_filter('wp_title', $plugin_public, 'fla_emploi_filter_title', 10, 3);
		// 'wp_title', 'filter_function_name', 10, 2 
		
		//widgets shortcode
		$this->loader->add_action( 'init', $plugin_public, 'register_shortcodes' );
		$this->loader->add_action( 'template_include', $plugin_public, 'fla_emploi_routing' );
		


	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Fla_emploi_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
