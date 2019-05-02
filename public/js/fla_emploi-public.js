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


		//click event listener to show edit entreperise screen
		$("#fla_edit_entreprise_btn").click(function(e){
			e.preventDefault();
			$('.fla_edit_entreprise_container').show();
			var aTag = $('#entreprise_edit_section');
			$('html,body').animate({scrollTop: aTag.offset().top},'slow');
		});


		var customUploader = wp.media({
			title: 'Choisir une image',
			button : {
				text : 'Selectioner'
			},
			multiple: false
		});//custom uploader declaration

		//click event to open media to load logo of entreprise
		$('#upload_logo_btn').click(function(e){
			e.preventDefault();
			if (customUploader) {
				customUploader.open();
			}
			
		});

		//add event listener when image selected from wp media popup
		customUploader.on('select', function () {
			var imgAttachement = customUploader.state().get('selection').first().toJSON();
			console.log(imgAttachement);
			$('#entreprise_logo_edit').prop('src', imgAttachement.url);
			$('#entreprise_logo_id').val(imgAttachement.id);
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
			});
			
			
			

		});
	 });
})( jQuery );
