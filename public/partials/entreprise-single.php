<?php
/**
 * The template for displaying all single company (entreprise).
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Flash emploi
 */
get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
        while ( have_posts() ) : the_post();
        //var_dump(get_fields());
        ?>
            <h3><?php the_title(); ?></h3>
            <img src="<?php the_field('logo'); ?>" />
            <p><?php the_field('secteur_dactivites'); ?></p>
            <p><?php the_field('descriptif'); ?></p>
            <p><?php the_field('adresse'); ?></p>
            <p><?php the_field('telephone'); ?></p>
            <p><?php the_field('site_internet'); ?></p>
            <p><?php the_field('mail'); ?></p>
            <h2>Localisation : </h2>
            <h3><?php echo "(" ; the_field('longitude') ;echo "," ; the_field('latitude') ;echo ")"; ?></h3>
            <h2>Manager : </h2>
            <?php 
            $managerID = get_field('manager_dentreprise');
            $manager = get_user_by('id',$managerID);
            echo $manager->data->display_name;
            //var_dump($manager);
            ?>
            <h3>Toutes les offres de cette entreprise</h3>
            <?php
                $emplois = get_posts(array(
                    'numberposts'	=> -1,
                    'post_type'		=> 'fla_emploi',
                    'meta_query' => array(
                        array(
                            'key' => 'entreprise', // name of custom field
                            'value' => '"' . get_the_ID() . '"', // matches exactly "123", not just 123. This prevents a match for "1234"
                            'compare' => 'LIKE'
                        )
                    )
                ));
                ?>
                <ul>
                <?php
                foreach ($emplois as $emploi) {
                   ?>
                   <li><a href="<?php the_permalink($emploi->ID); ?>"><?php echo get_the_title($emploi->ID); ?></a></li>
                   <?php
                }
                ?>
                </ul>
                <?php
                //var_dump($emplois);
            ?>
            
        <?php
		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php

get_footer();
