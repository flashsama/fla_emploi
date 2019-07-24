<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://flashsama.me
 * @since      1.0.0
 *
 * @package    Fla_emploi
 * @subpackage Fla_emploi/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Fla_emploi
 * @subpackage Fla_emploi/public
 * @author     salaheddine El Ahoubi <flashsama@gmail.com>
 */
class Fla_emploi_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		/* enqueue material icons */ 
		//wp_enqueue_style( $this->plugin_name.'_material_icons', 'https://fonts.googleapis.com/icon?family=Material+Icons', array(), $this->version, 'all' );

		
		// wp_enqueue_style( $this->plugin_name.'_materializecss', plugin_dir_url( __FILE__ ) . 'css/materialize.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/fla_emploi-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		/* enqueu media to be used in front end*/
		wp_enqueue_media();

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/fla_emploi-public.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name, 'ajax_front_obj', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
		wp_enqueue_script( $this->plugin_name.'_materializejs', plugin_dir_url( __FILE__ ) . 'js/materialize.min.js', array( 'jquery' ), $this->version, false );

	}

	public function fla_emploi_paginationtemplate($query)
	{
		?>
			<nav class="jobs_pager flex space-center aligne-center">
				<?php 
					echo paginate_links( array(
						'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
						'total'        => $query->max_num_pages,
						'current'      => max( 1, get_query_var( 'paged' ) ),
						'format'       => '?paged=%#%',
						'show_all'     => false,
						'type'         => 'list',
						'end_size'     => 2,
						'mid_size'     => 1,
						'prev_next'    => true,
						'prev_text'    => sprintf( '<i></i> %1$s', __( 'Précedent', 'text-domain' ) ),
						'next_text'    => sprintf( '%1$s <i></i>', __( 'Suivant', 'text-domain' ) ),
						'add_args'     => false,
						'add_fragment' => '',
					) );
				?>
			</nav>
		<?php
	}

	public function fl_search_fillter_widget(){
		$type_de_contrat = isset($_GET['type_de_contrat']) ? $_GET['type_de_contrat'] : '';
		$fonction = isset($_GET['fonction']) ? $_GET['fonction'] : '';

		$field_fonction = get_field_object('field_5cd6fcbaaf352');
		$fonction_choices = $field_fonction['choices'];

		$field_type_contrat = get_field_object('field_5cb8f9edf7c23');
		$type_contrat_choices = $field_type_contrat['choices'];

		//var_dump($fonction_choices,$type_contrat_choices);
		
		$allresultsargs = array (
			'post_type'              => array( 'fla_emploi' ),
			'post_status'            => array( 'publish' ),
			'nopaging'               => true
		);
		$allAvailableEmplois = new WP_Query($allresultsargs);
		$allAvailableEmplois = $allAvailableEmplois->found_posts;
		// var_dump($allAvailableEmplois);
		$generalEmploiArgs = array (
			'post_type'              => array( 'fla_emploi' ),
			'post_status'            => array( 'publish' ),
			'nopaging'               => true
		);
		//arrays to hold number of posts founds
		$emploiCountsPerTypeContrat            = array();
		$emploiCountsPerFonction               = array();
		$emploiCountsPerfonctionPerContrat     = array();
		$emploiCountsPerTypeContratPerFonction = array();


		foreach ($type_contrat_choices as $value => $label) {
			$generalEmploiArgs['meta_key'] = 'type_de_contrat';
			$generalEmploiArgs['meta_value'] = $value;
			//var_dump($value);
			//var_dump($generalEmploiArgs);
			$tmpQuery  = new WP_query($generalEmploiArgs);
			$emploiCountsPerTypeContrat[$value] = $tmpQuery->found_posts;
		}
		if ($type_de_contrat != '' && $type_de_contrat !=  'tout') {

			$args = array (
				'post_type'     => array( 'fla_emploi' ),
				'post_status'   => array( 'publish' ),
				'nopaging'      => true
			);

			foreach ($fonction_choices as $value => $label) {
				$metaquery_arr = array(
					'relation'		=> 'AND'
				);
				$metaquery_arr[] = array(
					'key'		=> 'type_de_contrat',
					'value'		=> $type_de_contrat,
					'compare'	=> '='
				);
				$args['meta_query'] = $metaquery_arr;
				$metaquery_arr[] = array(
					'key'		=> 'fonction',
					'value'		=> $value,
					'compare'	=> '='
				);
				$args['meta_query'] = $metaquery_arr;
				
				// var_dump($label);
				// var_dump($args);
				
				$tmpQuery  = new WP_query($args);
				//var_dump($tmpQuery);

				$emploiCountsPerfonctionPerContrat[$value] = $tmpQuery->found_posts;
				
			}//end foreach
		}//end if

		if ($fonction != '' && $fonction !=  'tout') {

			$args = array (
				'post_type'     => array( 'fla_emploi' ),
				'post_status'   => array( 'publish' ),
				'nopaging'      => true
			);

			foreach ($type_contrat_choices as $value => $label) {
				$metaquery_arr = array(
					'relation'		=> 'AND'
				);
				$metaquery_arr[] = array(
					'key'		=> 'fonction',
					'value'		=> $fonction,
					'compare'	=> '='
				);
				$args['meta_query'] = $metaquery_arr;
				$metaquery_arr[] = array(
					'key'		=> 'type_de_contrat',
					'value'		=> $value,
					'compare'	=> '='
				);
				$args['meta_query'] = $metaquery_arr;
				
				// var_dump($label);
				// var_dump($args);
				
				$tmpQuery  = new WP_query($args);
				//var_dump($tmpQuery);

				$emploiCountsPerTypeContratPerFonction[$value] = $tmpQuery->found_posts;
				
			}//end foreach
		}//end if

		foreach ($fonction_choices as $value => $label) {
			$generalEmploiArgs['meta_key'] = 'fonction';
			$generalEmploiArgs['meta_value'] = $value;
			//var_dump($value);
			//var_dump($generalEmploiArgs);
			$tmpQuery  = new WP_query($generalEmploiArgs);
			$emploiCountsPerFonction[$value] = $tmpQuery->found_posts;
		}//end foreach

		//var_dump($emploiCountsPerFonction);
		//var_dump($emploiCountsPerTypeContrat);
		// var_dump($emploiCountsPerfonctionPerContrat);
		// var_dump($emploiCountsPerTypeContratPerFonction);
		

		?>
		<form id="fl_emploi_search_form">

			<select class="jobs_filters_select" name="type_de_contrat" id="type_contrat_select">
				<option value="tout" <?php if( $type_de_contrat == "tout" ): ?> selected="selected"<?php endif; ?>><?php echo __('Type de Contrat','perigord'); ?></option>
				<?php 

					$counts = ($fonction != '' && $fonction !=  'tout')?$emploiCountsPerTypeContratPerFonction:$emploiCountsPerTypeContrat;
					foreach ($type_contrat_choices as $value => $label) {
						if((int)$counts[$value] == 0){continue;}
						?>
						<option value="<?php echo $value; ?>" <?php if( $type_de_contrat == $value ): ?> selected="selected"<?php endif; ?>><?php echo $label; ?> #<?php echo $counts[$value]; ?></option>
						<?php
					}
				?>
			</select>


			<select class="jobs_filters_select" name="fonction" id="fonction_select">
			<option value="tout" <?php if( $fonction == "tout" ): ?> selected="selected"<?php endif; ?>><?php echo __('Fonction','perigord'); ?></option>
			<?php 
				$counts = ($type_de_contrat != '' && $type_de_contrat !=  'tout')?$emploiCountsPerfonctionPerContrat:$emploiCountsPerFonction;
				foreach ($fonction_choices as $value => $label) {
					if((int)$counts[$value] == 0){continue;}
					?>
					<option value="<?php echo $value; ?>" <?php if( $fonction == $value ): ?> selected="selected"<?php endif; ?>><?php echo $label; ?> #<?php echo $counts[$value]; ?></option>
					<?php
				}
			?>
			</select>
			
			<?php	$sort_result_by  = isset($_GET['sort_result_by']) ? $_GET['sort_result_by'] : ''; ?>	
				
				<select name="sort_result_by" id="fla_emploi_sort_result_by" onchange="this.form.submit()">
					<option value="0" <?php if($sort_result_by == "0"): ?> selected="selected"<?php endif; ?>><?php echo __('Classement','perigord'); ?></option>
					<option value="1" <?php if($sort_result_by == "1"): ?> selected="selected"<?php endif; ?>>Date ascendant</option>
					<option value="2" <?php if($sort_result_by == "2"): ?> selected="selected"<?php endif; ?>>Date descendant</option>
					<option value="3" <?php if($sort_result_by == "3"): ?> selected="selected"<?php endif; ?>>Fonction</option>
					<option value="4" <?php if($sort_result_by == "4"): ?> selected="selected"<?php endif; ?>>Type de contrat</option>
				</select>

			<button class="jobs_filters_btn">Filtrer</button>
		
		</form>
		<?php
	}//end function

	public function fl_search_result_widget(){
		
		$sort_result_by  = isset($_GET['sort_result_by']) ? $_GET['sort_result_by'] : '';
		$type_de_contrat = isset($_GET['type_de_contrat']) ? $_GET['type_de_contrat'] : '';
		$fonction        = isset($_GET['fonction']) ? $_GET['fonction'] : '';

		$sort_meta_key = '';
		$sort_by       = 'menu_order';
		$sort_order    = 'ASC';
		
		switch ($sort_result_by) {
			case '1':
				$sort_meta_key = '';
				$sort_by       = 'date';
				$sort_order    = 'ASC';
				break;
			case '2':
				$sort_meta_key = '';
				$sort_by       = 'date';
				$sort_order    = 'DESC';
				break;
			case '3':
				$sort_meta_key = 'fonction';
				$sort_by       = 'meta_value';
				$sort_order    = 'ASC';
				break;
			case '4':
				$sort_meta_key = 'type_de_contrat';
				$sort_by       = 'meta_value';
				$sort_order    = 'ASC';
				break;
			
			default:
				break;
		}



		//echo "type de contra = " . $type_de_contrat;
		
			# code...
			// WP_Query arguments
			$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
			$args = array (
				'post_type'              => array( 'fla_emploi' ),
				'post_status'            => array( 'publish' ),
				'order'                  => $sort_order,
				'meta_key'			     => $sort_meta_key,
				'orderby'                => $sort_by,
				'posts_per_page'         => 9,
        		'paged'                  => $paged
			);

			$metaquery_arr = array(
				'relation'		=> 'AND'
			);
			if ($type_de_contrat != "" && $type_de_contrat != "tout") {
				# code...
				$metaquery_arr[] = array(
					'key'		=> 'type_de_contrat',
					'value'		=> $type_de_contrat,
					'compare'	=> '='
				);
				$args['meta_query'] = $metaquery_arr;
				// $args['meta_key'] = 'type_de_contrat';
				// $args['meta_value'] = $type_de_contrat;
				
			}
			if ($fonction != "" && $fonction != "tout") {
				# code...
				$metaquery_arr[] = array(
					'key'		=> 'fonction',
					'value'		=> $fonction,
					'compare'	=> '='
				);
				$args['meta_query'] = $metaquery_arr;
				
			}
			//var_dump($args);
			// The Query
			$emplois = new WP_Query( $args );
			//var_dump($emplois);

			// The Loop
			if ( $emplois->have_posts() ) {
				//var_dump($emplois);
				echo "<h3>Nombre de resulta : " . ($emplois->found_posts) . "</h3>"
				?>
				<!-- <div class="result_container"> -->
				<ul class="jobs_list flex space-between">
					<?php
				while ( $emplois->have_posts() ) {
					$emplois->the_post();
					?>
						<li class="jobs_list_item">

							<div class="jobs_item_figure flex space-center align-center">
								<?php 
									$entreprise = get_field('entreprise');
									if( $entreprise ): ?>
										<?php foreach( $entreprise as $p): // variable must be called $p (IMPORTANT)
											//var_dump($p);
											?>
												<!-- <h2><?php //echo get_the_title($p->ID); ?></h2> -->
												<img src="<?php echo get_field('logo', $p->ID)['url']; ?>" alt="" class="jobs_item_logo">
										<?php endforeach; ?>
										
								<?php endif; ?>
							</div>

							<div class="jobs_item_summary">

								<div class="jobs_item_date caps">
									<?php echo get_the_modified_date(); ?>
								</div>

								<h2 class="jobs_item_title caps">
									<?php the_title(); ?>
								</h2>

								<div class="jobs_item_tags caps">
									<?php the_field('type_de_contrat'); ?> - <?php the_field('fonction') ?> - <?php echo get_field('localisation')['label']; ?>
								</div>

								<div class="jobs_item_description">
									<?php echo substr(get_field('descriptif'),0,120).'...';  ?>
								</div>

								<a href="<?php the_permalink(); ?>" class="jobs_item_link flex space-center align-center strong fs">
									<span class="link_txt">Détails</span>
								</a>

							</div>

						</li>
					
					<?php
				}
				?> 
				</ul>
				<!-- </div> -->
				<?php $this->fla_emploi_paginationtemplate($emplois); ?>
				 <?php
			} else {
				// no posts found
				echo '<h2>aucun resultat</h2>';
			}

			// Restore original Post Data
			wp_reset_postdata();
		
	}//end function


	//sollicitations widgets
	public function fl_search_sollicitation_fillter_widget(){
		$fonction = isset($_GET['fonction']) ? $_GET['fonction'] : '';
		$field_fonction = get_field_object('field_5cd6fcbaaf352');
		$fonction_choices = $field_fonction['choices'];
		?>
		<form id="fl_sollicitation_search_form">

			<div>
				<label for="fonction">Fonction</label>
				<select name="fonction">
				<option value="tout" <?php if( $fonction == "tout" ): ?> selected="selected"<?php endif; ?>>Tout</option>
					<?php
					foreach ($fonction_choices as $value => $label) {
						?>
						<option value="<?php echo $value; ?>" <?php if( $fonction == $value ): ?> selected="selected"<?php endif; ?>><?php echo $label; ?></option>
						<?php
					}
					?>
				</select>
			</div>

			<div>
				<button>Rechercher</button>
			</div>
		</form>
		<?php
	}//end function

	public function fl_search_sollicitaions_result_widget(){
		
		$fonction = isset($_GET['fonction']) ? $_GET['fonction'] : '';
		echo "fonction = " . $fonction;
		
			# code...
			// WP_Query arguments
			$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

			$args = array (
				'post_type'              => array( 'fla_sollicitation' ),
				'post_status'            => array( 'publish' ),
				'order'                  => 'ASC',
				'orderby'                => 'menu_order',
				'posts_per_page'         => 9,
        		'paged'                  => $paged
			);

			$metaquery_arr = array(
				'relation'		=> 'AND'
			);
			
			if ($fonction != "" && $fonction != "tout") {
				# code...
				$metaquery_arr[] = array(
					'key'		=> 'fonction',
					'value'		=> $fonction,
					'compare'	=> '='
				);
				$args['meta_query'] = $metaquery_arr;
				
			}
			//var_dump($args);
			// The Query
			$sollicitations = new WP_Query( $args );

			// The Loop
			if ( $sollicitations->have_posts() ) {
				//var_dump($sollicitations);
				echo "<h3>Nombre de resulta : " . ($sollicitations->found_posts) . "</h3>"
				?>
				<div class="result_container">
					<?php
				while ( $sollicitations->have_posts() ) {
					$sollicitations->the_post();
					?>
					
						<div class="result_item">
							<a href="<?php the_permalink(); ?>">
								<div>
									<h3><?php the_title(); ?></h3>
									<em><?php echo get_the_modified_date(); ?></em>
									<h5><?php echo get_field('fonction')['label'] ?></h5>
									<?php 
									$entreprise = get_field('entreprise');
									if( $entreprise ): ?>
										<?php foreach( $entreprise as $p): // variable must be called $p (IMPORTANT)
											//var_dump($p);
											?>
												<h2><?php echo get_the_title($p->ID); ?></h2>
												<img style="height: 100px;" src="<?php echo get_field('logo', $p->ID)['url']; ?>" />
										<?php endforeach; ?>
										
									<?php endif; 
									?>
									<p><?php echo substr(get_field('message'),0,120).'...';  ?></p>
								</div>
							</a>
						</div>
					
					<?php
				}
				?> </div>
				<?php $this->fla_emploi_paginationtemplate($sollicitations); ?>
				<?php
			} else {
				// no posts found
				echo '<h2>aucun resultat</h2>';
			}

			// Restore original Post Data
			wp_reset_postdata();
		
	}//end function

	/* Filter the single_template with our custom function*/

	public function fla_emploi_single_custom_post_template($single) {

		global $post;

		/* Checks for single template by post type */
		if ( $post->post_type == 'fla_emploi' ) {
			
			if ( file_exists( plugin_dir_path( __FILE__ ) . 'partials/emploi-single.php' ) ) {
				return plugin_dir_path( __FILE__ ) . 'partials/emploi-single.php';
			}
		}

		if ( $post->post_type == 'fla_entreprise' ) {
			
			if ( file_exists( plugin_dir_path( __FILE__ ) . 'partials/entreprise-single.php' ) ) {
				return plugin_dir_path( __FILE__ ) . 'partials/entreprise-single.php';
			}
		}

		if ( $post->post_type == 'fla_sollicitation' ) {
			
			if ( file_exists( plugin_dir_path( __FILE__ ) . 'partials/sollicitation-single.php' ) ) {
				return plugin_dir_path( __FILE__ ) . 'partials/sollicitation-single.php';
			}
		}

		return $single;

	}

	public function register_shortcodes(){

		//add endpoints
		add_rewrite_endpoint( 'manager-login', EP_PERMALINK | EP_PAGES );
		add_rewrite_endpoint( 'manager-admin', EP_PERMALINK | EP_PAGES );
		add_rewrite_endpoint( 'edit_emploi', EP_PERMALINK | EP_PAGES );
		add_rewrite_endpoint( 'import-olddb', EP_PERMALINK | EP_PAGES );

		add_shortcode( 'fl_emploi_recherche', array($this,'fl_search_fillter_widget') );
		add_shortcode( 'fl_emploi_result', array($this,'fl_search_result_widget') );
		add_shortcode( 'fl_sollicitations_search', array($this,'fl_search_sollicitation_fillter_widget') );
		add_shortcode( 'fl_sollicitations_result', array($this,'fl_search_sollicitaions_result_widget') );
		

		//disable admin bar for managers
		if (current_user_can('emploi_manager')) {
			add_filter('show_admin_bar', '__return_false');
		}
		
	}

	public function fla_emploi_filter_title($title_parts)
	{
		$title_parts['title'] = "Ninja";
		return $title_parts;
	}

	public function fla_emploi_routing($template)
	{
		$url_path = trim(parse_url(add_query_arg(array()), PHP_URL_PATH), '/');
		switch ($url_path) {
			case 'manager-login':
				// load the file if exists
				$load = locate_template(array(plugin_dir_path( __FILE__ ).'partials/emploi-login.php'), true, false);
				
				if ($load === "") {
					$template = plugin_dir_path( __FILE__ ).'partials/emploi-login.php';
				}
				break;
			case 'manager-admin':
				// load the file if exists
				$load = locate_template(array(plugin_dir_path( __FILE__ ).'partials/manager-admin.php'), true, false);
				
				if ($load === "") {
					$template = plugin_dir_path( __FILE__ ).'partials/manager-admin.php';
				}
				break;
			case 'edit_emploi':
				// load the file if exists
				$load = locate_template(array(plugin_dir_path( __FILE__ ).'partials/emploi-edit.php'), true, false);
				
				if ($load === "") {
					$template = plugin_dir_path( __FILE__ ).'partials/emploi-edit.php';
				}
				break;
			case 'ajouter-emploi':
				// load the file if exists
				$load = locate_template(array(plugin_dir_path( __FILE__ ).'partials/emploi-new.php'), true, false);
				
				if ($load === "") {
					$template = plugin_dir_path( __FILE__ ).'partials/emploi-new.php';
				}
				break;
			case 'edit_sollicitation':
				// load the file if exists
				$load = locate_template(array(plugin_dir_path( __FILE__ ).'partials/sollicitation-edit.php'), true, false);
				
				if ($load === "") {
					$template = plugin_dir_path( __FILE__ ).'partials/sollicitation-edit.php';
				}
				break;
			case 'ajouter-sollicitation':
				// load the file if exists
				$load = locate_template(array(plugin_dir_path( __FILE__ ).'partials/sollicitation-new.php'), true, false);
				
				if ($load === "") {
					$template = plugin_dir_path( __FILE__ ).'partials/sollicitation-new.php';
				}
				break;

			case 'import-olddb':
				// load the file if exists
				$load = locate_template(array(plugin_dir_path( __FILE__ ).'partials/import.php'), true, false);
				
				if ($load === "") {
					$template = plugin_dir_path( __FILE__ ).'partials/import.php';
				}
				break;
			default:
				break;
		}
		
			return $template;
	}

	public function fla_emploi_show_current_user_attachments( $query = array() ) {
		$user_id = get_current_user_id();
		if(current_user_can('emploi_manager')){
			if( $user_id ) {
				$query['author'] = $user_id;
			}
		}
		
		return $query;
	}//end function fla_emploi_show_current_user_attachments

	/**ajax requests functions*/
	public function fla_emploi_update_entreprise()
	{
		//init output object
		$output = new StdClass();
		$output->status = 'success';
		$output->errorText = '';
		$output->result = '';

		//retrieve post data
	
		$entrepriseID = (isset($_POST['id'])) ? $_POST['id'] : '';
		$title = (isset($_POST['title'])) ? $_POST['title'] : '';
		
		$descriptif = (isset($_POST['descriptif'])) ? $_POST['descriptif'] : '';
		$adresse = (isset($_POST['adresse'])) ? $_POST['adresse'] : '';
		$email = (isset($_POST['email'])) ? $_POST['email'] : '';
		$secteur = (isset($_POST['secteur'])) ? $_POST['secteur'] : '';
		$site = (isset($_POST['site'])) ? $_POST['site'] : '';
		$telephone = (isset($_POST['telephone'])) ? $_POST['telephone'] : '';
		$latitude = (isset($_POST['latitude'])) ? $_POST['latitude'] : '';
		$longitude = (isset($_POST['longitude'])) ? $_POST['longitude'] : '';
		$logo = (isset($_POST['logoID'])) ? (int)$_POST['logoID'] : '';

		//save acf fields in an array
		$entreprise_fields_arr = array(
			'descriptif'         => $descriptif,
			'adresse'            => $adresse,
			'mail'               => $email,
			'telephone'          => $telephone,
			'site_internet'      => $site,
			'longitude'          => $longitude,
			'latitude'           => $latitude,
			'secteur_dactivites' => $secteur,
			'logo'               => $logo

		);

		//if id of entreprise not defined exit and throw error
		if ($entrepriseID === '') {
			$output->status = 'error';
			$output->errorText = 'entreprise ID not found';
			echo  json_encode($output);
			wp_die();
		}
		
		//update the post title
		$currentEntreprise = array(
			'ID'           => $entrepriseID,
			'post_title'   => $title
		);

		$entreprise_updated = wp_update_post($currentEntreprise, true);
		//if post title not updated halt and throw error
		if (is_wp_error($entreprise_updated)) {
			
			$output->status = 'error';
			$errors = $entreprise_updated->get_error_messages();
			foreach ($errors as $error) {
				$output->errorText .= " ".$error;
			}
			echo  json_encode($output);
			wp_die();
		}else {
			//if post title update then update extra fields (acf)
			foreach ($entreprise_fields_arr as $field_name => $field_value) {
				$field_updated = update_field($field_name, $field_value, $entrepriseID);
				//if a field not updated throw error
				if (!$field_updated) {
					$output->errorText .= 'can\'t update ' .$field_name.' ';
				}
			}
		}

		echo  json_encode($output);
		wp_die();
	}//end function fla_emploi_update_entreprise

	public function fla_emploi_update_emploi_data()
	{
		//init output object
		$output = new StdClass();
		$output->status = 'success';
		$output->errorText = '';
		$output->result = '';

		//collect post data
		$emploiID = isset($_POST['id'])?(int)$_POST['id']:0;
		$emploiTitle = isset($_POST['title'])?$_POST['title']:'';

		$type_de_contrat = isset($_POST['type_de_contrat'])?$_POST['type_de_contrat']:'';
		$fonction = isset($_POST['fonction'])?json_decode(json_encode($_POST['fonction'])):'';
		$localisation = isset($_POST['localisation'])?$_POST['localisation']:'';
		$descriptif = isset($_POST['descriptif'])?$_POST['descriptif']:'';
		$profile = isset($_POST['profile'])?$_POST['profile']:'';
		$contact_rh = isset($_POST['contact_rh'])?$_POST['contact_rh']:'';
		$fiche_de_post = isset($_POST['fiche_de_post'])?(int)$_POST['fiche_de_post']:0;
		$longitude = isset($_POST['longitude'])?$_POST['longitude']:'';
		$latitude = isset($_POST['latitude'])?$_POST['latitude']:'';

		$emploi_fieldss_arr = array(
			'type_de_contrat'   => $type_de_contrat,
			'fonction'          => $fonction->value,
			'longitude'         => $longitude,
			'latitude'          => $latitude,
			'localisation'      => $localisation,
			'descriptif'        => $descriptif,
			'profil_recherche'  => $profile,
			'fiche_de_poste'    => $fiche_de_post,
			'contact_rh'        => $contact_rh
		);

		//if emploi id not set throw error
		if ($emploiID == 0) {
			$output->status = "error";
			$output->errorText = "emploi id not found";
			echo  json_encode($output);
			wp_die();
		}

		//update the post title
		$currentEmploi = array(
			'ID'           => $emploiID,
			'post_title'   => $emploiTitle
		);

		$emploi_updated = wp_update_post($currentEmploi, true);
		//if post title not updated halt and throw error
		if (is_wp_error($emploi_updated)) {
			
			$output->status = 'error';
			$errors = $emploi_updated->get_error_messages();
			foreach ($errors as $error) {
				$output->errorText .= " ".$error;
			}
			echo  json_encode($output);
			wp_die();
		}else {
			//if post title update then update extra fields (acf)
			foreach ($emploi_fieldss_arr as $field_name => $field_value) {
				$field_updated = update_field($field_name, $field_value, $emploiID);
				//if a field not updated throw error
				if (!$field_updated) {
					$output->errorText .= 'can\'t update ' .$field_name.' ';
				}
			}
		}


		echo  json_encode($output);
		wp_die();
	}//end function

	public function fla_emploi_update_sollicitation_data()
	{
		//init output object
		$output = new StdClass();
		$output->status = 'success';
		$output->errorText = '';
		$output->result = '';

		//collect post data
		$sollicitationID = isset($_POST['id'])?(int)$_POST['id']:0;
		$sollicitationTitle = isset($_POST['title'])?$_POST['title']:'';

		$fonction = isset($_POST['fonction'])?json_decode(json_encode($_POST['fonction'])):'';
		$message  = isset($_POST['message'])?$_POST['message']:'';
		$profile  = isset($_POST['profile'])?$_POST['profile']:'';
		$cv       = isset($_POST['cv'])?(int)$_POST['cv']:0;
		$lm       = isset($_POST['lm'])?(int)$_POST['lm']:0;
		$conjoint = isset($_POST['conjoint'])?(int)$_POST['conjoint']:0;


		$sollicitation_fieldss_arr = array(
			'fonction'          => $fonction->value,
			'message'           => $descriptif,
			'cv'                => $cv,
			'lettre_motivation' => $lm,
			'conjoint'          => $conjoint 
		);

		//if sollicitation id not set throw error
		if ($sollicitationID == 0) {
			$output->status = "error";
			$output->errorText = "sollicitation id not found";
			echo  json_encode($output);
			wp_die();
		}

		//update the post title
		$currentSollicitation = array(
			'ID'           => $sollicitationID,
			'post_title'   => $sollicitationTitle
		);

		$sollicitation_updated = wp_update_post($currentSollicitation, true);
		//if post title not updated halt and throw error
		if (is_wp_error($sollicitation_updated)) {
			
			$output->status = 'error';
			$errors = $sollicitation_updated->get_error_messages();
			foreach ($errors as $error) {
				$output->errorText .= " ".$error;
			}
			echo  json_encode($output);
			wp_die();
		}else {
			//if post title update then update extra fields (acf)
			foreach ($sollicitation_fieldss_arr as $field_name => $field_value) {
				$field_updated = update_field($field_name, $field_value, $sollicitationID);
				//if a field not updated throw error
				if (!$field_updated) {
					$output->errorText .= 'can\'t update ' .$field_name.' ';
				}
			}
		}


		echo  json_encode($output);
		wp_die();
	}//end function
	public function fla_emploi_add_new_emploi()
	{
		//init output object
		$output = new StdClass();
		$output->status = 'success';
		$output->errorText = '';
		$output->result = '';

		//collect post data
		$emploiTitle = isset($_POST['title'])?$_POST['title']:'';

		$type_de_contrat = isset($_POST['type_de_contrat'])?$_POST['type_de_contrat']:'';
		$fonction        = isset($_POST['fonction'])?json_decode(json_encode($_POST['fonction'])):'';
		$localisation    = isset($_POST['localisation'])?$_POST['localisation']:'';
		$descriptif      = isset($_POST['descriptif'])?$_POST['descriptif']:'';
		$profile         = isset($_POST['profile'])?$_POST['profile']:'';
		$contact_rh      = isset($_POST['contact_rh'])?$_POST['contact_rh']:'';
		$fiche_de_post   = isset($_POST['fiche_de_post'])?(int)$_POST['fiche_de_post']:0;
		$longitude       = isset($_POST['longitude'])?$_POST['longitude']:'';
		$latitude        = isset($_POST['latitude'])?$_POST['latitude']:'';
		$entreprise      = isset($_POST['entreprise'])?(int)$_POST['entreprise']:0;

		$emploi_fieldss_arr = array(
			'type_de_contrat'   => $type_de_contrat,
			'fonction'          => $fonction->value,
			'longitude'         => $longitude,
			'latitude'          => $latitude,
			'localisation'      => $localisation,
			'descriptif'        => $descriptif,
			'profil_recherche'  => $profile,
			'fiche_de_poste'    => $fiche_de_post,
			'contact_rh'        => $contact_rh,
			'entreprise'        => $entreprise
		);


		//update the post title
		$newEmploi = array(
			'post_title'     => $emploiTitle,
			'post_type'      => 'fla_emploi',
			'post_status'    => 'publish',
			'comment_status' => 'closed',
			'ping_status'    => 'closed'
		);

		

		$emploi_added = wp_insert_post( $newEmploi, true );
		//if post title not added halt and throw error
		if (is_wp_error($emploi_added)) {
			
			$output->status = 'error';
			$errors = $emploi_added->get_error_messages();
			foreach ($errors as $error) {
				$output->errorText .= " ".$error;
			}
			echo  json_encode($output);
			wp_die();
		}else {
			//if post added then update extra fields (acf)
			
			foreach ($emploi_fieldss_arr as $field_name => $field_value) {
				$field_updated = update_field($field_name, $field_value, $emploi_added);
				//if a field not updated throw error
				if (!$field_updated) {
					$output->errorText .= 'can\'t update ' .$field_name.' ';
				}
			}
		}

		$new_emploi_url = get_the_permalink( $emploi_added);

		$output->result = $new_emploi_url;

		echo  json_encode($output);
		wp_die();
	}//end function


	public function fla_emploi_add_new_sollicitation()
	{
		//init output object
		$output = new StdClass();
		$output->status = 'success';
		$output->errorText = '';
		$output->result = '';

		$sollicitationID = isset($_POST['id'])?(int)$_POST['id']:0;
		$sollicitationTitle = isset($_POST['title'])?$_POST['title']:'';

		$fonction = isset($_POST['fonction'])?json_decode(json_encode($_POST['fonction'])):'';
		$message  = isset($_POST['message'])?$_POST['message']:'';
		$profile  = isset($_POST['profile'])?$_POST['profile']:'';
		$cv       = isset($_POST['cv'])?(int)$_POST['cv']:0;
		$lm       = isset($_POST['lm'])?(int)$_POST['lm']:0;
		$conjoint = isset($_POST['conjoint'])?(int)$_POST['conjoint']:0;
		$entreprise = isset($_POST['entreprise'])?(int)$_POST['entreprise']:0;


		$sollicitation_fields_arr = array(
			'fonction'          => $fonction->value,
			'message'           => $descriptif,
			'cv'                => $cv,
			'lettre_motivation' => $lm,
			'conjoint'          => $conjoint,
			'entreprise'        => $entreprise
		);


		//update the post title
		$newSollicitation = array(
			'post_title'     => $sollicitationTitle,
			'post_type'      => 'fla_sollicitation',
			'post_status'    => 'publish',
			'comment_status' => 'closed',
			'ping_status'    => 'closed'
		);

		

		$sollicitation_added = wp_insert_post( $newSollicitation, true );
		//if post title not added halt and throw error
		if (is_wp_error($sollicitation_added)) {
			
			$output->status = 'error';
			$errors = $sollicitation_added->get_error_messages();
			foreach ($errors as $error) {
				$output->errorText .= " ".$error;
			}
			echo  json_encode($output);
			wp_die();
		}else {
			//if post added then update extra fields (acf)
			
			foreach ($sollicitation_fields_arr as $field_name => $field_value) {
				$field_updated = update_field($field_name, $field_value, $sollicitation_added);
				//if a field not updated throw error
				if (!$field_updated) {
					$output->errorText .= 'can\'t update ' .$field_name.' ';
				}
			}
		}

		$new_sollicitation_url = get_the_permalink( $sollicitation_added);

		$output->result = $new_sollicitation_url;

		echo  json_encode($output);
		wp_die();
	}//end function

	public function fla_emploi_delete_emploi()
	{
		//init output object
		$output = new StdClass();
		$output->status = 'success';
		$output->errorText = '';
		$output->result = '';

		//collect data
		$emploiID = isset($_POST['id_to_delete'])?(int)$_POST['id_to_delete']:0;

		if ($emploiID == 0) {
			$output->status = 'error';
			echo json_encode($output);
			wp_die();
		}

		$currentEmploi = array(
			'ID'           => $emploiID,
			'post_status'   => 'trash'
		);

		$emploi_updated = wp_update_post($currentEmploi, true);
		//if post title not updated halt and throw error
		if (is_wp_error($emploi_updated)) {
			
			$output->status = 'error';
			$errors = $emploi_updated->get_error_messages();
			foreach ($errors as $error) {
				$output->errorText .= " ".$error;
			}
			echo  json_encode($output);
			wp_die();
		}

		echo  json_encode($output);
		wp_die();
	}//end function


	public function fla_emploi_archive_emploi()
	{
		//init output object
		$output = new StdClass();
		$output->status = 'success';
		$output->errorText = '';
		$output->result = '';

		//collect data
		$emploiID = isset($_POST['id_to_archive'])?(int)$_POST['id_to_archive']:0;

		if ($emploiID == 0) {
			$output->status = 'error';
			echo json_encode($output);
			wp_die();
		}

		$currentEmploi = array(
			'ID'           => $emploiID,
			'post_status'   => 'draft'
		);

		$emploi_updated = wp_update_post($currentEmploi, true);
		//if post title not updated halt and throw error
		if (is_wp_error($emploi_updated)) {
			
			$output->status = 'error';
			$errors = $emploi_updated->get_error_messages();
			foreach ($errors as $error) {
				$output->errorText .= " ".$error;
			}
			echo  json_encode($output);
			wp_die();
		}

		echo  json_encode($output);
		wp_die();
	}//end function


	public function fla_emploi_delete_sollicitation()
	{
		//init output object
		$output = new StdClass();
		$output->status = 'success';
		$output->errorText = '';
		$output->result = '';

		//collect data
		$sollicitationID = isset($_POST['id_to_delete'])?(int)$_POST['id_to_delete']:0;

		if ($sollicitationID == 0) {
			$output->status = 'error';
			echo json_encode($output);
			wp_die();
		}

		$currentSollicitation = array(
			'ID'           => $sollicitationID,
			'post_status'   => 'trash'
		);

		$sollicitation_updated = wp_update_post($currentSollicitation, true);
		//if post title not updated halt and throw error
		if (is_wp_error($sollicitation_updated)) {
			
			$output->status = 'error';
			$errors = $sollicitation_updated->get_error_messages();
			foreach ($errors as $error) {
				$output->errorText .= " ".$error;
			}
			echo  json_encode($output);
			wp_die();
		}

		echo  json_encode($output);
		wp_die();
	}//end function


	public function fla_emploi_archive_sollicitation()
	{
		//init output object
		$output = new StdClass();
		$output->status = 'success';
		$output->errorText = '';
		$output->result = '';

		//collect data
		$sollicitationID = isset($_POST['id_to_archive'])?(int)$_POST['id_to_archive']:0;

		if ($sollicitationID == 0) {
			$output->status = 'error';
			echo json_encode($output);
			wp_die();
		}

		$currentSollicitation = array(
			'ID'           => $sollicitationID,
			'post_status'   => 'draft'
		);

		$sollicitation_updated = wp_update_post($currentSollicitation, true);
		//if post title not updated halt and throw error
		if (is_wp_error($sollicitation_updated)) {
			
			$output->status = 'error';
			$errors = $sollicitation_updated->get_error_messages();
			foreach ($errors as $error) {
				$output->errorText .= " ".$error;
			}
			echo  json_encode($output);
			wp_die();
		}

		echo  json_encode($output);
		wp_die();
	}//end function

	public function fla_emploi_get_result_counts_by_contrat()
	{
		//init output object
		$output = new StdClass();
		$output->status = 'success';
		$output->errorText = '';
		$output->result = '';

		//collect data
		$fonction = isset($_POST['fonction'])?(int)$_POST['fonction']:0;

		$field_type_contrat = get_field_object('field_5cb8f9edf7c23');
		$type_contrat_choices = $field_type_contrat['choices'];


		$emploiCountsPerTypeContratPerFonction = array();
		foreach ($type_contrat_choices as $value => $label) {
			$metaquery_arr = array(
				'relation'		=> 'AND'
			);
			$metaquery_arr[] = array(
				'key'		=> 'fonction',
				'value'		=> 1,
				'compare'	=> '='
			);
			$args['meta_query'] = $metaquery_arr;
			$metaquery_arr[] = array(
				'key'		=> 'type_de_contrat',
				'value'		=> $value,
				'compare'	=> '='
			);
			$args['meta_query'] = $metaquery_arr;
			
			
			$tmpQuery  = new WP_query($args);

			$emploiCountsPerTypeContratPerFonction[$value] = $tmpQuery->found_posts;
			
		}//end foreach

		$output->result = json_encode($emploiCountsPerTypeContratPerFonction);

		echo  json_encode($output);
		wp_die();
	}//end function

}
