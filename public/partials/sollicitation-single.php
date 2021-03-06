<?php
/**
 * The template for displaying all single sollicitations .
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
        ?>
        <h1><?php the_title(); ?></h1>
        <?php

        $entreprise = get_field('entreprise')[0];
        $managerID = get_field('manager_dentreprise', $entreprise->ID);

        ?>
        <div>
        <?php
        if(is_user_logged_in() && $user_ID == $managerID){
            echo 'you can edit';
            ?>
            <a href="/edit_sollicitation?id=<?php echo (int)get_the_ID(); ?>" id="fla_edit_offre_sollicitation_btn" >Modifier offre de sollicitation</a>
            <?php 
        }else {
            echo 'you can not edit';
        } ?>
        </div>
        <?php
        //var_dump(get_fields());
        ?>
            <em><?php echo get_the_modified_date(); ?></em>
            <h2>Intitulé du post : </h2>
            <h3><?php the_title(); ?></h3>
            <h2>Conjoint : </h2>
            <h3><?php echo ((int)get_field('conjoint') == 1)?'Oui':'Non'; ?></h3>
            <h2>Fonction : </h2>
            <h3><?php echo get_field('fonction')['label']; ?></h3>
            <h2>Message : </h2>
            <p><?php the_field('message'); ?></p>
            <h2>cv : </h2>
            <?php if(get_field('cv')['url']) { ?>
            <p><a target="_blank" href="<?php echo get_field('cv')['url']; ?>">Telecharger le PDF</a></p>
            <?php } else { ?>
                auccune fiche n'est ajoutée
            <?php } ?>
            <h2>lettre de motivation : </h2>
            <?php if(get_field('lettre_motivation')['url']) { ?>
            <p><a target="_blank" href="<?php echo get_field('lettre_motivation')['url']; ?>">Telecharger le PDF</a></p>
            <?php } else { ?>
                auccune fiche n'est ajoutée
            <?php } ?>
            <h2>Entreprise : </h2>
            <?php 
                if( $entreprise ): ?>

                    <a href="<?php the_permalink($entreprise->ID); ?>"><h2><?php echo get_the_title($entreprise->ID); ?></h2></a>
                    <img src="<?php echo get_field('logo', $entreprise->ID)['url']; ?>" />
                    <p><?php the_field('secteur_dactivites', $entreprise->ID); ?></p>
                    <p><?php the_field('descriptif', $entreprise->ID); ?></p>
                    <p><?php the_field('adresse', $entreprise->ID); ?></p>
                    <p><?php the_field('telephone', $entreprise->ID); ?></p>
                    <p><?php the_field('site_internet', $entreprise->ID); ?></p>
                    <p><?php the_field('mail', $entreprise->ID); ?></p>
                    
                <?php endif; 
            ?>
        <?php
		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php

get_footer();
