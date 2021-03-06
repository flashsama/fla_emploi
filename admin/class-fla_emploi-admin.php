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
	  }//end function

	  public function create_sollicitation_post_type() {
		register_post_type( 'fla_sollicitation',
		  array(
			'labels' => array(
			  'name' => __( 'Sollicitations' ),
			  'singular_name' => __( 'Sollicitation' )
			),
			'description' => 'Sollicitation ajouter par une entreprise.',
			'public' => true,
			'has_archive' => true,
			'supports' => array( 'title', 'custom-fields' )
		  )
		);
	  }//end function
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
								'1' => 'CDI',
								'2' => 'CDD',
								'3' => 'Intérim',
								'4' => 'Stage',
								'5' => 'Alternance'
							),
							'default_value' => array(
							),
							'allow_null' => 0,
							'multiple' => 0,
							'ui' => 0,
							'return_format' => 'array',
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
								'1' => 'Administration - Services généraux',
								'2' => 'Audit',
								'3' => 'Commercial - Vente',
								'4' => 'Communication - Création',
								'5' => 'Conseil',
								'6' => 'Direction générale - Direction centre de profits',
								'7' => 'Etudes - Recherche',
								'8' => 'Export',
								'9' => 'Gestion - Comptabilite - Finance',
								'10' => 'Internet - e-Commerce',
								'11' => 'Juridique Fiscal',
								'12' => 'Logistique - Achat - Stock - Transport',
								'13' => 'Marketing',
								'14' => 'Production - Maintenance - Qualité - Sécurité - Environnement',
								'15' => 'Ressources Humaines - Personnel - Formation',
								'16' => 'Santé (Industrie)',
								'17' => 'Santé (Médical) - Social',
								'18' => 'Systèmes d\'informations - Télécom',
								'19' => 'Autre',
								),
								'default_value' => array(
								),
								'allow_null' => 0,
								'multiple' => 0,
								'ui' => 0,
								'return_format' => 'array',
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
								'key' => 'field_5cb8fbe0f8b2a',
								'label' => 'Localisation',
								'name' => 'localisation',
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
                                    '1' => 'Agglo. Bergeracoise',
                                    '2' => 'Est',
                                    '3' => 'Grand Périgueux',
                                    '4' => 'Nord',
                                    '5' => 'Ouest',
                                    '6' => 'Sud',
                                ),
								'default_value' => array(
                                ),
								'allow_null' => 0,
                                'multiple' => 0,
                                'ui' => 0,
                                'return_format' => 'array',
                                'ajax' => 0,
                                'placeholder' => '',
                            ),
							array(
								'key' => 'field_5cb8fbfaf7c27',
								'label' => 'Descriptif',
								'name' => 'descriptif',
								'type' => 'wysiwyg',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array(
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'default_value' => '',
								'tabs' => 'visual',
								'toolbar' => 'basic',
								'media_upload' => 0,
								'delay' => 0,
							),
							array(
								'key' => 'field_5cb8fc2af7c28',
								'label' => 'Profil recherché',
								'name' => 'profil_recherche',
								'type' => 'wysiwyg',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array(
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'default_value' => '',
								'tabs' => 'visual',
								'toolbar' => 'basic',
								'media_upload' => 0,
								'delay' => 0,
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
								'return_format' => 'object',
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
								'return_format' => 'object',
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
							array(
								'key' => 'field_5cc1fa99ae977',
								'label' => 'manager d\'entreprise',
								'name' => 'manager_dentreprise',
								'type' => 'user',
								'instructions' => '',
								'required' => 1,
								'conditional_logic' => 0,
								'wrapper' => array(
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'role' => array(
									0 => 'emploi_manager',
								),
								'allow_null' => 0,
								'multiple' => 0,
								'return_format' => 'id',
							)
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

					acf_add_local_field_group(array(
						'key' => 'group_5cd6fc6b28d86',
						'title' => 'sollicitations',
						'fields' => array(
							array(
								'key' => 'field_5cd6fc85af351',
								'label' => 'Conjoint',
								'name' => 'conjoint',
								'type' => 'true_false',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array(
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'message' => '',
								'default_value' => 0,
								'ui' => 0,
								'ui_on_text' => '',
								'ui_off_text' => '',
							),
							array(
								'key' => 'field_5cd6fcbaaf352',
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
									'1' => 'Administration - Services généraux',
								'2' => 'Audit',
								'3' => 'Commercial - Vente',
								'4' => 'Communication - Création',
								'5' => 'Conseil',
								'6' => 'Direction générale - Direction centre de profits',
								'7' => 'Etudes - Recherche',
								'8' => 'Export',
								'9' => 'Gestion - Comptabilite - Finance',
								'10' => 'Internet - e-Commerce',
								'11' => 'Juridique Fiscal',
								'12' => 'Logistique - Achat - Stock - Transport',
								'13' => 'Marketing',
								'14' => 'Production - Maintenance - Qualité - Sécurité - Environnement',
								'15' => 'Ressources Humaines - Personnel - Formation',
								'16' => 'Santé (Industrie)',
								'17' => 'Santé (Médical) - Social',
								'18' => 'Systèmes d\'informations - Télécom',
								'19' => 'Autre',
							),
							'default_value' => array(
							),
							'allow_null' => 0,
							'multiple' => 0,
							'ui' => 0,
							'return_format' => 'array',
							'ajax' => 0,
							'placeholder' => '',
						),
						array(
							'key' => 'field_5cd6fd00af353',
							'label' => 'Message',
							'name' => 'message',
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
							'key' => 'field_5cd6fd24af354',
							'label' => 'CV',
							'name' => 'cv',
							'type' => 'file',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'return_format' => 'array',
							'library' => 'all',
							'min_size' => '',
							'max_size' => '',
							'mime_types' => 'pdf',
						),
						array(
							'key' => 'field_5cd6fd47af355',
							'label' => 'Lettre motivation',
							'name' => 'lettre_motivation',
							'type' => 'file',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'return_format' => 'array',
							'library' => 'all',
							'min_size' => '',
							'max_size' => '',
							'mime_types' => 'pdf',
						),
						array(
							'key' => 'field_5cd6fd80c854f',
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
							'elements' => '',
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
								'value' => 'fla_sollicitation',
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
			$role = get_role('emploi_manager');
			$role->add_cap(
				'read'
			);
			$role->add_cap(
				'edit_posts'
			);
			$role->add_cap(
				'upload_files'
			);
		}
		public function fla_emploi_diable_admin_for_manager()
		{
				$url_path = trim(parse_url(add_query_arg(array()), PHP_URL_PATH), '/');
				if (current_user_can('emploi_manager') && $url_path === "wp-admin") {
					wp_redirect(home_url());
					exit;
				}
		}

		

}
