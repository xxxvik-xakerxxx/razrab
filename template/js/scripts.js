$(document).ready(function () {
  var socket = io.connect(':8080');

	socket.on('online', function (data) {
			$('.online').text(Math.abs(data));
			console.log(data);
	});


function checkDrop(case2){
  setTimeout( function(){
    $.ajax({
    url: '/api',
    type: 'post',
    data: {action: 'checkCase', case1: case2},
    dataType: 'json',
    success: function(rdata){
      if('true' == rdata.result){
          swal("Success", "Cases  reloaded!", "success");
      }else{
            swal("Error", "Error loading cases!", "error");
      }
    }
  });
    }  , 10000 );
}


	$('.buttonz').click(function() {
		var tradeurl = document.getElementById('tradelink').value;
		console.log(tradeurl);
		$.ajax({
			url: '/api',
			type: 'post',
			data: {action: 'updateLink', tradelink: tradeurl},
			dataType: 'json',
			success: function(rdata){
				if('true' == rdata.result){
						swal("Success", "Trade url saved!", "success");
				}else{
							swal("Error", "Trade url not saved!", "error");
				}
			}
		});
	});
	$('.opencase-title').click(function() {
		window.location.href = "/";
	});
	$('.howto').click(function() {
		$('.faq').slideToggle('slow');
	});
	$('.faq-qs-one-q').click(function(){
		$('.faq-qs-one-a').hide();
		$(this).siblings('.faq-qs-one-a').show();
	});

	$('.plink.start').click(function(){
		$('.profil-tabs').slideToggle();
	});
	$('.p-set').click(function() {
		if($(this).hasClass('current'));
		var index = $('div', $(this).parent()).removeClass('current').index(this);
			$(this).addClass('current').parents('.profil .rcol').find('.profil-tabs-in').hide().eq(index).fadeIn('slow');
		return false;
	});
});
$(document).ready(function(){
            $('.spoiler_title').click(function(){ // при клике по заголовку спойлера
                var show = $(this).attr('show'); // проверяем атрибут, в котором записано - отображен спойлер или скрыт
                if(show == 1){ // если отображен, то прячем
                    $(this).attr('show', 0);
                    $('#' + $(this).attr('data-block')).slideUp(300);
                }else{ // если спрятан, то показываем
                    $(this).attr('show', 1);
                    $('#' + $(this).attr('data-block')).slideDown(300);
                }
            });
        });
$(function(){

$.getScript('/template/js/jquery-ui.custom.min.js');

var __rand = function(min, max){
	return Math.round(Math.random() * (max - min - 1)) + min;
};

var apiUrl = '/api';

var __openCase = function(){
	$('.opencase-bottom-open').hide();
	var id = $('.opencase-bottom-open').attr("data-id");
	$.ajax({
		url: apiUrl,
		type: 'post',
		data: {case: id, action: 'openCase'},
		dataType: 'json',
		success: function(rdata){
			if('false' == rdata.result){
				console.log(id);
				switch(rdata.message){
					case 'no_money':
						$('.opencase-bottom-nofunds').show();
						swal("Oops...", "No money!", "error");

						break;
					case 'no_login':
						swal("Oops...", "Login to open case!", "error");
						setTimeout( function(){
							window.location.href = "/steam?login";
						}  , 1000 );

						break;
					case 'no_items':
							swal("Oops...", "Case is empty!", "error");
							setTimeout( function(){
								window.location.href = "/";
							}  , 1000 );
						break;
					case 'no_case':
										swal("Oops...", "Case is disabled!", "error");
    					break;
                    case 'stop_case':
    					swal("Oops...", "Case is disabled!", "error");
							setTimeout( function(){
								window.location.href = "/";
							}  , 1000 );
    					break;
				}
			} else {
					console.log(id);
				__buildLine(rdata);
			}
		}
	});
};

var __buildLine = function(data){
	$('.opencase-top-case, .opencase-bottom-open').hide();
	$('.opencase-top-carousel, .opencase-bottom-opening').show();


	$('.opencase-top-carousel-line').html('');

	$.each(data.items, function(_, v){
		if(v.color == "uncommon") v.color = "#305f8d";
		if(v.color == "milspec") v.color = "#3f50be";
		if(v.color == "restricted") v.color = "#7339bd";
		if(v.color == "classified") v.color = "#bb22b6";
		if(v.color == "covert") v.color = "#d43c39";
		if(v.color == "rare") v.color = "#ddb401";

		$('<div>')
		.addClass('opencase-top-carousel-line-item')
		.appendTo('.opencase-top-carousel-line')
		.append(
			$('<div>')
			.addClass('opencase-top-carousel-line-item-image')
			.css('background-image', 'url(' + v.image + ')')
		)
		.append(
			$('<div>')
			.addClass('opencase-top-carousel-line-item-text')
			.css('background-color', v.color)
			.append(
				$('<div>').html(v.name_first)
			)
			.append(
				$('<div>').html(v.name_second)
			)
		);
	});
$('.purse').html('Баланс: <span>'+data.balans+' <small>p</small></span>');
	var thing_win = data.items[data.win_slot];
	$('.opencase-opened-drop').html(thing_win.name_first + ' | ' + thing_win.name_second);
	$('.opencase-opened-image').css('background-image', 'url(' + thing_win.image + ')');

	var start = parseInt( $('.opencase-top-carousel-line').css('left') ),
		slot_width = $('.opencase-top-carousel-line-item').outerWidth(true),
		offset = (data.win_slot + Math.min(Math.max(Math.random(), .1), .9)) * slot_width ,
		position = 0,
		interval = setInterval(function(){
			var offset = parseInt( $('.opencase-top-carousel-line').css('left') ) - start,
				position_actual = Math.floor(offset / slot_width);

			if(position_actual !== position){
				//console.log('sound');
				var sound = $('audio#case_scroll')[0];
				sound.volume = 0.3;
				sound.pause();
				sound.currentTime = 0;
				sound.play();
			}
			position = position_actual;
		}, 10);

	$('audio#case_open')[0].volume = 0.3;
	$('audio#case_open')[0].play();

	$('.opencase-top-carousel-line')
	.css('left', '')
	.animate({ left: '-=' + offset }, 2500  * 2, 'easeOutQuad', function(){
		$('audio#item_reveal')[0].play();
		clearInterval(interval);

		$('.opencase-top-carousel, .opencase-bottom-opening').hide();
		$('.opencase-top-case, .opencase-bottom-open').show();

		$('.opencase-top, .opencase-bottom').hide();
		$('.opencase-opened').show();
		!function __last_drops(){
			$.ajax({
				url: apiUrl,
				type: 'post',
				data: {action: 'liveDrop', tlast: timelast},
				dataType: 'json',
				success: function(rdata){
					if('true' == rdata.result){
						timelast = rdata.timelast;
						var els_max = Math.floor($('.live-line').width() / $('.live-line-item').width());
						if(rdata.last_drops != null) {
							$.each(rdata.last_drops, function(_, v){
								$('.live-line > div').prepend(
									$('<a>')
									.attr('href', '/user/'+ v.steam +'')
									.addClass('item-history '+ v.rare +'')
								.append( '<img src=" ' + v.image + '" height="250" width="250">' )

									.css('display', 'none')
									.fadeIn(600)
								);
								$('.opened').html('<span>' + rdata.total.opened + '</span>')
								$('.regusers').html('<span>' + rdata.total.regusers + '</span>')
								$('.onusers').html('<span>' + rdata.total.onusers + '</span>')
							});
						}
					}
				}
			});
		}();
	});
	$(document).on('click', '.opencase-opened-actions-one.s__sell', function() {
		$('.opencase-opened').hide();
		$('.opencase-top, .opencase-bottom').show();
		$.ajax({
			url: '/api',
			type: 'post',
			data: {action: 'sellItem', item_id: data.info.item_id},
			dataType: 'json',
			success: function(rdata){
				if('true' == rdata.result){

				}
			}
		});
		setTimeout(
  function()
  {
  		window.location.href = '/user';
  }, 1000);

	});

//	kek = apiUrl+"?action=sellItem&item_id="+data.info.item_id;
	$('.opencase-opened-actions-one.s__sell')
	.children('.opencase-opened-actions-one-text')
		.html('Продать за ' + data.info.cost  + 'р');
	//$('.__inspect').attr('href', 'steam://rungame/' + data.info.ingame.ingame_appid + '/' + data.info.ingame.ingame_owner + '/+csgo_econ_action_preview%20' + data.info.ingame.ingame_hash);
};

$('.opencase-bottom-open').on('click', function(event){
	__openCase();

	event.preventDefault();
	return false;
});
$('.opencase-opened-actions-one.s__again').on('click', function(event){
	$('.opencase-opened').hide();
	$('.opencase-top, .opencase-bottom').show();

		window.location.reload();

});
!function __last_drops(){
	$.ajax({
		url: apiUrl,
		type: 'post',
		data: {action: 'liveDrop', tlast: timelast},
		dataType: 'json',
		success: function(rdata){
			if('true' == rdata.result){
				timelast = rdata.timelast;
				var els_max = Math.floor($('.live-line').width() / $('.live-line-item').width());
				if(rdata.last_drops != null) {
					$.each(rdata.last_drops, function(_, v){
						$('.live-line > div').prepend(
							$('<a>')
							.attr('href', '/user/'+ v.steam +'')
							.addClass('item-history '+ v.rare +'')
						.append( '<img src=" ' + v.image + '" height="250" width="250">' )

							.css('display', 'none')
							.fadeIn(600)
						);
						$('.opened').html('<span>' + rdata.total.opened + '</span>')
						$('.regusers').html('<span>' + rdata.total.regusers + '</span>')
						$('.onusers').html('<span>' + rdata.total.onusers + '</span>')
					});
				}
			}
		}
	});
}();

});
