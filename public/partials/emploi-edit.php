<?php
/**
 * The template for editing single job (emploi).
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Flash emploi
 */



$emploi_ID = isset($_GET['eid'])?$_GET['eid']:0;
$entreprise = get_field('entreprise', $emploi_ID)[0];
$managerID = get_field('manager_dentreprise', $entreprise->ID);
if (!is_user_logged_in() || $user_ID != $managerID || $emploi_ID == 0) {
    //redirect to manager admin
    wp_redirect( '/manager-admin' );
    exit;
}

//var_dump(get_field('fiche_de_poste', $emploi_ID));

$type_de_contrat = strtolower(get_field('type_de_contrat', $emploi_ID));
$fonction        = get_field('fonction', $emploi_ID)['value'];
//var_dump($fonction);



        
get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
        <h1>Job ID = <?php echo $emploi_ID; ?></h1>
        <div class="row">
            <form>
                <div class="row">
                    <div class="input-field col s12">
                        <input value="<?php echo get_the_title( $emploi_ID ) ?>" id="emploi_title" type="text" class="validate">
                        <input type="hidden" value="<?php echo $emploi_ID; ?>" id="emploi_id">
                        <label for="emploi_title">Intitulé du poste</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <select id="type_de_contrat" name="type_de_contrat">
                            <option value="cdi" <?php if( $type_de_contrat == "cdi" ): ?> selected="selected"<?php endif; ?>>CDI</option>
                            <option value="cdd" <?php if( $type_de_contrat == "cdd" ): ?> selected="selected"<?php endif; ?>>CDD</option>
                            <option value="freelance" <?php if( $type_de_contrat == "freelance" ): ?> selected="selected"<?php endif; ?>>Freelance</option>
                        </select>
                        <label for="type_de_contrat">Type de contrat</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <select id="emploi_fonction" name="emploi_fonction">
                            <option value="commercial" <?php if( $fonction == "commercial" ): ?> selected="selected"<?php endif; ?>>Commercial, vente</option>
                            <option value="informatique" <?php if( $fonction == "informatique" ): ?> selected="selected"<?php endif; ?>>Informatique, nouvelles technologies</option>
                            <option value="gestion" <?php if( $fonction == "gestion" ): ?> selected="selected"<?php endif; ?>>Gestion, comptabilité, finance</option>
                            <option value="production" <?php if( $fonction == "production" ): ?> selected="selected"<?php endif; ?>>Production, maintenance, qualité</option>
                            <option value="marketing" <?php if( $fonction == "marketing" ): ?> selected="selected"<?php endif; ?>>Marketing, communication</option>
                            <option value="r_et_d" <?php if( $fonction == "r_et_d" ): ?> selected="selected"<?php endif; ?>>R&D, gestion de projets</option>
                            <option value="rh" <?php if( $fonction == "rh" ): ?> selected="selected"<?php endif; ?>>RH, formation</option>
                            <option value="secretariat" <?php if( $fonction == "secretariat" ): ?> selected="selected"<?php endif; ?>>Secretariat, assistanat</option>
                            <option value="services" <?php if( $fonction == "services" ): ?> selected="selected"<?php endif; ?>>Métiers des services</option>
                            <option value="management" <?php if( $fonction == "management" ): ?> selected="selected"<?php endif; ?>>Management, direction générale</option>
                        </select>
                        <label for="emploi_fonction">Fonction</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input value="<?php the_field('localisation', $emploi_ID); ?>" id="emploi_localisation" type="text" class="validate">
                        <label for="emploi_localisation">Localisation</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <textarea id="emploi_descriptif" type="text" class="materialize-textarea"><?php the_field('descriptif', $emploi_ID); ?></textarea>
                        <label for="emploi_descriptif">Descriptif</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <textarea id="emploi_profile" type="text" class="materialize-textarea"><?php the_field('profil_recherche', $emploi_ID); ?></textarea>
                        <label for="emploi_profile">Profile recherché</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input value="<?php the_field('contact_rh', $emploi_ID); ?>" id="emploi_contact_rh" type="text" class="validate">
                        <label for="emploi_contact_rh">Contact RH</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input disabled value="<?php echo(get_field('fiche_de_poste', $emploi_ID)['filename']); ?>" id="emploi_fiche_de_post" type="text" class="validate">
                        <input type="hidden" name="" id="fiche_de_post_id" value="<?php echo(get_field('fiche_de_poste', $emploi_ID)['ID']); ?>">
                        <a class="waves-effect waves-light btn-small left" id="upload_fiche_de_post_btn"><i class="material-icons right">edit</i>Modifier</a>
                        <label for="emploi_fiche_de_post">Fiche de post</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input value="<?php the_field('longitude', $emploi_ID); ?>" id="emploi_longitude" type="text" class="validate">
                        <label for="emploi_longitude">Longitude</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input value="<?php the_field('latitude', $emploi_ID); ?>" id="emploi_latitude" type="text" class="validate">
                        <label for="emploi_latitude">Latitude</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input disabled value="<?php echo get_the_title($entreprise->ID); ?>" id="emploi_entreprise" type="text" class="validate">
                        <label for="emploi_entreprise">Entreprise</label>
                    </div>
                </div>
                <div class="red-text card-panel" id="error_update_emploi" style="display:none;">
                    une erreur est survenu lors de l'enregistrement de vos données! veuillez resayer plus tard
                </div>
                <div class="progress" style="display:none;">
                    <div class="indeterminate"></div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <a href="#" id="update_emploi_btn" class="btn">Enregistrer</a>
                    </div>
                </div>

            </form>
        </div>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php

get_footer();