$(document).ready(function(){

	var game_id = window.location.pathname.substr(7);

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
				if(response.message != 'Game sucessfully entered' && response.message != 'Player sucessfully updated'){
					alert(response.message);
				}else{
					console.log(response.message);
				}
			}
		})
	})

	// ################ enter game end ###################



	//################## Player enter event start ################
	var pusher = new Pusher('9512c6943ba979af3517', {
	  cluster: 'eu'
	});

	var channel = pusher.subscribe('player_enter');
	channel.bind('player_enter-event', function(data) {
	    console.log(data);

	    //only execute at the right page
	    if(data.game_id == game_id){
	    	var previousPlayer = parseInt(data.position) -1;
			var player_number = $('#player_table tr').length;
			var newPlayerRow = '<th class="col_1" scope="row" style="width: 33%">' + data.position + '.</th><td class="text-center col_2" style="width: 33%">' + data.username + '(' + data.bid + ')' + '</td><td class="text-right col_3" style="width: 33%"><a href="#">Zum Profil</a></td></tr>';
			var newPlayerPosition = parseInt(data.position);

			console.log(newPlayerPosition);
			console.log(player_number);

			//first player in the game
			if(player_number == 0){
				$('#player_table tbody').prepend(newPlayerRow);
			// some other players are there already
			}else{
				//adjust the position-numbers of the other players
				for (var i = parseInt(previousPlayer + 1); i <= player_number; i++) {
					console.log($('#player_table tr:nth-child(' + i + ')').html());
		    		$('#player_table tr:nth-child(' + i + ')').find('th').text(i + 1);
	    		}

		    	//insert the new player in the table

		    	if(data.position == 1){
		    		$('#player_table tbody').prepend(newPlayerRow);
		    	}else{
		    		$('#player_table tr:nth-child(' + previousPlayer + ')').after(newPlayerRow);
		    	}
			}


	    }

	});
	//################## Player enter event end ##################

    document.getElementById('watchAdBtn').addEventListener('click', function (e) {
        e.preventDefault();
        var data = {coins: "1"};

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
                alert(response.message);
            }
		})
    });

    document.getElementById('buy99').addEventListener('click', function (e) {
        e.preventDefault();
        var data = {coins: "99"};

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
                alert(response.message);
            }
		})
    });

    document.getElementById('buy999').addEventListener('click', function (e) {
        e.preventDefault();
        var data = {coins: "999"};

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
                alert(response.message);
            }
		})
    });

    document.getElementById('buy9999').addEventListener('click', function (e) {
        e.preventDefault();
        var data = {coins: "9999"};

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
                alert(response.message);
            }
		})
    });

    document.getElementById('donate10').addEventListener('click', function (e) {
        e.preventDefault();
        var data = {coins: "10"};

        $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });
		$.ajax({
			url: '/removeBalance',
			type: 'POST',
			dataType: 'json',
			data: data,
			success: function(response) {
                document.getElementById("navbarBalanceA").textContent = response.coins + ' Coins';
                alert(response.message);
            }
		})
    });
})
