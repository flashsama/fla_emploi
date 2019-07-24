<?php
/**
 * The template for import.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Flash emploi
 */




if(!is_user_logged_in() || $user_ID != 1){
wp_redirect( '/');
exit();
}
die('hard');
 //header('Content-Type: text/html; charset=ISO-8859-1');
$d = get_option( 'entreprises_ids');
var_dump($d);
//$o = get_option( 'offres_ids');
// var_dump(count($o));



$con = mysqli_connect("localhost","root","","perigorddev");

// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }else {
      echo "connected";
  }


  /* 
  Nomination
Descriptif
Adresse
Secteur d'activités
telephone
Email
site web

  */
  //sql qquery to select all entreprises
  //$sql = 'SELECT id_a,nom_a,presentation_a,adresse_a,ville_a,cp_a,tel_a,logo_a,email_a,site_a FROM resonne.agence';

  //sql query to select all job offers
  $sql = 'SELECT id_o,ide_o,intitule_o,descriptif_o,profil_o,contact_o,fichepdf_o,typec_o,fonction_o,localisation_o FROM resonne.offre';
  //sql query to select all job sollicitations (demande)
  //$sql = 'SELECT id_d,ide_d,intitule_d,message_d,cv_d,motivation_d FROM resonne.demande WHERE type_d = 1';
  //$sql = 'SELECT * FROM perigorddev.agence';
  //$sql = 'SELECT *, (SELECT GROUP_CONCAT(nom_bp) FROM perigorddev.bien_photo WHERE perigorddev.bien.id_b = perigorddev.bien_photo.idb_bp) as photos FROM perigorddev.bien';
//   $offresimmo_imgs_sql = 'SELECT * FROM perigorddev.bien_photo';



  //$sql = 'SELECT intitule_o FROM resonne.offre';

  //$offresImmo = $con->query($sql);

  // while ($o = $offresImmo->fetch_assoc()) {
  //   var_dump($o);
  // }
  // die('hard');
//   $offresimgs = $con->query($offresimmo_imgs_sql);



  //$offresOldIDsVsNew = array();

  //$sollicitationsOldIDVsNew = array();

  //$sollicitations = $con->query($sql);

// $entreprises_logos_folder = 'C:/wamp64/www/emploi/wp-content/uploads/entreprise/';
$fiche_pdfs_folder = 'C:/wamp64/www/emploi/wp-content/uploads/fichier/ficheoffre/';
// $sollic_cv_folder = 'C:/wamp64/www/emploi/wp-content/uploads/fichier/cv/';
// $sollic_lm_folder = 'C:/wamp64/www/emploi/wp-content/uploads/fichier/lettre/';
//$agence_immo_img_folder = 'C:/wamp64/www/emploi/wp-content/uploads/img/bien/';



get_header();
?>
 <h2>Importation commencé...</h2>
 <div class="preloader-wrapper active">
    <div class="spinner-layer spinner-red-only">
        <div class="circle-clipper left">
            <div class="circle"></div>
        </div>
        <div class="gap-patch">
            <div class="circle"></div>
        </div>
        <div class="circle-clipper right">
            <div class="circle"></div>
        </div>
    </div>
</div>
<ul class="collection">
<?php

/* import agence immo */

// $agences = $con->query($sql);

// var_dump($agences);
// die('hard');


// if ($agences->num_rows > 0) {
//     $agence_ids = array();
//     while ($agence = $agences->fetch_assoc()) {
//         var_dump($agence);
//         $logo_agence    = 0;
//         $vitrine_agence = 0;
//         //upload logo
        
//         if ($agence['logo_a'] != '') {
//             $logo = $agence_immo_img_folder.$agence['logo_a'];
//             echo $logo;
//             break;
//             $logoname = basename($logo);
//             $parent_post_id = 0;
//             $upload_logo = wp_upload_bits($logoname, null, file_get_contents($logo));
//             if (!$upload_logo['error']) {
//                 $wp_logotype = wp_check_filetype($logoname, null );
//                 $attachment = array(
//                     'post_mime_type' => $wp_logotype['type'],
//                     'post_parent' => $parent_post_id,
//                     'post_title' => preg_replace('/\.[^.]+$/', '', $logoname),
//                     'post_content' => '',
//                     'post_status' => 'inherit'
//                 );
//                 $logo_agence = wp_insert_attachment( $attachment, $upload_logo['file'], $parent_post_id );
//                 if (!is_wp_error($logo_agence)) {
                    
//                 }//endif
//             }//endif
//         }//end if
//         //upload vitrine
        
//         if ($agence['vitrine_a'] != '') {
//             $vitrine = $agence_immo_img_folder.$agence['vitrine_a'];
//             echo $vitrine;
//             break;
//             $vitrinename = basename($vitrine);
//             $parent_post_id = 0;
//             $upload_vitrine = wp_upload_bits($vitrinename, null, file_get_contents($vitrine));
//             if (!$upload_vitrine['error']) {
//                 $wp_vitrinetype = wp_check_filetype($vitrinename, null );
//                 $attachment = array(
//                     'post_mime_type' => $wp_vitrinetype['type'],
//                     'post_parent' => $parent_post_id,
//                     'post_title' => preg_replace('/\.[^.]+$/', '', $vitrinename),
//                     'post_content' => '',
//                     'post_status' => 'inherit'
//                 );
//                 $vitrine_agence = wp_insert_attachment( $attachment, $upload_vitrine['file'], $parent_post_id );
//                 if (!is_wp_error($vitrine_agence)) {
                    
//                 }//endif
//             }//endif
//         }//end if
//         $agence_title      = $agence['nomagence_a'];
//         $agence_fields_arr = array(
// 			'responsable'     => mb_convert_encoding($agence['responsable_a'], 'UTF-8', 'Windows-1252'),
// 			'presentation'    => mb_convert_encoding($agence['presentation_a'], 'UTF-8', 'Windows-1252'),
// 			'email'           => $agence['email_a'],
// 			'tel'             => $agence['tel_a'],
// 			'site'            => $agence['site_a'],
// 			'adresse'         => mb_convert_encoding($agence['adresse_a'], 'UTF-8', 'Windows-1252'),
// 			'ville'           => mb_convert_encoding($agence['ville_a'], 'UTF-8', 'Windows-1252'),
// 			'code_postal'     => $agence['cp_a'],
// 			'logo'            => $logo_agence,
//             'vitrine'         => $vitrine_agence,
//             'manager_dagence' => 4,
// 		);
        
//         $newAgence = array(
//             'post_title'     => $agence_title,
//             'post_type'      => 'fla_immo_agencies',
//             'post_status'    => 'publish',
//             'comment_status' => 'closed',
//             'ping_status'    => 'closed'
//         );

//         $agence_added = wp_insert_post( $newAgence, true );


//         //if post title not added halt and throw error
//         if (is_wp_error($agence_added)) {
            
            
//             $errors = $agence_added->get_error_messages();
//             foreach ($errors as $error) {
//                 echo  " ".$error;
//             }
            
//         }else {
//             //if post added then update extra fields (acf)
//             $agence_ids[$agence['id_a']] = $agence_added;
            
//             foreach ($agence_fields_arr as $field_name => $field_value) {
//                 $field_updated = update_field($field_name, $field_value, $agence_added);
//                 //if a field not updated throw error
//                 if (!$field_updated) {
//                     echo  'can\'t update ' .$field_name.' ';
//                 }
//             }
//         }//end else
        

        
//     }//end while
//     add_option('agence_ids',$agence_ids);
// }//end if

/* import offre immo */

// $agences_ids = get_option( 'agence_ids' );
// var_dump($agences_ids);

// if ($offresImmo->num_rows > 0) {
//     while ($offreImmo = $offresImmo->fetch_assoc()) {
//         var_dump($offreImmo);
//         $photos_array = explode(',', $offreImmo['photos']);
//         $photos_bien = array();

//         foreach ($photos_array as $photo_name ) {
//           //upload photo
//           $photo = $agence_immo_img_folder.$offreImmo['id_b'].'/g/'.$photo_name;
//           if (!file_exists($photo)) {
//             continue;
//           }
//           $photoname = basename($photo);
//           $parent_post_id = 0;
//           $upload_photo = wp_upload_bits($photoname, null, file_get_contents($photo));
//           if (!$upload_photo['error']) {
//               $wp_phototype = wp_check_filetype($photoname, null );
//               $attachment = array(
//                   'post_mime_type' => $wp_phototype['type'],
//                   'post_parent' => $parent_post_id,
//                   'post_title' => preg_replace('/\.[^.]+$/', '', $photoname),
//                   'post_content' => '',
//                   'post_status' => 'inherit'
//               );
//               $photos_bien[] = wp_insert_attachment( $attachment, $upload_photo['file'], $parent_post_id );
//               if (!is_wp_error($photo_bien)) {
                  
//               }//endif
//           }//endif
//         }//end foreach
//         $photo_bien  = ($photos_bien[0])?$photos_bien[0]:0;
//         $photos_bien = implode(',',$photos_bien);
        
//         var_dump($photo_bien);
//         var_dump($photos_bien);

//       $annonce_fields_arr = array(
//         'type_de_transaction'  => (int)$offreImmo['transaction_b'],
//         'type_doffre'          => (int)$offreImmo['type_b'],
//         'description'          => mb_convert_encoding($offreImmo['texte_b'], 'UTF-8','Windows-1252'),
//         'surface'              => (int)$offreImmo['surface_b'],
//         'surface_2'            => (int)$offreImmo['surface2_b'],
//         'secteur'              => (int)$offreImmo['secteur_b'],
//         'prix'                 => $offreImmo['prix_b'],
//         'unite'                => mb_convert_encoding($offreImmo['prixinti_b'], 'UTF-8','Windows-1252'),
//         'commission_incluse'   => (int)$offreImmo['com_b'],
//         'numero_de_mandat'     => mb_convert_encoding($offreImmo['nomandat_b'], 'UTF-8','Windows-1252'),
//         'reference_interne'    => mb_convert_encoding($offreImmo['refinterne_b'], 'UTF-8','Windows-1252'),
//         'agence'               => $agences_ids[$offreImmo['agenceid_b']],
//         'gallerie'             => $photo_bien
// 		  );

// 		//create new post
// 		$newAnnonce = array(
// 			'post_title'     => $offreImmo['id_b'],
// 			'post_type'      => 'fla_immo_offers',
// 			'post_status'    => 'publish',
// 			'comment_status' => 'closed',
// 			'ping_status'    => 'closed'
//     );
    
//     $annonce_added = wp_insert_post( $newAnnonce, true );
// 		//if post title not added halt and throw error
// 		if (is_wp_error($annonce_added)) {
			
// 			echo 'error';
// 			$errors = $annonce_added->get_error_messages();
// 			foreach ($errors as $error) {
// 			  echo " ".$error;
// 			}

//     }else {
//       //if post added then update extra fields (acf)
			
// 			foreach ($annonce_fields_arr as $field_name => $field_value) {
// 				$field_updated = update_field($field_name, $field_value, $annonce_added);
// 				//if a field not updated throw error
// 				if (!$field_updated) {
// 					echo 'can\'t update ' .$field_name.' # ';
// 				}
//       }
      
//       update_post_meta(
// 				$annonce_added,
// 				'fla_immo_offer_gallery',
// 				$photos_bien
// 			);
//     }
//   }
// }



// ******* CODE TO IMPORT SOLLICITATION ************
// var_dump($sollicitations->num_rows);

// if($sollicitations->num_rows > 0) {
//     while ($sollicitation = $sollicitations->fetch_assoc()) {
//         var_dump($sollicitation);
//         //fiche pdf
//         $sollic_cv = 0;
//         $sollic_lm = 0;
        
//             //upload cv pdf
//             $cv = $sollic_cv_folder.$sollicitation['cv_d'];
//             $cvname = basename($cv);
//             $parent_post_id = 0;
//             $upload_cv = wp_upload_bits($cvname, null, file_get_contents($cv));
//             if (!$upload_cv['error']) {
//                 $wp_cvtype = wp_check_filetype($cvname, null );
//                 $attachment = array(
//                     'post_mime_type' => $wp_cvtype['type'],
//                     'post_parent' => $parent_post_id,
//                     'post_title' => preg_replace('/\.[^.]+$/', '', $cvname),
//                     'post_content' => '',
//                     'post_status' => 'inherit'
//                 );
//                 $sollic_cv = wp_insert_attachment( $attachment, $upload_cv['file'], $parent_post_id );
//                 if (!is_wp_error($sollic_cv)) {
                    
//                 }//endif
//             }//endif

//             //upload lm pdf
//             $lm = $sollic_lm_folder.$sollicitation['motivation_d'];
//             $lmname = basename($lm);
//             $parent_post_id = 0;
//             $upload_lm = wp_upload_bits($lmname, null, file_get_contents($lm));
//             if (!$upload_lm['error']) {
//                 $wp_lmtype = wp_check_filetype($lmname, null );
//                 $attachment = array(
//                     'post_mime_type' => $wp_lmtype['type'],
//                     'post_parent' => $parent_post_id,
//                     'post_title' => preg_replace('/\.[^.]+$/', '', $lmname),
//                     'post_content' => '',
//                     'post_status' => 'inherit'
//                 );
//                 $sollic_lm = wp_insert_attachment( $attachment, $upload_lm['file'], $parent_post_id );
//                 if (!is_wp_error($sollic_lm)) {
                    
//                 }//endif
//             }//endif
//             //intitule_d message_d
//             $sollicitation_fields_arr = array(
//                 'message'           => mb_convert_encoding($sollicitation['message_d'], 'UTF-8', 'Windows-1252'),
//                 'cv'                => $sollic_cv,
//                 'lettre_motivation' => $sollic_lm,
//                 'conjoint'          => 0,
//                 'entreprise'        => $d[$sollicitation['ide_d']]
//             );
    
    
//             //update the post title
//             $sollicitationTitle = mb_convert_encoding($sollicitation['intitule_d'], 'UTF-8', 'Windows-1252');
//             $newSollicitation = array(
//                 'post_title'     => $sollicitationTitle,
//                 'post_type'      => 'fla_sollicitation',
//                 'post_status'    => 'publish',
//                 'comment_status' => 'closed',
//                 'ping_status'    => 'closed'
//             );
    
            
    
//             $sollicitation_added = wp_insert_post( $newSollicitation, true );
//             //if post title not added halt and throw error
//             if (is_wp_error($sollicitation_added)) {
                
                
//                 $errors = $sollicitation_added->get_error_messages();
//                 foreach ($errors as $error) {
//                     echo  " ".$error;
//                 }
                
//             }else {
//                 //if post added then update extra fields (acf)
//                 $sollicitationsOldIDVsNew[$sollicitation['id_d']] = $sollicitation_added;
                
//                 foreach ($sollicitation_fields_arr as $field_name => $field_value) {
//                     $field_updated = update_field($field_name, $field_value, $sollicitation_added);
//                     //if a field not updated throw error
//                     if (!$field_updated) {
//                         echo  'can\'t update ' .$field_name.' ';
//                     }
//                 }
//             }
//         die();
//     }//end while
//     var_dump($sollicitationsOldIDVsNew);
//     add_option('sollicitation_ids',$sollicitationsOldIDVsNew);
// }//end if


/*  update offres d'emplois */

// $sql = 'SELECT id_o,typec_o,fonction_o,localisation_o FROM resonne.offre';
// $offres = $con->query($sql);
// var_dump($offres);

// if ($offres->num_rows > 0) {
//     while ($offre = $offres->fetch_assoc()) {
        

//         $emploiID = get_post((int)$o[$offre['id_o']]);
//         var_dump($emploiID);


//         $emploi_fieldss_arr = array(
// 			'type_de_contrat'   => $offre['typec_o'],
// 			'fonction'          => $offre['fonction_o'],
// 			'localisation'      => $offre['localisation_o'],
// 		);
//             foreach ($emploi_fieldss_arr as $field_name => $field_value) {
// 				$field_updated = update_field($field_name, $field_value, $emploiID);
// 				//if a field not updated throw error
// 				if (!$field_updated) {
//                     echo 'can\'t update ' .$field_name.' ';
//                     var_dump($field_updated);
// 				}
// 			}
        // $pl = update_field('localisation', $offre['localisation_o'], (int)$emploiID);
        // echo $pl;
        // $pl = update_field('type_de_contrat', $offre['typec_o'], (int)$emploiID);
        // echo $pl;
        // $pl = update_field('fonction', $offre['fonction_o'], (int)$emploiID);
        // echo $pl;
//     }
// }


// ******* code to import offres d'emploi **********
$offres = $con->query($sql);

var_dump($offres->num_rows);

if($offres->num_rows > 0) {
    while ($offre = $offres->fetch_assoc()) {
        var_dump($offre['intitule_o']);
        //array("UTF-8", "ASCII", "Windows-1252", "ISO-8859-15", "ISO-8859-1", "ISO-8859-6", "CP1256"); 
        var_dump(mb_convert_encoding($offre['intitule_o'],'UTF-8','Windows-1252'));
        //die();
//         ?>
             <li class="collection-item">importation de <?php echo $offre['intitule_o'] ?>...</li>
        <?php
        //fiche pdf
        $fiche_de_post = 0;
        if($offre['fichepdf_o'] != ''){
            //upload pdf
            $file = $fiche_pdfs_folder.$offre['fichepdf_o'];
            $filename = basename($file);
            $parent_post_id = 0;
            $upload_file = wp_upload_bits($filename, null, file_get_contents($file));
            if (!$upload_file['error']) {
                $wp_filetype = wp_check_filetype($filename, null );
                $attachment = array(
                    'post_mime_type' => $wp_filetype['type'],
                    'post_parent' => $parent_post_id,
                    'post_title' => preg_replace('/\.[^.]+$/', '', $filename),
                    'post_content' => '',
                    'post_status' => 'inherit'
                );
                $fiche_de_post = wp_insert_attachment( $attachment, $upload_file['file'], $parent_post_id );
                if (!is_wp_error($fiche_de_post)) {
                    
                }//endif
            }//endif
        }//endif
        
        $descriptif = mb_convert_encoding($offre['descriptif_o'],'UTF-8','Windows-1252');
        $profil = mb_convert_encoding($offre['profil_o'],'UTF-8','Windows-1252');
        $contactrh = mb_convert_encoding($offre['contact_o'],'UTF-8','Windows-1252');

        echo ($descriptif);
        echo '<br>'.$profil;
       
        $emploi_fieldss_arr = array(
			'descriptif'        => $descriptif,
			'profil_recherche'  => $profil,
            'fiche_de_poste'    => $fiche_de_post,
            'type_de_contrat'   => $offre['typec_o'],
 			'fonction'          => $offre['fonction_o'],
 			'localisation'      => $offre['localisation_o'],
			'contact_rh'        => $offre['contact_o'],
			'entreprise'        => $d[$offre['ide_o']]
		);

//id_o,ide_o,intitule_o,descriptif_o,profil_o,contact_o,fichepdf_o,fonction_o,localisation_o
		//update the post title
		$newEmploi = array(
			'post_title'     => mb_convert_encoding($offre['intitule_o'],'UTF-8','Windows-1252'),
			'post_type'      => 'fla_emploi',
			'post_status'    => 'publish',
			'comment_status' => 'closed',
			'ping_status'    => 'closed'
		);

		

		$emploi_added = wp_insert_post( $newEmploi, true );
		//if post title not added halt and throw error
		if (is_wp_error($emploi_added)) {
			
			
			$errors = $emploi_added->get_error_messages();
			foreach ($errors as $error) {
				echo "######".$error;
			}
			
		}else {
            echo 'post addeed';
			//if post added then update extra fields (acf)
			$offresOldIDsVsNew[$offre['id_o']] = $emploi_added;
			foreach ($emploi_fieldss_arr as $field_name => $field_value) {
				$field_updated = update_field($field_name, $field_value, $emploi_added);
				//if a field not updated throw error
				if (!$field_updated) {
					echo 'can\'t update ' .$field_name.' ';
				}
			}
        }
        //die();
    }//endwhile
    
    var_dump($offresOldIDsVsNew);
    update_option('offres_ids',$offresOldIDsVsNew);

}






// *******code to import entreprises**********

// $entreprises = $con->query($sql);

// $entreprisesOldIDsVsNewIDs = array();
// var_dump($entreprisesOldIDsVsNewIDs);
//   if ($entreprises->num_rows > 0) {
//     // output data of each row
//     while($row = $entreprises->fetch_assoc()) {
//         echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
//         ?>
<!-- //             <li class="collection-item">importation de <?php //echo $row['nom_a'] ?>...</li> -->
          <?php
//         $file = $entreprises_logos_folder.$row['logo_a'];
//         $filename = basename($file);
//         $parent_post_id = 0;
//         $attachment_id  = 0;
//         $upload_file = wp_upload_bits($filename, null, file_get_contents($file));
//         if (!$upload_file['error']) {
//         	$wp_filetype = wp_check_filetype($filename, null );
//         	$attachment = array(
//         		'post_mime_type' => $wp_filetype['type'],
//         		'post_parent' => $parent_post_id,
//         		'post_title' => preg_replace('/\.[^.]+$/', '', $filename),
//         		'post_content' => '',
//         		'post_status' => 'inherit'
//         	);
//         	$attachment_id = wp_insert_attachment( $attachment, $upload_file['file'], $parent_post_id );
//         	if (!is_wp_error($attachment_id)) {
//         		require_once(ABSPATH . "wp-admin" . '/includes/image.php');
//         		$attachment_data = wp_generate_attachment_metadata( $attachment_id, $upload_file['file'] );
//         		wp_update_attachment_metadata( $attachment_id,  $attachment_data );
//         	}
//         }


//         //id_a,nom_a,presentation_a,adresse_a,ville_a,cp_a,tel_a,logo_a,email_a

//         $entrepriseTitle = $row['nom_a'];

//         $entreprise_fields_arr = array(
// 			'descriptif'         => $row['presentation_a'],
// 			'adresse'            => $row['adresse_a'].' '.$row['ville_a'].' '.$row['cp_a'],
// 			'mail'               => $row['email_a'],
// 			'telephone'          => $row['tel_a'],
// 			'site_internet'      => $row['site_a'],
// 			'logo'               => $attachment_id

// 		);

//         $newEntreprise = array(
// 			'post_title'     => $entrepriseTitle,
// 			'post_type'      => 'fla_entreprise',
// 			'post_status'    => 'publish',
// 			'comment_status' => 'closed',
// 			'ping_status'    => 'closed'
//         );
        
        

//         $entreprise_added = wp_insert_post( $newEntreprise, true );
// 		//if post title not added halt and throw error
// 		if (is_wp_error($entreprise_added)) {
			
// 			$errors = $entreprise_added->get_error_messages();
// 			foreach ($errors as $error) {
// 				echo $error;
// 			}
			
// 		}else {
//             $entreprisesOldIDsVsNewIDs[$row['id_a']] = $entreprise_added;
//             var_dump($entreprisesOldIDsVsNewIDs);
// 			//if post added then update extra fields (acf)
			
// 			foreach ($entreprise_fields_arr as $field_name => $field_value) {
// 				$field_updated = update_field($field_name, $field_value, $entreprise_added);
// 				//if a field not updated throw error
// 				if (!$field_updated) {
// 					echo 'can\'t update ' .$field_name.' ';
// 				}
// 			}
//         }
        

//     }//end while
//     var_dump($entreprisesOldIDsVsNewIDs);
//     add_option( 'entreprises_ids', $entreprisesOldIDsVsNewIDs );
// } else {
//     echo "0 results";
// }

?>
</ul>