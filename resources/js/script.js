$(document).ready(function(){

	var game_id = window.location.pathname.substr(7);

	$('.game-card').mouseenter(function(){
		$(this).find('.card-header').css("background-color", "#7001ba");
        $(this).find('.card-body').css("background-color", "#7001ba");
        $(this).find('.game-icon').css("color", "#232323");
	});

	$('.card').mouseleave(function(){
		$('.card-header').css("background-color", "#232323");
        $('.card-body').css("background-color", "#232323");
        $(this).find('.game-icon').css("color", "#7001ba");
	});


	// ################ enter game start #################
	var player_enter_form = $('#player_enter_form');

	player_enter_form.on('submit', function(e){

		//cancel default behavior like reloading the page or submitting the form
		e.preventDefault();

		// serialize the form data
		var data = player_enter_form.serialize();

		$.ajax({
			url: '/games/' + game_id + '/enter',
			type: 'POST',
			dataType: 'json',
			data: data,
			success: function(response){

				$('#game_bid_modal .modal-body').html(response.message);

            	$('#game_bid_modal').modal('show');

                $('#game_bid').val('');

				if(response.message == 'You Bid successfully' || response.message == 'Game successfully entered with the min Bid'){
					document.getElementById("navbarBalanceA").textContent = response.newBalance + ' Coins';
				}

			}
		})
	})

	// ################ enter game end ###################



	//################## Player change event start ################

	var pusher = new Pusher('9512c6943ba979af3517', {
	  cluster: 'eu'
	});

	var channel = pusher.subscribe('player_change');
	channel.bind('player_change-event', function(data) {

	    //only execute at the right page
	    if(data.game_id == game_id){

	    	var max_players = $('#player_number').html().slice(-1);


			$.ajax({
				url: '/games/' + game_id + '/getgamedata',
				type: 'GET',
				success: function(response){

					if(response.player_number == max_players){
						$('.enter-button').html('Bid NOW');
						$('#player_enter_form .form-group').removeAttr('hidden');
					}

					// update player counter
					$('#player_number').html('Spieler: ' + response.player_number + '/' + max_players);

					// clear current table and add tbody element again
					$('#player_table').empty();
					$('#player_table').prepend('<tbody></tbody>');

					// fill the table with new data
					for (var i = 0; i < response.data.length; i++) {
						$('#player_table tbody').append('<tr><th class="col_1" scope="row" style="width: 33%">' + parseInt(i + 1) + '.</th><td class="text-center col_2" style="width: 33%">' + response.data[i].username + ' (' + response.data[i].bid + ')</td><td class="text-right col_3" style="width: 33%"><a href="/user/' + response.data[i].user_id + '" class="btn button-purple">Zum Profil</a></td></tr>');
					}
				}
			})
	    }
	});

	//################## Player change event end ##################


	var pusher = new Pusher('9512c6943ba979af3517', {
	  cluster: 'eu'
	});

	var channel = pusher.subscribe('game_end');
	channel.bind('game_end-event', function(data) {

	    //only execute at the right page
	    if(data.game_id == game_id){

	 		for (var i = 0; i < data.winners.length; i++) {
	 			$('#modal_winners').append('<p>' + data.winners[i] + ': ' + data.earnings[i] + ' IGW</p>');
	 		}

			setTimeout(function(){ $('#game_end_modal').modal('show') }, 5000);
	    }
	});



    $('.coinChanger').on('click', function (e) {
        e.preventDefault();
        switch(this.id) {
            case 'watchAdBtn':
                var data = {coins: "1"};
              break;
            case 'buy99':
                var data = {coins: "99"};
              break;
            case 'buy999':
                var data = {coins: "999"};
            break;
            case 'buy9999':
                var data = {coins: "9999"};
            break;
            case 'donate10':
                var data = {coins: "-10"};
            break;
            default:
                var data = {coins: "0"};
          }

        $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });
		$.ajax({
			url: '/addBalance',
			type: 'POST',
			dataType: 'json',
			data: data,
			success: function(response) {
				document.getElementById("navbarBalanceA").textContent = response.coins + ' Coins';

            	$('#coin_add_modal .modal-body').html('You now have ' + response.coins + ' Coins in your account');

            	$('#coin_add_modal').modal('show');
            }
		})
    });

    user_change_form = $('#user_change_form');
    user_id = $('#user_id_user').val();

});
window.onload = function() {
$('.counter-count').each(function () {
        $(this).prop('Counter',0).animate({
            Counter: $(this).text()
        }, {
            duration: 5000,
            easing: 'swing',
            step: function (now) {
                $(this).text(Math.ceil(now));
            }
        });
    });
}
