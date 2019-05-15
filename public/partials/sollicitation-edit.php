<?php
/**
 * The template for editing single sollicitation ().
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Flash emploi
 */



$sollicitation_ID = isset($_GET['id'])?$_GET['id']:0;
$entreprise = get_field('entreprise', $sollicitation_ID)[0];
$managerID = get_field('manager_dentreprise', $entreprise->ID);
if (!is_user_logged_in() || $user_ID != $managerID || $sollicitation_ID == 0) {
    //redirect to manager admin
    wp_redirect( '/manager-admin' );
    exit;
}



$fonction        = get_field('fonction', $sollicitation_ID)['value'];
//var_dump($fonction);

    
get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
        <h1>Job ID = <?php echo $sollicitation_ID; ?></h1>
        <div class="row">
            <form>
                <div class="row">
                    <div class="input-field col s12">
                        <input value="<?php echo get_the_title( $sollicitation_ID ) ?>" id="sollicitation_title" type="text" class="validate">
                        <input type="hidden" value="<?php echo $sollicitation_ID; ?>" id="sollicitation_id">
                        <label for="sollicitation_title">Intitulé</label>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12">
                        <h3 class="left">Conjoint</h3>
                        <div class="switch left" style="clear:both;">
                            <label>
                            Non
                            <input type="checkbox" id="sollicitation_conjoint" <?php echo ((int)get_field('conjoint', $sollicitation_ID) == 1)?'checked':''; ?>>
                            <span class="lever"></span>
                            Oui
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="input-field col s12">
                        <select id="sollicitation_fonction" name="sollicitation_fonction">
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
                        <label for="sollicitation_fonction">Fonction</label>
                    </div>
                </div>
                
                <div class="row">
                    <div class="input-field col s12">
                        <textarea id="sollicitation_message" type="text" class="materialize-textarea"><?php the_field('message', $sollicitation_ID); ?></textarea>
                        <label for="sollicitation_message">Message</label>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12">
                        <input disabled value="<?php echo(get_field('cv', $sollicitation_ID)['filename']); ?>" id="sollicitation_cv" type="text" class="validate">
                        <input type="hidden" name="" id="cv_id" value="<?php echo(get_field('cv', $sollicitation_ID)['ID']); ?>">
                        <a class="waves-effect waves-light btn-small left" id="upload_cv_btn"><i class="material-icons right">edit</i>Modifier</a>
                        <label for="sollicitation_cv">CV</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input disabled value="<?php echo(get_field('lettre_motivation', $sollicitation_ID)['filename']); ?>" id="sollicitation_lettre_motivation" type="text" class="validate">
                        <input type="hidden" name="" id="lm_id" value="<?php echo(get_field('lettre_motivation', $sollicitation_ID)['ID']); ?>">
                        <a class="waves-effect waves-light btn-small left" id="upload_lm_btn"><i class="material-icons right">edit</i>Modifier</a>
                        <label for="sollicitation_lettre_motivation">lettre motivation</label>
                    </div>
                </div>
                
                <div class="row">
                    <div class="input-field col s12">
                        <input disabled value="<?php echo get_the_title($entreprise->ID); ?>" id="sollicitation_entreprise" type="text" class="validate">
                        <label for="sollicitation_entreprise">Entreprise</label>
                    </div>
                </div>
                <div class="red-text card-panel" id="error_update_sollicitation" style="display:none;">
                    une erreur est survenu lors de l'enregistrement de vos données! veuillez resayer plus tard
                </div>
                <div class="progress" style="display:none;">
                    <div class="indeterminate"></div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <a href="#" id="update_sollicitation_btn" class="btn">Enregistrer</a>
                    </div>
                </div>

            </form>
        </div>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php

get_footer();