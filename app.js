/*
	Author: Bien Jerico Cueto
	File name: app.js
	Description: Functions
	Dependencies: jQuery
*/

$(function(){

	/* enable submit button upon check the radio button */
	var enabledButton = false;
	$('.radio-row ul li').each(function(){
		$(this).find('input:radio[name=radioReserve]').on('click',function(){
			if($(this).is(':checked')){
				enabledButton = true;
			}
			if(enabledButton){
				$('#btnSubmit').prop('disabled', false);
			}
		});
	});

	/* refresh all radio button / uncheck radio button */
	$('#btnRefresh').on('click',function(){
		$('#btnSubmit').prop("disabled", true);
		$('input:radio[name=radioReserve]').each(function(){
			$(this).prop('checked', false);
		})
	});

	/* submit button then display the selected timeslot to modal */
	$('#btnSubmit').on('click',function(){
		var timeSlot;
		$('.radio-row ul li').each(function(){

			if($(this).find("input:radio[name=radioReserve]").is(':checked')){
				timeSlot = $(this).find('input:text').val();
			}
		})
		$('#modalResult').html(timeSlot);
	});

	/* modal submit button process the timeslot id and email address */
	$('#btnSubmitConfirmed').on('click',function(){
		var schedEmail = $('#schedEmail').val();
		var timeSlotId;
		$('.radio-row ul li').each(function(){
			var radioReserve = $(this).find("input:radio[name=radioReserve]");	

			if(radioReserve.is(':checked')){
				timeSlotId = radioReserve.val();
			}
		})

		$.post( "reservation-process.php", { schedEmail: schedEmail, timeSlotId: timeSlotId })
		  .done(function( data ) {
		  	var result = $.parseJSON(data);
			    if(result.status){
					$('#modalResult').html(result.message);
					$('#btnSubmit').prop('disabled', true);
			    }else{
			    	$('#modalResult').html(result.message);
			    }
			    $('#btnClose').bind("click", function(e) { reloadPage(); });
		  })
		  .fail(function() {
		    $('#modalResult').html("Something went wrong. Kindly refesh your browser.");
		  });

		  $('#myModal #myModalLabel,#myModal #btnSubmitConfirmed').remove();


	});

	function reloadPage(){
		location.reload();
	}

	$('.single-list ul').on('click',function(){
		// console.log($(this).find('li.accordion-list').hasClass('in'));
		if($(this).find('li.accordion-list').hasClass('in')){
			$(this).find('li.accordion-label span').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
		} else {
			$(this).find('li.accordion-label span').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
		}

	})


})