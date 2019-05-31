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
            <a href="#" class="btn" id="fla_edit_entreprise_btn" ><i class="material-icons right">edit</i>Modifier entreprise</a>
            

            <?php 
        }else {
            echo 'you can not edit';
        }
        //var_dump(get_fields());
        ?>
            <h3><?php the_title(); ?></h3>
            <?php $entreprise_logo = json_decode(json_encode(get_field('logo')), FALSE); ?>
            <img src="<?php echo $entreprise_logo->url; ?>" />
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
            if($manager){
                echo $manager->data->display_name;
            }
            
            //var_dump($manager);
            ?>
            <h3>Toutes les offres de cette entreprise</h3>
            <?php
                $eid = (int)get_the_ID();
                $emplois = get_posts(array(
                    'numberposts'	=> -1,
                    'post_type'		=> 'fla_emploi',
                    'meta_query' => array(
                        array(
                            'key' => 'entreprise', // name of custom field
                            'value' => $eid,//'"' . get_the_ID() . '"', // matches exactly "123", not just 123. This prevents a match for "1234"
                            'compare' => 'LIKE'
                        )
                    )
                ));
                ?>
                <ul class="collection fla_emploi_ul">
                <?php
                foreach ($emplois as $emploi) {
                   // var_dump($emploi);
                   ?>
                   <li class="collection-item" id="item_<?php echo $emploi->ID; ?>">
                    <a href="<?php the_permalink($emploi->ID); ?>"><?php echo get_the_title($emploi->ID); ?></a>
                    <div class="secondary-content">
                        <a href="<?php echo $emploi->guid; ?>" class="btn-floating btn-small"><i class="material-icons right">remove_red_eye</i></a>
                        <a href="/edit_emploi?eid=<?php echo $emploi->ID; ?>" class="btn-floating btn-small"><i class="material-icons right">edit</i></a>
                        <a href="#" data="<?php echo $emploi->ID; ?>" class="btn-floating btn-small red delete_emploi_btn"><i class="material-icons right">delete</i></a>
                        <a href="#" data="<?php echo $emploi->ID; ?>" class="btn-floating btn-small red archive_emploi_btn"><i class="material-icons right">archive</i></a>
                    </div>
                    </li>
                   <?php
                }
                ?>
                </ul>
                <div class="right">
                Ajouter une offre <a href="/ajouter-emploi" class="btn-floating right" id="" ><i class="material-icons right">add</i></a>
                </div>
                <div style="clear: both;"></div>
                <?php
                //var_dump($emplois);
            ?>
            
            <h3>Toutes les sollicitaion de cette entreprise</h3>
            <?php
                $eid = (int)get_the_ID();
                $sollicitations = get_posts(array(
                    'numberposts'	=> -1,
                    'post_type'		=> 'fla_sollicitation',
                    'meta_query' => array(
                        array(
                            'key' => 'entreprise', // name of custom field
                            'value' => $eid,//'"' . get_the_ID() . '"', // matches exactly "123", not just 123. This prevents a match for "1234"
                            'compare' => 'LIKE'
                        )
                    )
                ));
                
                ?>
                <ul class="collection fla_emploi_ul">
                <?php
                foreach ($sollicitations as $sollicitation) {
                   // var_dump($sollicitation);
                   ?>
                   <li class="collection-item" id="item_<?php echo $sollicitation->ID; ?>">
                    <a href="<?php the_permalink($sollicitation->ID); ?>"><?php echo get_the_title($sollicitation->ID); ?></a>
                    <div class="secondary-content">
                        <a href="<?php echo $sollicitation->guid; ?>" class="btn-floating btn-small"><i class="material-icons right">remove_red_eye</i></a>
                        <a href="/edit_sollicitation?id=<?php echo $sollicitation->ID; ?>" class="btn-floating btn-small"><i class="material-icons right">edit</i></a>
                        <a href="#" data="<?php echo $sollicitation->ID; ?>" class="btn-floating btn-small red delete_sollicitation_btn"><i class="material-icons right">delete</i></a>
                        <a href="#" data="<?php echo $sollicitation->ID; ?>" class="btn-floating btn-small red archive_sollicitation_btn"><i class="material-icons right">archive</i></a>
                    </div>
                    </li>
                   <?php
                }
                ?>
                </ul>
                <div class="right">
                Ajouter une sollicitation <a href="/ajouter-sollicitation" class="btn-floating right" id="" ><i class="material-icons right">add</i></a>
                </div>
                <div style="clear: both;"></div>

        <?php
		endwhile; // End of the loop.
        ?>
        <!-- modal confirmation -->
        <div id="delete_confirm_modal" class="modal">
            <div class="modal-content">
                <h4>Confirmer la suppression</h4>
                <p>Voulez vous supprimer cette offre ?</p>
                <input type="hidden" id="emploi_id_to_delete" value="0">
                <div class="preloader-wrapper active" style="display:none">
                    <div class="spinner-layer spinner-red-only">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div><div class="gap-patch">
                        <div class="circle"></div>
                    </div><div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                    </div>
                </div>
                <div style="display:none;" class="error_container"><p>une erreur s'est produite, impossible de supprimer l'offre, veuillez ressayer plus tard!</p><a href="#!" class="modal-close waves-effect waves-green btn">Fermer</a></div>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-close waves-effect waves-green btn">Non</a>
                <a href="#!" id="delete_emploi_confirm" class="waves-effect waves-green btn red">Oui</a>
            </div>
        </div>
        <!-- end modal --> 

        <!-- modal confirmation archive-->
        <div id="archive_confirm_modal" class="modal">
            <div class="modal-content">
                <h4>Confirmer l'archivage'</h4>
                <p>Voulez vous archiver cette offre ?</p>
                <input type="hidden" id="emploi_id_to_archive" value="0">
                <div class="preloader-wrapper active" style="display:none">
                    <div class="spinner-layer spinner-red-only">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div><div class="gap-patch">
                        <div class="circle"></div>
                    </div><div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                    </div>
                </div>
                <div style="display:none;" class="error_container"><p>une erreur s'est produite, impossible d'archiver' l'offre. Veuillez ressayer plus tard!</p><a href="#!" class="modal-close waves-effect waves-green btn">Fermer</a></div>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-close waves-effect waves-green btn">Non</a>
                <a href="#!" id="archive_emploi_confirm" class="waves-effect waves-green btn red">Oui</a>
            </div>
        </div>
        <!-- end modal --> 
        <!-- modal confirmation -->
        <div id="delete_sollicitation_confirm_modal" class="modal">
            <div class="modal-content">
                <h4>Confirmer la suppression</h4>
                <p>Voulez vous supprimer cette sollicitation ?</p>
                <input type="hidden" id="sollicitation_id_to_delete" value="0">
                <div class="preloader-wrapper active" style="display:none">
                    <div class="spinner-layer spinner-red-only">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div><div class="gap-patch">
                        <div class="circle"></div>
                    </div><div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                    </div>
                </div>
                <div style="display:none;" class="error_container"><p>une erreur s'est produite, impossible de supprimer la sollicitation, veuillez ressayer plus tard!</p><a href="#!" class="modal-close waves-effect waves-green btn">Fermer</a></div>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-close waves-effect waves-green btn">Non</a>
                <a href="#!" id="delete_sollicitation_confirm" class="waves-effect waves-green btn red">Oui</a>
            </div>
        </div>
        <!-- end modal --> 

        <!-- modal confirmation archive-->
        <div id="archive_sollicitation_confirm_modal" class="modal">
            <div class="modal-content">
                <h4>Confirmer l'archivage'</h4>
                <p>Voulez vous archiver cette offre ?</p>
                <input type="hidden" id="sollicitation_id_to_archive" value="0">
                <div class="preloader-wrapper active" style="display:none">
                    <div class="spinner-layer spinner-red-only">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div><div class="gap-patch">
                        <div class="circle"></div>
                    </div><div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                    </div>
                </div>
                <div style="display:none;" class="error_container"><p>une erreur s'est produite, impossible d'archiver' l'offre. Veuillez ressayer plus tard!</p><a href="#!" class="modal-close waves-effect waves-green btn">Fermer</a></div>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-close waves-effect waves-green btn">Non</a>
                <a href="#!" id="archive_sollicitation_confirm" class="waves-effect waves-green btn red">Oui</a>
            </div>
        </div>
        <!-- end modal --> 
        <div id="entreprise_edit_section" class="fla_edit_entreprise_container" style="display:none;">
            <h2 style="text-align:center;">Modifier Entreprise</h2>
            <form>
                <div class="input-field">
                    <label for="title">Nomination</label>
                    <input type="text" name="title" id="fla_title_txt" value="<?php the_title(); ?>" minlength="1">
                </div>
                
                <div class="">
                    <label>Logo</label>
                    <img id="entreprise_logo_edit" width="100px" src="<?php echo $entreprise_logo->url; ?>" />
                    <input type="hidden" id="entreprise_logo_id" value="<?php echo $entreprise_logo->id; ?>">
                    <a class="btn-floating btn cyan" id="upload_logo_btn"><i class="material-icons">edit</i></a>
                </div>
                <div class="input-field">
                    <label for="descriptif">Descriptif</label>
                    <textarea class="materialize-textarea" name="descriptif" id="fla_descriptif_txt" rows="5" minlength="20"><?php the_field('descriptif') ?></textarea>
                </div>
                <div class="input-field">
                    <label for="adresse">Adresse</label>
                    <input type="text" name="adresse" id="fla_adresse_txt" value="<?php the_field('adresse'); ?>" minlength="6">
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
                <div class="input-field">
                    <label for="telephone">telephone</label>
                    <input type="text" name="telephone" id="fla_telephone_txt" value="<?php the_field('telephone'); ?>" minlength="10">
                </div>
                <div class="input-field">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="fla_email_txt" value="<?php the_field('mail'); ?>" required minlength="5">
                </div>
                <div class="input-field">
                    <label for="site web">site web</label>
                    <input type="text" name="site web" id="fla_site_web_txt" value="<?php the_field('site_internet'); ?>">
                </div>
                <div class="input-field">
                    <label for="longitude">longitude</label>
                    <input type="text" name="longitude" id="fla_longitude_txt" value="<?php the_field('longitude'); ?>" minlength="8" maxlength="8">
                </div>
                <div class="input-field">
                    <label for="latitude">latitude</label>
                    <input type="text" name="latitude" id="fla_latitude_txt" value="<?php the_field('latitude'); ?>" minlength="8" maxlength="8">
                </div>
                <input type="hidden" id="entrepriseID" value="<?php echo get_the_ID(); ?>">
            </form>
            <div class="red-text card-panel" id="error_update_entreprise" style="display:none;">
                une erreur est survenu lors de l'enregistrement de vos données! veuillez resayer plus tard
            </div>
            <div class="progress" style="display:none;">
                <div class="indeterminate"></div>
            </div>
            <a class="btn" href="#" id="fla_emploi_update_data_entreprise_btn" style="left: calc(100% - 135px);position: relative;">Enregistrer</a>
        </div>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php

get_footer();
