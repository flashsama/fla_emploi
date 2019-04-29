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
        $managerID = get_field('manager_dentreprise');
        if(is_user_logged_in() && $user_ID == $managerID){
            echo 'you can edit';
            ?>
            <a href="#" id="#fla_edit_entreprise_btn" >Modifier entreprise</a>
            <?php 
        }else {
            echo 'you can not edit';
        }
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
        <div class="fla_edit_entreprise_container" style="display:none;">
            <h2 style="text-align:center;">Modifier Entreprise</h2>
            <form>
                <div>
                    <label for="title">Nomination</label>
                    <input type="text" name="title" id="fla_title_txt" value="<?php the_title(); ?>">
                </div>
                <div>
                    <label for="descriptif">Descriptif</label>
                    <textarea name="descriptif" id="fla_descriptif_txt" rows="5"><?php the_field('descriptif') ?></textarea>
                </div>
                <div>
                    <label for="adresse">Adresse</label>
                    <input type="text" name="adresse" id="fla_adresse_txt" value="<?php the_field('adresse'); ?>">
                </div>
                <div>
                    <label for="Secteur">Secteur d'activités</label>
                    <select id="fla_secteur" class="" name="secteur_d_activites" data-ui="0" data-ajax="0" data-multiple="0" data-placeholder="Choisir" data-allow_null="0">
                        <option value="Informatique, SSII, Internet" <?php if( get_field('secteur_dactivites') == "Informatique, SSII, Internet" ): ?> selected="selected"<?php endif; ?>>Informatique, SSII, Internet</option>
                        <option value="Industrie, production, fabrication, autres" <?php if( get_field('secteur_dactivites') == "Industrie, production, fabrication, autres" ): ?> selected="selected"<?php endif; ?>>Industrie, production, fabrication, autres</option>
                        <option value="Banque, assurance, finances" <?php if( get_field('secteur_dactivites') == "Banque, assurance, finances" ): ?> selected="selected"<?php endif; ?>>Banque, assurance, finances</option>
                        <option value="Centres d´appel, hotline, call center" <?php if( get_field('secteur_dactivites') == "Centres d´appel, hotline, call center" ): ?> selected="selected"<?php endif; ?>>Centres d´appel, hotline, call center</option>
                        <option value="Ingénierie, études développement" <?php if( get_field('secteur_dactivites') == "Ingénierie, études développement" ): ?> selected="selected"<?php endif; ?>>Ingénierie, études développement</option>
                        <option value="Marketing, communication, médias" <?php if( get_field('secteur_dactivites') == "Marketing, communication, médias" ): ?> selected="selected"<?php endif; ?>>Marketing, communication, médias</option>
                        <option value="Distribution, vente, commerce de gros" <?php if( get_field('secteur_dactivites') == "Distribution, vente, commerce de gros" ): ?> selected="selected"<?php endif; ?>>Distribution, vente, commerce de gros</option>                   
                        <option value="Services autres" <?php if( get_field('secteur_dactivites') == "Services autres" ): ?> selected="selected"<?php endif; ?>>Services autres</option>
                        <option value="Hôtellerie, restauration" <?php if( get_field('secteur_dactivites') == "Hôtellerie, restauration" ): ?> selected="selected"<?php endif; ?>>Hôtellerie, restauration</option>
                        <option value="Automobile, matériels de transport, réparation" <?php if( get_field('secteur_dactivites') == "Automobile, matériels de transport, réparation" ): ?> selected="selected"<?php endif; ?>>Automobile, matériels de transport, réparation</option>
                    </select>
                </div>
                <div>
                    <label for="telephone">telephone</label>
                    <input type="text" name="telephone" id="fla_telephone_txt" value="<?php the_field('telephone'); ?>">
                </div>
                <div>
                    <label for="email">Email</label>
                    <input type="text" name="email" id="fla_email_txt" value="<?php the_field('mail'); ?>">
                </div>
                <div>
                    <label for="site web">site web</label>
                    <input type="text" name="site web" id="fla_site web_txt" value="<?php the_field('site_internet'); ?>">
                </div>
                <div>
                    <label for="longitude">longitude</label>
                    <input type="text" name="longitude" id="fla_longitude_txt" value="<?php the_field('longitude'); ?>">
                </div>
                <div>
                    <label for="latitude">latitude</label>
                    <input type="text" name="latitude" id="fla_latitude_txt" value="<?php the_field('latitude'); ?>">
                </div>
            </form>
            <a class="btn" href="#" id="fla_emploi_update_data_entreprise_btn" style="left: calc(100% - 135px);position: relative;">Enregistrer</a>
        </div>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php

get_footer();
