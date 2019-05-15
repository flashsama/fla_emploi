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
                            <option value="cdi">CDI</option>
                            <option value="cdd">CDD</option>
                            <option value="freelance">Freelance</option>
                        </select>
                        <label for="type_de_contrat">Type de contrat</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <select id="emploi_fonction" name="emploi_fonction">
                            <option value="commercial">Commercial, vente</option>
                            <option value="informatique">Informatique, nouvelles technologies</option>
                            <option value="gestion">Gestion, comptabilité, finance</option>
                            <option value="production">Production, maintenance, qualité</option>
                            <option value="marketing">Marketing, communication</option>
                            <option value="r_et_d">R&D, gestion de projets</option>
                            <option value="rh">RH, formation</option>
                            <option value="secretariat">Secretariat, assistanat</option>
                            <option value="services">Métiers des services</option>
                            <option value="management">Management, direction générale</option>
                        </select>
                        <label for="emploi_fonction">Fonction</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input value="" id="emploi_localisation" type="text" class="validate">
                        <label for="emploi_localisation">Localisation</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <textarea id="emploi_descriptif" type="text" class="materialize-textarea"></textarea>
                        <label for="emploi_descriptif">Descriptif</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <textarea id="emploi_profile" type="text" class="materialize-textarea"></textarea>
                        <label for="emploi_profile">Profile recherché</label>
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