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

 //header('Content-Type: text/html; charset=ISO-8859-1');
$d = get_option( 'entreprises_ids');
var_dump($d);
$o = get_option( 'offres_ids');
var_dump($o);



$con = mysqli_connect("localhost","root","","resonne");

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
  //$sql = 'SELECT id_o,ide_o,intitule_o,descriptif_o,profil_o,contact_o,fichepdf_o,fonction_o,localisation_o FROM resonne.offre';
  //sql query to select all job sollicitations (demande)
  $sql = 'SELECT id_d,ide_d,intitule_d,message_d,cv_d,motivation_d FROM resonne.demande WHERE type_d = 1';



  //$sql = 'SELECT intitule_o FROM resonne.offre';

  //$offres = $con->query($sql);

  //$offresOldIDsVsNew = array();

  $sollicitationsOldIDVsNew = array();

  $sollicitations = $con->query($sql);

//$entreprises_logos_folder = 'C:/wamp64/www/emploi/wp-content/uploads/entreprise/';
//$fiche_pdfs_folder = 'C:/wamp64/www/emploi/wp-content/uploads/fichier/ficheoffre/';
$sollic_cv_folder = 'C:/wamp64/www/emploi/wp-content/uploads/fichier/cv/';
$sollic_lm_folder = 'C:/wamp64/www/emploi/wp-content/uploads/fichier/lettre/';



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


// ******* CODE TO IMPORT SOLLICITATION ************
var_dump($sollicitations->num_rows);

if($sollicitations->num_rows > 0) {
    while ($sollicitation = $sollicitations->fetch_assoc()) {
        var_dump($sollicitation);
        //fiche pdf
        $sollic_cv = 0;
        $sollic_lm = 0;
        
            //upload cv pdf
            $cv = $sollic_cv_folder.$sollicitation['cv_d'];
            $cvname = basename($cv);
            $parent_post_id = 0;
            $upload_cv = wp_upload_bits($cvname, null, file_get_contents($cv));
            if (!$upload_cv['error']) {
                $wp_cvtype = wp_check_filetype($cvname, null );
                $attachment = array(
                    'post_mime_type' => $wp_cvtype['type'],
                    'post_parent' => $parent_post_id,
                    'post_title' => preg_replace('/\.[^.]+$/', '', $cvname),
                    'post_content' => '',
                    'post_status' => 'inherit'
                );
                $sollic_cv = wp_insert_attachment( $attachment, $upload_cv['file'], $parent_post_id );
                if (!is_wp_error($sollic_cv)) {
                    
                }//endif
            }//endif

            //upload lm pdf
            $lm = $sollic_lm_folder.$sollicitation['motivation_d'];
            $lmname = basename($lm);
            $parent_post_id = 0;
            $upload_lm = wp_upload_bits($lmname, null, file_get_contents($lm));
            if (!$upload_lm['error']) {
                $wp_lmtype = wp_check_filetype($lmname, null );
                $attachment = array(
                    'post_mime_type' => $wp_lmtype['type'],
                    'post_parent' => $parent_post_id,
                    'post_title' => preg_replace('/\.[^.]+$/', '', $lmname),
                    'post_content' => '',
                    'post_status' => 'inherit'
                );
                $sollic_lm = wp_insert_attachment( $attachment, $upload_lm['file'], $parent_post_id );
                if (!is_wp_error($sollic_lm)) {
                    
                }//endif
            }//endif
            //intitule_d message_d
            $sollicitation_fields_arr = array(
                'message'           => mb_convert_encoding($sollicitation['message_d'], 'UTF-8', 'Windows-1252'),
                'cv'                => $sollic_cv,
                'lettre_motivation' => $sollic_lm,
                'conjoint'          => 0,
                'entreprise'        => $d[$sollicitation['ide_d']]
            );
    
    
            //update the post title
            $sollicitationTitle = mb_convert_encoding($sollicitation['intitule_d'], 'UTF-8', 'Windows-1252');
            $newSollicitation = array(
                'post_title'     => $sollicitationTitle,
                'post_type'      => 'fla_sollicitation',
                'post_status'    => 'publish',
                'comment_status' => 'closed',
                'ping_status'    => 'closed'
            );
    
            
    
            $sollicitation_added = wp_insert_post( $newSollicitation, true );
            //if post title not added halt and throw error
            if (is_wp_error($sollicitation_added)) {
                
                
                $errors = $sollicitation_added->get_error_messages();
                foreach ($errors as $error) {
                    echo  " ".$error;
                }
                
            }else {
                //if post added then update extra fields (acf)
                $sollicitationsOldIDVsNew[$sollicitation['id_d']] = $sollicitation_added;
                
                foreach ($sollicitation_fields_arr as $field_name => $field_value) {
                    $field_updated = update_field($field_name, $field_value, $sollicitation_added);
                    //if a field not updated throw error
                    if (!$field_updated) {
                        echo  'can\'t update ' .$field_name.' ';
                    }
                }
            }
        die();
    }//end while
    var_dump($sollicitationsOldIDVsNew);
    add_option('sollicitation_ids',$sollicitationsOldIDVsNew);
}//end if
die('hard');


// ******* code to import offres d'emploi **********
// var_dump($offres->num_rows);

// if($offres->num_rows > 0) {
//     while ($offre = $offres->fetch_assoc()) {
//         var_dump($offre['intitule_o']);
//         //array("UTF-8", "ASCII", "Windows-1252", "ISO-8859-15", "ISO-8859-1", "ISO-8859-6", "CP1256"); 
//         var_dump(mb_convert_encoding($offre['intitule_o'],'UTF-8','Windows-1252'));
//         //die();
//         ?>
             <!-- <li class="collection-item">importation de <?php //echo $offre['intitule_o'] ?>...</li> -->
        <?php
//         //fiche pdf
//         $fiche_de_post = 0;
//         if($offre['fichepdf_o'] != ''){
//             //upload pdf
//             $file = $fiche_pdfs_folder.$offre['fichepdf_o'];
//             $filename = basename($file);
//             $parent_post_id = 0;
//             $upload_file = wp_upload_bits($filename, null, file_get_contents($file));
//             if (!$upload_file['error']) {
//                 $wp_filetype = wp_check_filetype($filename, null );
//                 $attachment = array(
//                     'post_mime_type' => $wp_filetype['type'],
//                     'post_parent' => $parent_post_id,
//                     'post_title' => preg_replace('/\.[^.]+$/', '', $filename),
//                     'post_content' => '',
//                     'post_status' => 'inherit'
//                 );
//                 $fiche_de_post = wp_insert_attachment( $attachment, $upload_file['file'], $parent_post_id );
//                 if (!is_wp_error($fiche_de_post)) {
                    
//                 }//endif
//             }//endif
//         }//endif
        
//         $descriptif = mb_convert_encoding($offre['descriptif_o'],'UTF-8','Windows-1252');
//         $profil = mb_convert_encoding($offre['profil_o'],'UTF-8','Windows-1252');
//         $contactrh = mb_convert_encoding($offre['contact_o'],'UTF-8','Windows-1252');

//         echo ($descriptif);
//         echo '<br>'.$profil;
       
//         $emploi_fieldss_arr = array(
// 			'descriptif'        => $descriptif,
// 			'profil_recherche'  => $profil,
// 			'fiche_de_poste'    => $fiche_de_post,
// 			'contact_rh'        => $offre['contact_o'],
// 			'entreprise'        => $d[$offre['ide_o']]
// 		);

// //id_o,ide_o,intitule_o,descriptif_o,profil_o,contact_o,fichepdf_o,fonction_o,localisation_o
// 		//update the post title
// 		$newEmploi = array(
// 			'post_title'     => mb_convert_encoding($offre['intitule_o'],'UTF-8','Windows-1252'),
// 			'post_type'      => 'fla_emploi',
// 			'post_status'    => 'publish',
// 			'comment_status' => 'closed',
// 			'ping_status'    => 'closed'
// 		);

		

// 		$emploi_added = wp_insert_post( $newEmploi, true );
// 		//if post title not added halt and throw error
// 		if (is_wp_error($emploi_added)) {
			
			
// 			$errors = $emploi_added->get_error_messages();
// 			foreach ($errors as $error) {
// 				echo "######".$error;
// 			}
			
// 		}else {
//             echo 'post addeed';
// 			//if post added then update extra fields (acf)
// 			$offresOldIDsVsNew[$offre['id_o']] = $emploi_added;
// 			foreach ($emploi_fieldss_arr as $field_name => $field_value) {
// 				$field_updated = update_field($field_name, $field_value, $emploi_added);
// 				//if a field not updated throw error
// 				if (!$field_updated) {
// 					echo 'can\'t update ' .$field_name.' ';
// 				}
// 			}
//         }
//         //die();
//     }//endwhile
    
//     var_dump($offresOldIDsVsNew);
//     add_option('offres_ids',$offresOldIDsVsNew);

// }






// *******code to import entreprises**********

// $entreprisesOldIDsVsNewIDs = array();
// var_dump($entreprisesOldIDsVsNewIDs);
//   if ($entreprises->num_rows > 0) {
//     // output data of each row
//     while($row = $entreprises->fetch_assoc()) {
//         //echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
//         ?>
            <!-- <li class="collection-item">importation de <?php //echo $row['nom_a'] ?>...</li> -->
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