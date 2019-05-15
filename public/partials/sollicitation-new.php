<?php
/**
 * The template for adding a new sollicitation
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
        <h1>Ajouter une nouvelle sollicitation</h1>
        <div class="row">
        <form>
                <div class="row">
                    <div class="input-field col s12">
                        <input value="" id="sollicitation_title" type="text" class="validate">
                        <input type="hidden" value="" id="sollicitation_id">
                        <label for="sollicitation_title">Intitulé</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <h3 class="left">Conjoint</h3>
                        <div class="switch left" style="clear:both;">
                            <label>
                            Non
                            <input type="checkbox" id="sollicitation_conjoint">
                            <span class="lever"></span>
                            Oui
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="input-field col s12">
                        <select id="sollicitation_fonction" name="sollicitation_fonction">
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
                        <label for="sollicitation_fonction">Fonction</label>
                    </div>
                </div>
                
                <div class="row">
                    <div class="input-field col s12">
                        <textarea id="sollicitation_message" type="text" class="materialize-textarea"></textarea>
                        <label for="sollicitation_message">Message</label>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12">
                        <input disabled value="cv" id="sollicitation_cv" type="text" class="validate">
                        <input type="hidden" name="" id="cv_id" value="">
                        <a class="waves-effect waves-light btn-small left" id="upload_cv_btn"><i class="material-icons right">edit</i>Modifier</a>
                        <label for="sollicitation_cv">CV</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input disabled value="lettre de motivation" id="sollicitation_lettre_motivation" type="text" class="validate">
                        <input type="hidden" name="" id="lm_id" value="">
                        <a class="waves-effect waves-light btn-small left" id="upload_lm_btn"><i class="material-icons right">edit</i>Modifier</a>
                        <label for="sollicitation_lettre_motivation">lettre motivation</label>
                    </div>
                </div>
                
                <div class="row">
                    <div id="sollicitation_entreprise_wrapper" class="input-field col s12">
                        <select id="sollicitation_entreprise" class="validate">
                            <option value="0">Séléctionner une entreprise</option>
                            <?php
                                foreach ($entreprises as $entreprise) {
                                    ?>
                                        <option value="<?php echo $entreprise->ID ?>"><?php echo $entreprise->post_title ?></option>
                                    <?php
                                }
                            ?>
                        </select>
                        <label for="sollicitation_entreprise">Entreprise</label>
                    </div>
                </div>
                <div class="red-text card-panel" id="error_new_sollicitation" style="display:none;">
                    une erreur est survenu lors de l'enregistrement de vos données! veuillez resayer plus tard
                </div>
                <div class="progress" style="display:none;">
                    <div class="indeterminate"></div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <a href="#" id="add_new_sollicitation_btn" class="btn">Enregistrer</a>
                    </div>
                </div>

            </form>
        </div>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php

get_footer();