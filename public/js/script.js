$(document).ready(function(){

	var player_enter_form = $('#player_enter_form');

	player_enter_form.on('submit', function(e){

		//cancel default behavior like reloading the page or submitting the form
		e.preventDefault();

		var data = player_enter_form.serialize();
		var game_id = window.location.pathname.substr(7);

		$.ajax({
			url: '/games/' + game_id + '/enter',
			type: 'POST',
			dataType: 'json',
			data: data,
			success: function(response){
				console.log(response);
			}
		})
	})

	//################## Player enter event start ################
	var pusher = new Pusher('9512c6943ba979af3517', {
	  cluster: 'eu'
	});

	var channel = pusher.subscribe('player_enter');
	channel.bind('player_enter-event', function(data) {
	    console.log(data);
	    
	});
	//################## Player enter event end ##################
	console.log(window.location.pathname.substr(7));	


})