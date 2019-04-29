<?php
/**
 * The template for displaying admin panel for managers to CRUD job offers.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Flash emploi
 */
if (!is_user_logged_in()) {
    //redirect to manager login
    wp_redirect( '/manager-login' );
    exit;
}

$entreprises = get_posts(array(
	'numberposts'	=> -1,
	'post_type'		=> 'fla_entreprise',
	'meta_key'		=> 'manager_dentreprise',
	'meta_value'	=> $user_ID
));
// $entreprise = $entreprise[0];
// echo '<pre>';
// var_dump   ($entreprises);
// echo '</pre>';
get_header(); ?>

	<h1>Manager panel</h1>

    <h2>Bienvenue : <?php echo $user_login; ?></h2>
    <?php
    foreach ($entreprises as $entreprise) {
        ?>
        <a href="<?php the_permalink($entreprise->ID); ?>"><h3>entreprise : <?php echo $entreprise->post_title; ?></h3></a>
        <?php
    }
    ?>

<?php

get_footer();
