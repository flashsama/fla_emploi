<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://flashsama.me
 * @since      1.0.0
 *
 * @package    Fla_emploi
 * @subpackage Fla_emploi/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Fla_emploi
 * @subpackage Fla_emploi/admin
 * @author     salaheddine El Ahoubi <flashsama@gmail.com>
 */
class Fla_emploi_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Fla_emploi_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Fla_emploi_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/fla_emploi-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Fla_emploi_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Fla_emploi_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/fla_emploi-admin.js', array( 'jquery' ), $this->version, false );

	}

	//create custom post type emploi
	public function create_emploi_post_type() {
		register_post_type( 'fla_emploi',
		  array(
			'labels' => array(
			  'name' => __( 'Emplois' ),
			  'singular_name' => __( 'Emploi' )
			),
			'description' => 'Emploi ajouter par une entreprise.',
			'public' => true,
			'has_archive' => true,
			'supports' => array( 'title', 'custom-fields' )
		  )
		);
	  }
	  public function create_entreprise_post_type() {
		register_post_type( 'fla_entreprise',
		  array(
			'labels' => array(
			  'name' => __( 'Entreprises' ),
			  'singular_name' => __( 'Entreprise' )
			),
			'description' => 'entreprise ajouter par admin.',
			'public' => true,
			'has_archive' => true,
			'supports' => array( 'title', 'custom-fields','featured-image' )
		  )
		);
		}
		
		public function fla_emploi_register_required_plugins()
		{
			$plugins = array(
				// This is an example of how to include a plugin bundled with a theme.
				array(
					'name'     => 'Advanced Custom Fields',
					'slug'     => 'advanced-custom-fields',
					'required' => true,
				));

				tgmpa( $plugins);
		}

		public function fla_emploi_register_fields()
		{
			if( function_exists('acf_add_local_field_group') ):

				acf_add_local_field_group(array(
					'key' => 'group_5cb8f9c5ccd81',
					'title' => 'emploi',
					'fields' => array(
						array(
							'key' => 'field_5cb8f9edf7c23',
							'label' => 'Type de contrat',
							'name' => 'type_de_contrat',
							'type' => 'select',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'choices' => array(
								'cdi' => 'CDI',
								'cdd' => 'CDD',
								'freelance' => 'Freelance',
							),
							'default_value' => array(
							),
							'allow_null' => 0,
							'multiple' => 0,
							'ui' => 0,
							'return_format' => 'label',
							'ajax' => 0,
							'placeholder' => '',
						),
						array(
							'key' => 'field_5cb8fa6ff7c24',
							'label' => 'Fonction',
							'name' => 'fonction',
							'type' => 'select',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'choices' => array(
								'commercial' => 'Commercial, vente',
								'informatique' => 'Informatique, nouvelles technologies',
								'gestion' => 'Gestion, comptabilité, finance',
								'production' => 'Production, maintenance, qualité',
								'marketing' => 'Marketing, communication',
								'r_et_d' => 'R&D, gestion de projets',
								'rh' => 'RH, formation',
								'secretariat' => 'Secrétariat, assistanat',
								'services' => 'Métiers des services',
								'management' => 'Management, direction générale',
							),
							'default_value' => array(
							),
							'allow_null' => 0,
							'multiple' => 0,
							'ui' => 0,
							'return_format' => 'value',
							'ajax' => 0,
							'placeholder' => '',
						),
						array(
							'key' => 'field_5cb8fb6af7c25',
							'label' => 'Longitude',
							'name' => 'longitude',
							'type' => 'text',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
							'maxlength' => '',
						),
						array(
							'key' => 'field_5cb8fbe0f7c26',
							'label' => 'Latitude',
							'name' => 'latitude',
							'type' => 'text',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
							'maxlength' => '',
						),
						array(
							'key' => 'field_5cb8fbfaf7c27',
							'label' => 'Descriptif',
							'name' => 'descriptif',
							'type' => 'textarea',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'placeholder' => '',
							'maxlength' => '',
							'rows' => 10,
							'new_lines' => '',
						),
						array(
							'key' => 'field_5cb8fc2af7c28',
							'label' => 'Profil recherché',
							'name' => 'profil_recherche',
							'type' => 'textarea',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'placeholder' => '',
							'maxlength' => '',
							'rows' => 10,
							'new_lines' => '',
						),
						array(
							'key' => 'field_5cb8fc3bf7c29',
							'label' => 'Fiche de poste',
							'name' => 'fiche_de_poste',
							'type' => 'file',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'return_format' => 'url',
							'library' => 'all',
							'min_size' => '',
							'max_size' => '',
							'mime_types' => 'pdf',
						),
						array(
							'key' => 'field_5cb8fc8df7c2a',
							'label' => 'Contact RH',
							'name' => 'contact_rh',
							'type' => 'text',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
							'maxlength' => '',
						),
						array(
							'key' => 'field_5cb8fcc3f7c2b',
							'label' => 'Entreprise',
							'name' => 'entreprise',
							'type' => 'relationship',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'post_type' => array(
								0 => 'fla_entreprise',
							),
							'taxonomy' => '',
							'filters' => array(
								0 => 'search',
								1 => 'post_type',
								2 => 'taxonomy',
							),
							'elements' => array(
								0 => 'featured_image',
							),
							'min' => '',
							'max' => '',
							'return_format' => 'object',
						),
					),
					'location' => array(
						array(
							array(
								'param' => 'post_type',
								'operator' => '==',
								'value' => 'fla_emploi',
							),
						),
					),
					'menu_order' => 0,
					'position' => 'normal',
					'style' => 'default',
					'label_placement' => 'top',
					'instruction_placement' => 'label',
					'hide_on_screen' => '',
					'active' => true,
					'description' => '',
				));
				
				acf_add_local_field_group(array(
					'key' => 'group_5cb8fd6a87d36',
					'title' => 'Entreprise',
					'fields' => array(
						array(
							'key' => 'field_5cb8fd7ce083d',
							'label' => 'Descriptif',
							'name' => 'descriptif',
							'type' => 'textarea',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'placeholder' => '',
							'maxlength' => '',
							'rows' => 10,
							'new_lines' => '',
						),
						array(
							'key' => 'field_5cb8fdf5e083e',
							'label' => 'Adresse',
							'name' => 'adresse',
							'type' => 'textarea',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'placeholder' => '',
							'maxlength' => '',
							'rows' => '',
							'new_lines' => '',
						),
						array(
							'key' => 'field_5cb8fe13e083f',
							'label' => 'Secteur d\'activités',
							'name' => 'secteur_dactivites',
							'type' => 'select',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'choices' => array(
								'Informatique, SSII, Internet' => 'Informatique, SSII, Internet',
								'Industrie, production, fabrication, autres' => 'Industrie, production, fabrication, autres',
								'Banque, assurance, finances' => 'Banque, assurance, finances',
								'Centres d´appel, hotline, call center' => 'Centres d´appel, hotline, call center',
								'Ingénierie, études développement' => 'Ingénierie, études développement',
								'Marketing, communication, médias' => 'Marketing, communication, médias',
								'Distribution, vente, commerce de gros' => 'Distribution, vente, commerce de gros',
								'Services autres' => 'Services autres',
								'Hôtellerie, restauration' => 'Hôtellerie, restauration',
								'Automobile, matériels de transport, réparation' => 'Automobile, matériels de transport, réparation',
							),
							'default_value' => array(
							),
							'allow_null' => 0,
							'multiple' => 0,
							'ui' => 0,
							'return_format' => 'value',
							'ajax' => 0,
							'placeholder' => '',
						),
						array(
							'key' => 'field_5cb8fedee0840',
							'label' => 'Longitude',
							'name' => 'longitude',
							'type' => 'text',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
							'maxlength' => '',
						),
						array(
							'key' => 'field_5cb8fee8e0841',
							'label' => 'Latitude',
							'name' => 'latitude',
							'type' => 'text',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
							'maxlength' => '',
						),
						array(
							'key' => 'field_5cb8fef5e0842',
							'label' => 'Téléphone',
							'name' => 'telephone',
							'type' => 'text',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
							'maxlength' => '',
						),
						array(
							'key' => 'field_5cb8ff08e0843',
							'label' => 'Site Internet',
							'name' => 'site_internet',
							'type' => 'text',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
							'maxlength' => '',
						),
						array(
							'key' => 'field_5cb8ff13e0844',
							'label' => 'Mail',
							'name' => 'mail',
							'type' => 'text',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
							'maxlength' => '',
						),
						array(
							'key' => 'field_5cb900731054d',
							'label' => 'Logo',
							'name' => 'logo',
							'type' => 'image',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'return_format' => 'url',
							'preview_size' => 'thumbnail',
							'library' => 'all',
							'min_width' => '',
							'min_height' => '',
							'min_size' => '',
							'max_width' => '',
							'max_height' => '',
							'max_size' => '',
							'mime_types' => '',
						),
					),
					'location' => array(
						array(
							array(
								'param' => 'post_type',
								'operator' => '==',
								'value' => 'fla_entreprise',
							),
						),
					),
					'menu_order' => 0,
					'position' => 'normal',
					'style' => 'default',
					'label_placement' => 'top',
					'instruction_placement' => 'label',
					'hide_on_screen' => '',
					'active' => true,
					'description' => '',
				));
				
				endif;
		}

		public function fla_emploi_add_role()
		{
			add_role(
				'emploi_manager',
				__( 'Manager d\'emploi' )
		);
		}
		public function fla_emploi_diable_admin_for_manager()
		{
				if (current_user_can('emploi_manager') && is_admin()) {
					wp_redirect(home_url());
					exit;
				}
		}

}
