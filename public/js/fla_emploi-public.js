(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	$(function() {
		
		//init select element of materialize css lib
		$('select').formSelect();
		//init modal element of materialize css lib
		$('.modal').modal();


		//click event listener to show edit entreperise screen
		$("#fla_edit_entreprise_btn").click(function(e){
			e.preventDefault();
			$('.fla_edit_entreprise_container').show();
			var aTag = $('#entreprise_edit_section');
			$('html,body').animate({scrollTop: aTag.offset().top},'slow');
		});


		var customUploader;

		//click event to open media to load logo of entreprise
		$('#upload_logo_btn').click(function(e){
			e.preventDefault();

			customUploader = wp.media({
				title: 'Choisir une image',
				button : {
					text : 'Selectioner'
				},
				multiple: false
			});//custom uploader declaration

			if (customUploader) {
				customUploader.open();
			}

			//add event listener when image selected from wp media popup
			customUploader.on('select', function () {
				var imgAttachement = customUploader.state().get('selection').first().toJSON();
				console.log(imgAttachement);
				$('#entreprise_logo_edit').prop('src', imgAttachement.url);
				$('#entreprise_logo_id').val(imgAttachement.id);
			});
			
		});

		

		//click event listener to update entreprise (ajax)
		$('#fla_emploi_update_data_entreprise_btn').click(function(e){
			e.preventDefault();
			//disable button
			$('#fla_emploi_update_data_entreprise_btn').attr('disabled',true);
			//show loading
			$('#entreprise_edit_section>.progress').show();
			//collect form data
			var entrepriseData = {id:$('#entrepriseID').val()};

			if ($('#fla_title_txt').val().length < 1 ) {
				//show error and return
				$('#fla_title_txt').addClass('invalid');
				$('#entreprise_edit_section>.progress').hide();
				$('#fla_emploi_update_data_entreprise_btn').attr('disabled',false);
				$('#fla_title_txt').focus();
				return;
			}else {
				//add class valide
				$('#fla_title_txt').removeClass('invalid');
				$('#fla_title_txt').addClass('valid');
				entrepriseData.title = $('#fla_title_txt').val();
			}
			if ($('#fla_descriptif_txt').val().length < 20 ) {
				//show error and return
				$('#fla_descriptif_txt').addClass('invalid');
				$('#entreprise_edit_section>.progress').hide();
				$('#fla_emploi_update_data_entreprise_btn').attr('disabled',false);
				$('#fla_descriptif_txt').focus();
				return;
			}else {
				$('#fla_descriptif_txt').removeClass('invalid');
				$('#fla_descriptif_txt').addClass('valid');
				entrepriseData.descriptif = $('#fla_descriptif_txt').val();
			}
			if ($('#fla_adresse_txt').val().length < 8 ) {
				//show error and return
				$('#fla_adresse_txt').addClass('invalid');
				$('#entreprise_edit_section>.progress').hide();
				$('#fla_emploi_update_data_entreprise_btn').attr('disabled',false);
				$('#fla_adresse_txt').focus();
				return;
			}else {
				$('#fla_adresse_txt').removeClass('invalid');
				$('#fla_adresse_txt').addClass('valid');
				entrepriseData.adresse = $('#fla_adresse_txt').val();
			}
			entrepriseData.secteur = $('#fla_secteur :selected').val();
			var telPattern = /^[\s()+-]*([0-9][\s()+-]*){6,20}$/;
			if (!$('#fla_telephone_txt').val().match(telPattern) ) {
				//show error and return
				$('#fla_telephone_txt').addClass('invalid');
				$('#entreprise_edit_section>.progress').hide();
				$('#fla_emploi_update_data_entreprise_btn').attr('disabled',false);
				$('#fla_telephone_txt').focus();
				return;
			}else {
				$('#fla_telephone_txt').removeClass('invalid');
				$('#fla_telephone_txt').addClass('valid');
				entrepriseData.telephone = $('#fla_telephone_txt').val();
			}
			var emailpattern = /^[-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+)*\.(aero|arpa|biz|com|coop|edu|gov|info|int|mil|museum|name|net|org|pro|travel|mobi|[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/i;
			if (!$('#fla_email_txt').val().match(emailpattern) ) {
				//show error and return
				$('#fla_email_txt').addClass('invalid');
				$('#entreprise_edit_section>.progress').hide();
				$('#fla_emploi_update_data_entreprise_btn').attr('disabled',false);
				$('#fla_email_txt').focus();
				return;
			}else {
				$('#fla_email_txt').removeClass('invalid');
				$('#fla_email_txt').addClass('valid');
				entrepriseData.email = $('#fla_email_txt').val();
			}
			entrepriseData.site = $('#fla_site_web_txt').val();
			if ($('#fla_longitude_txt').val().length < 8 ) {
				//show error and return
				$('#fla_longitude_txt').addClass('invalid');
				$('#entreprise_edit_section>.progress').hide();
				$('#fla_emploi_update_data_entreprise_btn').attr('disabled',false);
				$('#fla_longitude_txt').focus();
				return;
			}else {
				$('#fla_longitude_txt').removeClass('invalid');
				$('#fla_longitude_txt').addClass('valid');
				entrepriseData.longitude = $('#fla_longitude_txt').val();
			}
			if ($('#fla_latitude_txt').val().length < 8 ) {
				//show error and return
				$('#fla_latitude_txt').addClass('invalid');
				$('#entreprise_edit_section>.progress').hide();
				$('#fla_emploi_update_data_entreprise_btn').attr('disabled',false);
				$('#fla_latitude_txt').focus();
				return;
			}else {
				$('#fla_latitude_txt').removeClass('invalid');
				$('#fla_latitude_txt').addClass('valid');
				entrepriseData.latitude = $('#fla_latitude_txt').val();
			}
			entrepriseData.logoID = parseInt($('#entreprise_logo_id').val(),10);

			console.log(entrepriseData);
			
			//send data
			$.ajax({
				type: 'POST',
				url:ajax_front_obj.ajax_url+'?action=update_entreprise',
				data:entrepriseData,
				success:function(res){
					//handle response
					res = JSON.parse(res);
					console.log(res);
					if(res.status == 'success'){
						//hide loading
						$('#entreprise_edit_section>.progress').hide();
						//clear form ?
						//$('form input').val('');
						//enable button
						$('#fla_emploi_update_data_entreprise_btn').attr('disabled',false);
						//hide edit section
						$('.fla_edit_entreprise_container').hide();
						//reload page
						location.reload();
					}else {
						//show error ajax
						$('#error_update_entreprise').show();
						//hide loading
						$('#entreprise_edit_section>.progress').hide();
						//enable button
						$('#fla_emploi_update_data_entreprise_btn').attr('disabled',false);
					}
					
				}
			});//end ajax
			
			
			

		});//end fla_emploi_update_data_entreprise_btn click function


		$('#upload_fiche_de_post_btn').click(function(e){
			customUploader = wp.media({
				title: 'Choisir un fichier pdf',
				button : {
					text : 'Selectioner'
				},
				library: {
					type: 'application/pdf'
				},
				multiple: false
			});

			if (customUploader) {
				console.log(customUploader);
				customUploader.open();
			}

			//add event listener when image selected from wp media popup
			customUploader.on('select', function () {
				var pdfAttachement = customUploader.state().get('selection').first().toJSON();
				console.log(pdfAttachement);
				$('#emploi_fiche_de_post').val(pdfAttachement.filename);
				$('#fiche_de_post_id').val(pdfAttachement.id);
			});
		});//end click function

		$('#upload_cv_btn').click(function(e){
			customUploader = wp.media({
				title: 'Choisir un fichier pdf',
				button : {
					text : 'Selectioner'
				},
				library: {
					type: 'application/pdf'
				},
				multiple: false
			});

			if (customUploader) {
				console.log(customUploader);
				customUploader.open();
			}

			//add event listener when image selected from wp media popup
			customUploader.on('select', function () {
				var pdfAttachement = customUploader.state().get('selection').first().toJSON();
				console.log(pdfAttachement);
				$('#sollicitation_cv').val(pdfAttachement.filename);
				$('#cv_id').val(pdfAttachement.id);
			});
		});//end click function

		$('#upload_lm_btn').click(function(e){
			customUploader = wp.media({
				title: 'Choisir un fichier pdf',
				button : {
					text : 'Selectioner'
				},
				library: {
					type: 'application/pdf'
				},
				multiple: false
			});

			if (customUploader) {
				console.log(customUploader);
				customUploader.open();
			}

			//add event listener when image selected from wp media popup
			customUploader.on('select', function () {
				var pdfAttachement = customUploader.state().get('selection').first().toJSON();
				console.log(pdfAttachement);
				$('#sollicitation_lettre_motivation').val(pdfAttachement.filename);
				$('#lm_id').val(pdfAttachement.id);
			});
		});//end click function

		$('#update_emploi_btn').click(function(e){
			e.preventDefault();
			//show loading
			$('form>.progress').show();
			//disable button
			$('#update_emploi_btn').attr('disabled',true);
			//validate and collect form data
			var emploi_data = {id:parseInt($('#emploi_id').val(), 10)};
			if ($('#emploi_title').val().length < 8) {
				//show error and return
				$('#emploi_title').addClass('invalid');
				$('form>.progress').hide();
				$('#update_emploi_btn').attr('disabled',false);
				$('#emploi_title').focus();
				return;
			}else {
				$('#emploi_title').removeClass('invalid');
				$('#emploi_title').addClass('valid');
				emploi_data.title = $('#emploi_title').val();
			}
			emploi_data.type_de_contrat = $('#type_de_contrat :selected').val();
			emploi_data.fonction = {
				'value' : $('#emploi_fonction :selected').val(),
				'label' : $('#emploi_fonction :selected').text()
			};
			
			emploi_data.localisation = $('#emploi_localisation :selected').val();
			
			// if ($('#emploi_descriptif').val().length < 20) {
			// 	//show error and return
			// 	$('#emploi_descriptif').addClass('invalid');
			// 	$('form>.progress').hide();
			// 	$('#update_emploi_btn').attr('disabled',false);
			// 	$('#emploi_descriptif').focus();
			// 	return;
			// }else {
			// 	$('#emploi_descriptif').removeClass('invalid');
			// 	$('#emploi_descriptif').addClass('valid');
			// 	emploi_data.descriptif = $('#emploi_descriptif').val();
			// }
			var content;
			var editor = tinyMCE.get('emploi_descriptif');
			if (editor) {
				// Ok, the active tab is Visual
				content = editor.getContent();
			} else {
				// The active tab is HTML, so just query the textarea
				content = $('#'+'emploi_descriptif').val();
			}
			emploi_data.descriptif = content;
			content;
			editor = tinyMCE.get('emploi_profile');
			if (editor) {
				// Ok, the active tab is Visual
				content = editor.getContent();
			} else {
				// The active tab is HTML, so just query the textarea
				content = $('#'+'emploi_profile').val();
			}
			emploi_data.profile = content;
			// if ($('#emploi_profile').val().length < 20) {
			// 	//show error and return
			// 	$('#emploi_profile').addClass('invalid');
			// 	$('form>.progress').hide();
			// 	$('#update_emploi_btn').attr('disabled',false);
			// 	$('#emploi_profile').focus();
			// 	return;
			// }else {
			// 	$('#emploi_profile').removeClass('invalid');
			// 	$('#emploi_profile').addClass('valid');
			// 	emploi_data.profile = $('#emploi_profile').val();
			// }

			var emailpattern = /^[-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+)*\.(aero|arpa|biz|com|coop|edu|gov|info|int|mil|museum|name|net|org|pro|travel|mobi|[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/i;
			if (!$('#emploi_contact_rh').val().match(emailpattern) ) {
				//show error and return
				$('#emploi_contact_rh').addClass('invalid');
				$('form>.progress').hide();
				$('#update_emploi_btn').attr('disabled',false);
				$('#emploi_contact_rh').focus();
				return;
			}else {
				$('#emploi_profile').removeClass('invalid');
				$('#emploi_profile').addClass('valid');
				emploi_data.contact_rh = $('#emploi_contact_rh').val();
			}
			emploi_data.fiche_de_post = parseInt($('#fiche_de_post_id').val(),10);

			if ($('#emploi_longitude').val().length < 8) {
				//show error and return
				$('#emploi_longitude').addClass('invalid');
				$('form>.progress').hide();
				$('#update_emploi_btn').attr('disabled',false);
				$('#emploi_longitude').focus();
				return;
			}else {
				$('#emploi_longitude').removeClass('invalid');
				$('#emploi_longitude').addClass('valid');
				emploi_data.longitude = $('#emploi_longitude').val();
			}

			if ($('#emploi_latitude').val().length < 8) {
				//show error and return
				$('#emploi_latitude').addClass('invalid');
				$('form>.progress').hide();
				$('#update_emploi_btn').attr('disabled',false);
				$('#emploi_latitude').focus();
				return;
			}else {
				$('#emploi_latitude').removeClass('invalid');
				$('#emploi_latitude').addClass('valid');
				emploi_data.latitude = $('#emploi_latitude').val();
			}

			console.log(emploi_data);
			
			
			//send Ajax request
			$.ajax({
				type : 'POST',
				url  : ajax_front_obj.ajax_url+'?action=update_emploi_data',
				data : emploi_data,
				success : function (res) {
					res = JSON.parse(res);
					console.log(res);
					if(res.status == 'success') {
						location.reload();
					}else {
						
						$('#error_update_emploi').show();
					}
					$('form>.progress').hide();
					$('#update_emploi_btn').attr('disabled',false);
				}
			});
			//if ajax request success hide loading reload page
			//else if erreor hide loading, enable button show error


		});//end click function 

		$('#update_sollicitation_btn').click(function(e){
			e.preventDefault();
			//show loading
			$('form>.progress').show();
			//disable button
			$('#update_sollicitation_btn').attr('disabled',true);
			//validate and collect form data
			var sollicitation_data = {id:parseInt($('#sollicitation_id').val(), 10)};
			if ($('#sollicitation_title').val().length < 8) {
				//show error and return
				$('#sollicitation_title').addClass('invalid');
				$('form>.progress').hide();
				$('#update_sollicitation_btn').attr('disabled',false);
				$('#sollicitation_title').focus();
				return;
			}else {
				$('#sollicitation_title').removeClass('invalid');
				$('#sollicitation_title').addClass('valid');
				sollicitation_data.title = $('#sollicitation_title').val();
			}
			
			sollicitation_data.fonction = {
				'value' : $('#sollicitation_fonction :selected').val(),
				'label' : $('#sollicitation_fonction :selected').text()
			};
			
			if ($('#sollicitation_message').val().length < 20) {
				//show error and return
				$('#sollicitation_message').addClass('invalid');
				$('form>.progress').hide();
				$('#update_sollicitation_btn').attr('disabled',false);
				$('#sollicitation_message').focus();
				return;
			}else {
				$('#sollicitation_message').removeClass('invalid');
				$('#sollicitation_message').addClass('valid');
				sollicitation_data.message = $('#sollicitation_message').val();
			}
			

			
			sollicitation_data.conjoint = ($('#sollicitation_conjoint').prop('checked'))?1:0;
			sollicitation_data.cv       = parseInt($('#cv_id').val(),10);
			sollicitation_data.lm       = parseInt($('#lm_id').val(),10);

			console.log(sollicitation_data);
			//send Ajax request
			
			$.ajax({
				type : 'POST',
				url  : ajax_front_obj.ajax_url+'?action=update_sollicitation_data',
				data : sollicitation_data,
				success : function (res) {
					res = JSON.parse(res);
					console.log(res);
					if(res.status == 'success') {
						location.reload();
					}else {
						
						$('#error_update_sollicitation').show();
					}
					$('form>.progress').hide();
					$('#update_sollicitation_btn').attr('disabled',false);
				}
			});
			//if ajax request success hide loading reload page
			//else if erreor hide loading, enable button show error


		});//end click function 

		//add_new_emploi_btn
		$('#add_new_emploi_btn').click(function(e){
			e.preventDefault();
			$('#error_update_emploi').hide();
			//show loading
			$('form>.progress').show();
			//disable button
			$('#add_new_emploi_btn').attr('disabled',true);
			//validate and collect form data
			var emploi_data = {};
			console.log('start validation');
			if ($('#emploi_title').val().length < 8) {
				console.log('title not valide');
				//show error and return
				$('#emploi_title').addClass('invalid');
				$('form>.progress').hide();
				$('#add_new_emploi_btn').attr('disabled',false);
				$('#emploi_title').focus();
				return;
			}else {
				$('#emploi_title').removeClass('invalid');
				$('#emploi_title').addClass('valid');
				emploi_data.title = $('#emploi_title').val();
			}
			emploi_data.type_de_contrat = $('#type_de_contrat :selected').val();
			emploi_data.fonction = {
				'value' : $('#emploi_fonction :selected').val(),
				'label' : $('#emploi_fonction :selected').text()
			};
			
				emploi_data.localisation = $('#emploi_localisation :selected').val();
			
			if ($('#emploi_descriptif').val().length < 20) {
				//show error and return
				$('#emploi_descriptif').addClass('invalid');
				$('form>.progress').hide();
				$('#add_new_emploi_btn').attr('disabled',false);
				$('#emploi_descriptif').focus();
				return;
			}else {
				$('#emploi_descriptif').removeClass('invalid');
				$('#emploi_descriptif').addClass('valid');
				emploi_data.descriptif = $('#emploi_descriptif').val();
			}
			if ($('#emploi_profile').val().length < 20) {
				//show error and return
				$('#emploi_profile').addClass('invalid');
				$('form>.progress').hide();
				$('#add_new_emploi_btn').attr('disabled',false);
				$('#emploi_profile').focus();
				return;
			}else {
				$('#emploi_profile').removeClass('invalid');
				$('#emploi_profile').addClass('valid');
				emploi_data.profile = $('#emploi_profile').val();
			}

			var emailpattern = /^[-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+)*\.(aero|arpa|biz|com|coop|edu|gov|info|int|mil|museum|name|net|org|pro|travel|mobi|[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/i;
			if (!$('#emploi_contact_rh').val().match(emailpattern) ) {
				//show error and return
				$('#emploi_contact_rh').addClass('invalid');
				$('form>.progress').hide();
				$('#add_new_emploi_btn').attr('disabled',false);
				$('#emploi_contact_rh').focus();
				return;
			}else {
				$('#emploi_profile').removeClass('invalid');
				$('#emploi_profile').addClass('valid');
				emploi_data.contact_rh = $('#emploi_contact_rh').val();
			}
			emploi_data.fiche_de_post = parseInt($('#fiche_de_post_id').val(),10);

			if ($('#emploi_longitude').val().length < 8) {
				//show error and return
				$('#emploi_longitude').addClass('invalid');
				$('form>.progress').hide();
				$('#add_new_emploi_btn').attr('disabled',false);
				$('#emploi_longitude').focus();
				return;
			}else {
				$('#emploi_longitude').removeClass('invalid');
				$('#emploi_longitude').addClass('valid');
				emploi_data.longitude = $('#emploi_longitude').val();
			}

			if ($('#emploi_latitude').val().length < 8) {
				//show error and return
				$('#emploi_latitude').addClass('invalid');
				$('form>.progress').hide();
				$('#add_new_emploi_btn').attr('disabled',false);
				$('#emploi_latitude').focus();
				return;
			}else {
				$('#emploi_latitude').removeClass('invalid');
				$('#emploi_latitude').addClass('valid');
				emploi_data.latitude = $('#emploi_latitude').val();
			}
			if (parseInt($('#emploi_entreprise').val(),10) == 0) {
				console.log('entreprise not selected');
				//show error and return
				$('#emploi_entreprise_wrapper>.select-wrapper>input.select-dropdown').addClass('invalid');
				$('form>.progress').hide();
				$('#add_new_emploi_btn').attr('disabled',false);
				$('#emploi_entreprise_wrapper>.select-wrapper>input.select-dropdown').focus();
				return;
			} else {
				console.log('entreprise is selected');
				$('#emploi_entreprise_wrapper>.select-wrapper>input.select-dropdown').removeClass('invalid');
				$('#emploi_entreprise_wrapper>.select-wrapper>input.select-dropdown').addClass('valid');
				emploi_data.entreprise = parseInt($('#emploi_entreprise :selected').val(),10);
			}

			console.log(emploi_data);
			//send Ajax request
			$.ajax({
				type : 'POST',
				url  : ajax_front_obj.ajax_url+'?action=add_new_emploi',
				data : emploi_data,
				success : function (res) {
					res = JSON.parse(res);
					console.log(res);
					if(res.status == 'success') {
						//location.reload();
						location.href = res.result;
					}else {
						$('#error_new_sollicitation').show();
					}
					$('form>.progress').hide();
					$('#add_new_emploi_btn').attr('disabled',false);
				}
			});
			//if ajax request success hide loading reload page
			//else if erreor hide loading, enable button show error


		});//end click function
		$('#add_new_sollicitation_btn').click(function(e){
			e.preventDefault();
			$('#error_update_emploi').hide();
			//show loading
			$('form>.progress').show();
			//disable button
			$('#add_new_sollicitation_btn').attr('disabled',true);
			//validate and collect form data
			var sollicitation_data = {id:parseInt($('#sollicitation_id').val(), 10)};
			if ($('#sollicitation_title').val().length < 8) {
				//show error and return
				$('#sollicitation_title').addClass('invalid');
				$('form>.progress').hide();
				$('#add_new_sollicitation_btn').attr('disabled',false);
				$('#sollicitation_title').focus();
				return;
			}else {
				$('#sollicitation_title').removeClass('invalid');
				$('#sollicitation_title').addClass('valid');
				sollicitation_data.title = $('#sollicitation_title').val();
			}
			
			sollicitation_data.fonction = {
				'value' : $('#sollicitation_fonction :selected').val(),
				'label' : $('#sollicitation_fonction :selected').text()
			};
			
			if ($('#sollicitation_message').val().length < 20) {
				//show error and return
				$('#sollicitation_message').addClass('invalid');
				$('form>.progress').hide();
				$('#add_new_sollicitation_btn').attr('disabled',false);
				$('#sollicitation_message').focus();
				return;
			}else {
				$('#sollicitation_message').removeClass('invalid');
				$('#sollicitation_message').addClass('valid');
				sollicitation_data.message = $('#sollicitation_message').val();
			}
			if (parseInt($('#sollicitation_entreprise').val(),10) == 0) {
				console.log('entreprise not selected');
				//show error and return
				$('#sollicitation_entreprise_wrapper>.select-wrapper>input.select-dropdown').addClass('invalid');
				$('form>.progress').hide();
				$('#add_new_sollicitation_btn').attr('disabled',false);
				$('#sollicitation_entreprise_wrapper>.select-wrapper>input.select-dropdown').focus();
				return;
			} else {
				console.log('entreprise is selected');
				$('#sollicitation_entreprise_wrapper>.select-wrapper>input.select-dropdown').removeClass('invalid');
				$('#sollicitation_entreprise_wrapper>.select-wrapper>input.select-dropdown').addClass('valid');
				sollicitation_data.entreprise = parseInt($('#sollicitation_entreprise :selected').val(),10);
			}
			

			
			sollicitation_data.conjoint = ($('#sollicitation_conjoint').prop('checked'))?1:0;
			sollicitation_data.cv       = parseInt($('#cv_id').val(),10);
			sollicitation_data.lm       = parseInt($('#lm_id').val(),10);

			console.log(sollicitation_data);
			
			//send Ajax request
			$.ajax({
				type : 'POST',
				url  : ajax_front_obj.ajax_url+'?action=add_new_sollicitation',
				data : sollicitation_data,
				success : function (res) {
					res = JSON.parse(res);
					console.log(res);
					if(res.status == 'success') {
						//location.reload();
						location.href = res.result;
					}else {
						$('#error_update_emploi').show();
					}
					$('form>.progress').hide();
					$('#add_new_sollicitation_btn').attr('disabled',false);
				}
			});
			//if ajax request success hide loading reload page
			//else if erreor hide loading, enable button show error


		});//end click function

		$('.delete_emploi_btn').click(function (e){
			e.preventDefault();
			var emploiIDToDelete = parseInt($(this).attr('data'),10);
			$('#emploi_id_to_delete').val(emploiIDToDelete);
			$('#delete_confirm_modal').modal('open');
		});//end click

		$('#delete_emploi_confirm').click(function(e){
			e.preventDefault();

			//show loading
			$('.preloader-wrapper').show();
			//disable buttons
			$('#delete_emploi_confirm').attr('disabled', true);
			$('#delete_confirm_modal .modal-footer .modal-close').attr('disabled', true);
			var id_to_delete = parseInt($('#emploi_id_to_delete').val());
			//send ajax request to delete
			$.ajax({
				type : 'post',
				url : ajax_front_obj.ajax_url+'?action=delete_emploi',
				data : {'id_to_delete':id_to_delete},
				success: function (res) {
					console.log(res);
					res = JSON.parse(res);
					if (res.status == 'success') {
						//post status changed to trash
						//hide loading
						$('.preloader-wrapper').hide();
						//enable buttons
						$('#delete_emploi_confirm').attr('disabled', false);
						$('#delete_confirm_modal .modal-footer .modal-close').attr('disabled', false);
						//close modal
						$('#delete_confirm_modal').modal('close');
						//delete post row
						$('#item_'+id_to_delete).slideUp(1000,function(){
							$('#item_'+id_to_delete).remove();
						});

					}else {
						//post status not changed
						//hide loading
						$('.preloader-wrapper').hide();
						//show error
						$('#delete_confirm_modal .error_container').show();
					}
				}
			});
		});//end click

		$('.delete_sollicitation_btn').click(function (e){
			e.preventDefault();
			var sollicitationIDToDelete = parseInt($(this).attr('data'),10);
			$('#sollicitation_id_to_delete').val(sollicitationIDToDelete);
			$('#delete_sollicitation_confirm_modal').modal('open');
		});//end click

		$('#delete_sollicitation_confirm').click(function(e){
			e.preventDefault();

			//show loading
			$('.preloader-wrapper').show();
			//disable buttons
			$('#delete_sollicitation_confirm').attr('disabled', true);
			$('#delete_sollicitation_confirm_modal .modal-footer .modal-close').attr('disabled', true);
			var id_to_delete = parseInt($('#sollicitation_id_to_delete').val());
			//send ajax request to delete
			$.ajax({
				type : 'post',
				url : ajax_front_obj.ajax_url+'?action=delete_sollicitation',
				data : {'id_to_delete':id_to_delete},
				success: function (res) {
					console.log(res);
					res = JSON.parse(res);
					if (res.status == 'success') {
						//post status changed to trash
						//hide loading
						$('.preloader-wrapper').hide();
						//enable buttons
						$('#delete_sollicitation_confirm').attr('disabled', false);
						$('#delete_sollicitation_confirm_modal .modal-footer .modal-close').attr('disabled', false);
						//close modal
						$('#delete_sollicitation_confirm_modal').modal('close');
						//delete post row
						$('#item_'+id_to_delete).slideUp(1000,function(){
							$('#item_'+id_to_delete).remove();
						});

					}else {
						//post status not changed
						//hide loading
						$('.preloader-wrapper').hide();
						//show error
						$('#delete_sollicitation_confirm_modal .error_container').show();
					}
				}
			});
		});//end click

		//archive emploi posts
		$('.archive_emploi_btn').click(function (e){
			e.preventDefault();
			var emploiIDToArchive = parseInt($(this).attr('data'),10);
			$('#emploi_id_to_archive').val(emploiIDToArchive);
			$('#archive_confirm_modal').modal('open');
		});//end click

		$('#archive_emploi_confirm').click(function(e){
			e.preventDefault();

			//show loading
			$('.preloader-wrapper').show();
			//disable buttons
			$('#archive_emploi_confirm').attr('disabled', true);
			$('#archive_confirm_modal .modal-footer .modal-close').attr('disabled', true);
			var id_to_archive = parseInt($('#emploi_id_to_archive').val());
			//send ajax request to archive
			$.ajax({
				type : 'post',
				url : ajax_front_obj.ajax_url+'?action=archive_emploi',
				data : {'id_to_archive':id_to_archive},
				success: function (res) {
					console.log(res);
					res = JSON.parse(res);
					if (res.status == 'success') {
						//post status changed to trash
						//hide loading
						$('.preloader-wrapper').hide();
						//enable buttons
						$('#archive_emploi_confirm').attr('disabled', false);
						$('#archive_confirm_modal .modal-footer .modal-close').attr('disabled', false);
						//close modal
						$('#archive_confirm_modal').modal('close');
						//archive post row
						$('#item_'+id_to_archive).slideUp(1000,function(){
							$('#item_'+id_to_archive).remove();
						});

					}else {
						//post status not changed
						//hide loading
						$('.preloader-wrapper').hide();
						//show error
						$('#archive_confirm_modal .error_container').show();
					}
				}
			});
		});//end click


		$('.archive_sollicitation_btn').click(function (e){
			e.preventDefault();
			var sollicitationIDToDelete = parseInt($(this).attr('data'),10);
			$('#sollicitation_id_to_archive').val(sollicitationIDToDelete);
			$('#archive_sollicitation_confirm_modal').modal('open');
		});//end click

		$('#archive_sollicitation_confirm').click(function(e){
			e.preventDefault();

			//show loading
			$('.preloader-wrapper').show();
			//disable buttons
			$('#archive_sollicitation_confirm').attr('disabled', true);
			$('#archive_sollicitation_confirm_modal .modal-footer .modal-close').attr('disabled', true);
			var id_to_archive = parseInt($('#sollicitation_id_to_archive').val());
			//send ajax request to archive
			$.ajax({
				type : 'post',
				url : ajax_front_obj.ajax_url+'?action=archive_sollicitation',
				data : {'id_to_archive':id_to_archive},
				success: function (res) {
					console.log(res);
					res = JSON.parse(res);
					if (res.status == 'success') {
						//post status changed to trash
						//hide loading
						$('.preloader-wrapper').hide();
						//enable buttons
						$('#archive_sollicitation_confirm').attr('disabled', false);
						$('#archive_sollicitation_confirm_modal .modal-footer .modal-close').attr('disabled', false);
						//close modal
						$('#archive_sollicitation_confirm_modal').modal('close');
						//archive post row
						$('#item_'+id_to_archive).slideUp(1000,function(){
							$('#item_'+id_to_archive).remove();
						});

					}else {
						//post status not changed
						//hide loading
						$('.preloader-wrapper').hide();
						//show error
						$('#archive_sollicitation_confirm_modal .error_container').show();
					}
				}
			});
		});//end click

	 });
})( jQuery );
