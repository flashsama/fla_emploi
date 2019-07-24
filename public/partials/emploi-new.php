<?php
/**
 * The template for editing single job (emploi).
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Flash emploi
 */



if (!is_user_logged_in()) {
    //redirect to manager admin
    wp_redirect( '/manager-admin' );
    exit;
}

$entreprises = get_posts(array(
	'numberposts'	=> -1,
	'post_type'		=> 'fla_entreprise',
	'meta_key'		=> 'manager_dentreprise',
	'meta_value'	=> $user_ID
));


$field_fonction = get_field_object('field_5cd6fcbaaf352');
$fonction_choices = $field_fonction['choices'];

$field_type_contrat = get_field_object('field_5cb8f9edf7c23');
$type_contrat_choices = $field_type_contrat['choices'];

$field_localisatation = get_field_object('field_5cb8fbe0f8b2a');
$localisatation_choices = $field_localisatation['choices'];

$fla_emploi_tinymce_setting = array(
    'media_buttons' => false,
    'teeny'         => true,
    'quicktags'     => false
);
        
get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
        <h1>Ajouter une nouvelle offre</h1>
        <div class="row">
            <form>
                <div class="row">
                    <div class="input-field col s12">
                        <input value="" id="emploi_title" type="text" class="validate">
                        <label for="emploi_title">Intitulé du poste</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <select id="type_de_contrat" name="type_de_contrat">
                        <?php 
                            foreach ($type_contrat_choices as $value => $label) {
                                ?>
                                <option value="<?php echo $value; ?>"><?php echo $label; ?></option>
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
                                <option value="<?php echo $value; ?>"><?php echo $label; ?></option>
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
                        <option value="<?php echo $value; ?>"><?php echo $label; ?></option>
                        <?php
                    }
                    ?>
                    </select>
                        <label for="emploi_localisation">Localisation</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <?php wp_editor( '', 'emploi_descriptif', $fla_emploi_tinymce_setting ); ?>
                        <label for="emploi_descriptif" class="tiny_editor">Descriptif</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <?php wp_editor( '', 'emploi_profile', $fla_emploi_tinymce_setting ); ?>
                        <label for="emploi_profile" class="tiny_editor">Profile recherché</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input value="" id="emploi_contact_rh" type="text" class="validate">
                        <label for="emploi_contact_rh">Contact RH</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input disabled value="fiche" id="emploi_fiche_de_post" type="text" class="validate">
                        <input type="hidden" name="" id="fiche_de_post_id" value="">
                        <a class="waves-effect waves-light btn-small left" id="upload_fiche_de_post_btn"><i class="material-icons right">add</i>Ajouter</a>
                        <label for="emploi_fiche_de_post">Fiche de post</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input value="" id="emploi_longitude" type="text" class="validate">
                        <label for="emploi_longitude">Longitude</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input value="" id="emploi_latitude" type="text" class="validate">
                        <label for="emploi_latitude">Latitude</label>
                    </div>
                </div>
                <div class="row">
                    <div id="emploi_entreprise_wrapper" class="input-field col s12">
                        <select id="emploi_entreprise" class="validate">
                            <option value="0">Séléctionner une entreprise</option>
                            <?php
                                foreach ($entreprises as $entreprise) {
                                    ?>
                                        <option value="<?php echo $entreprise->ID ?>"><?php echo $entreprise->post_title ?></option>
                                    <?php
                                }
                            ?>
                        </select>
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
                        <a href="#" id="add_new_emploi_btn" class="btn">Enregistrer</a>
                    </div>
                </div>

            </form>
        </div>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php

get_footer();