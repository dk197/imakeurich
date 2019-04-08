$(document).ready(function(){

	var game_id = window.location.pathname.substr(7);

	// ################ enter game start #################
	var player_enter_form = $('#player_enter_form');

	player_enter_form.on('submit', function(e){

		//cancel default behavior like reloading the page or submitting the form
		e.preventDefault();

		// serialize the form data
		var data = player_enter_form.serialize();
		var max_players = $('#player_number').html().slice(-1);

		$.ajax({
			url: '/games/' + game_id + '/enter',
			type: 'POST',
			dataType: 'json',
			data: data,
			success: function(response){
				alert(response.message);
				console.log(response);
                $('#game_bid').val('');
                document.getElementById("navbarBalanceA").textContent = response.newBalance + ' Coins';
				$('#player_number').html('Spieler: ' + response.player_number + '/' + max_players);
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

					// clear current table and add tbody element again
					$('#player_table').empty();
					$('#player_table').prepend('<tbody></tbody>');

					// fill the table with new data
					for (var i = 0; i < response.length; i++) {
						$('#player_table tbody').append('<tr><th class="col_1" scope="row" style="width: 33%">' + parseInt(i + 1) + '.</th><td class="text-center col_2" style="width: 33%">' + response[i].username + ' (' + response[i].bid + ')</td><td class="text-right col_3" style="width: 33%"><a href="/user/' + response[i].user_id + '">Zum Profil</a></td></tr>');
					}
					console.log(response);
					$('#player_number').html('Spieler: ' + response.player_number + '/' + max_players);
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

			$('#game_end_modal').modal('show');

			window.location.href = "/games";
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
                console.log(response);
                document.getElementById("navbarBalanceA").textContent = response.coins + ' Coins';
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
