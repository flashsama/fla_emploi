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

$type_de_contrat = get_field('type_de_contrat', $emploi_ID)['value'];
$fonction        = get_field('fonction', $emploi_ID)['value'];
$localisation    = get_field('localisation', $emploi_ID)['value'];

$field_fonction = get_field_object('field_5cd6fcbaaf352');
$fonction_choices = $field_fonction['choices'];

$field_type_contrat = get_field_object('field_5cb8f9edf7c23');
$type_contrat_choices = $field_type_contrat['choices'];

$field_localisatation = get_field_object('field_5cb8fbe0f8b2a');
$localisatation_choices = $field_localisatation['choices'];
//var_dump($fonction);



        
get_header(); 

$fla_emploi_tinymce_setting = array(
    'media_buttons' => false,
    'teeny'         => true
);

?>

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
                        <?php 
                            foreach ($type_contrat_choices as $value => $label) {
                                ?>
                                <option value="<?php echo $value; ?>" <?php if( $type_de_contrat == $value ): ?> selected="selected"<?php endif; ?>><?php echo $label; ?></option>
                                <?php
                            }
                        ?>
                        </select>
                        <label for="type_de_contrat">Type de contrat</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <select id="emploi_fonction" name="emploi_fonction">
                        <?php 
                            foreach ($fonction_choices as $value => $label) {
                                ?>
                                <option value="<?php echo $value; ?>" <?php if( $fonction == $value ): ?> selected="selected"<?php endif; ?>><?php echo $label; ?></option>
                                <?php
                            }
                        ?>
                        </select>
                        <label for="emploi_fonction">Fonction</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                    <select id="emploi_localisation" name="emploi_localisation">
                    
                        <?php
                        foreach ($localisatation_choices as $value => $label) {
                            ?>
                            <option value="<?php echo $value; ?>" <?php if( $localisation == $value ): ?> selected="selected"<?php endif; ?>><?php echo $label; ?></option>
                            <?php
                        }
                        ?>
                        </select>
                        <label for="emploi_localisation">Localisation</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <?php wp_editor( get_field('descriptif', $emploi_ID), 'emploi_descriptif', $fla_emploi_tinymce_setting ); ?>
                        <label for="emploi_descriptif">Descriptif</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <?php wp_editor( get_field('profil_recherche', $emploi_ID), 'emploi_profile', $fla_emploi_tinymce_setting ); ?>
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