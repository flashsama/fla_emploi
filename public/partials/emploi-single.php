<?php
/**
 * The template for displaying all single jobs (emploi).
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
            <h2>Intitulé du post : </h2>
            <h3><?php the_title(); ?></h3>
            <h2>Fonction : </h2>
            <h3><?php the_field('fonction'); ?></h3>
            <h2>Localisation : </h2>
            <h3><?php echo "(" . get_field('longitude') . "," . get_field('latitude') . ")"; ?></h3>
            <h2>Description du post : </h2>
            <p><?php the_field('descriptif'); ?></p>
            <h2>Profil recherché : </h2>
            <p><?php the_field('profil_recherche'); ?></p>
            <h2>Fiche de poste : </h2>
            <p><a target="_blank" href="<?php the_field('fiche_de_poste'); ?>">Telecharger le PDF</a></p>
            <h2>Contact RH : </h2>
            <h3><?php the_field(contact_rh); ?></h3>
            <h2>Entreprise : </h2>
            <?php 
            $entreprise = get_field('entreprise');
                if( $entreprise ): ?>
                    <?php foreach( $entreprise as $p): // variable must be called $p (IMPORTANT)
                        //var_dump($p);
                        ?>
                            <a href="<?php the_permalink($p->ID); ?>"><h2><?php echo get_the_title($p->ID); ?></h2></a>
                            <img src="<?php the_field('logo', $p->ID); ?>" />
                            <p><?php the_field('secteur_dactivites', $p->ID); ?></p>
                            <p><?php the_field('descriptif', $p->ID); ?></p>
                            <p><?php the_field('adresse', $p->ID); ?></p>
                            <p><?php the_field('telephone', $p->ID); ?></p>
                            <p><?php the_field('site_internet', $p->ID); ?></p>
                            <p><?php the_field('mail', $p->ID); ?></p>

                    <?php endforeach; ?>
                    
                <?php endif; 
            ?>
        <?php
		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php

get_footer();
