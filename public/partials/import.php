<?php
/**
 * The template for import.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Flash emploi
 */


$d = get_option( 'entreprises_ids');
var_dump($d);



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

  $sql = 'SELECT id_o,ide_o,intitule_o,descriptif_o,profil_o,contact_o,fichepdf_o,fonction_o,localisation_o FROM resonne.offre';

  $offres = $con->query($sql);

  $offresOldIDsVsNew = array();

//$entreprises_logos_folder = 'C:/wamp64/www/emploi/wp-content/uploads/entreprise/';
$fiche_pdfs_folder = 'C:/wamp64/www/emploi/wp-content/uploads/entreprise/fichier/ficheoffre/';
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

if($offres->num_rows > 0) {
    while ($offre = $offres->fetch_assoc()) {
        var_dump($offre);
        
        
        ?>
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
                    require_once(ABSPATH . "wp-admin" . '/includes/image.php');
                    $attachment_data = wp_generate_attachment_metadata( $fiche_de_post, $upload_file['file'] );
                    wp_update_attachment_metadata( $fiche_de_post,  $attachment_data );
                }//endif
            }//endif
        }//endif

        $emploi_fieldss_arr = array(
			'descriptif'        => $offre['descriptif_o'],
			'profil_recherche'  => $offre['profil_o'],
			'fiche_de_poste'    => $fiche_de_post,
			'contact_rh'        => $offre['contact_o'],
			'entreprise'        => $d[$offre['ide_o']]
		);

//id_o,ide_o,intitule_o,descriptif_o,profil_o,contact_o,fichepdf_o,fonction_o,localisation_o
		//update the post title
		$newEmploi = array(
			'post_title'     => $offre['intitule_o'],
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
				echo " ".$error;
			}
			
		}else {
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
        
    }//endwhile
    var_dump($offresOldIDsVsNew);
    add_option('offres_ids',$offresOldIDsVsNew);
}








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