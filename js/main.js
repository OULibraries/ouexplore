var step = 1;

$(document).ready(function () {
	// hide and show the mouse/touch icons based on touch device or not.
	if (is_touch_device4()) { //is touch device
		$('#mouse_icon').addClass('img_hidden');
		$('#touch_icon').removeClass('img_hidden');

		alert(screen.width+" x "+screen.height);

		// move "start scrolling" indicator up a bit for mobile devices in portrait mode.
		if (screen.height > screen.width) { //portrait
				if (screen.width < 1000) { //phones
					$('.continue').css('bottom', '14rem');
					$('.continue').css('font-size', '3rem');
					$('#touch_icon').css('width', '5rem');
					$('#touch_icon').css('margin', '2rem auto 0rem');
				} else { // tablet
					$('.continue').css('bottom', '20em');
				}
		} else { //landscape
			if (screen.width > 1000) { //tablet
				$('.continue').css('bottom', '12em');
			}
		}
	} else { // not touch device
		$('#mouse_icon').removeClass('img_hidden');
		$('#touch_icon').addClass('img_hidden');
	}

	//  Animate Intro Text
	setTimeout(function () {
		$('.introBannerTop').addClass('reveal');
	}, 600);

	setTimeout(function () {
		$('.introBannerMiddle > div:nth-of-type(1)').addClass('reveal');
	}, 1000);

	setTimeout(function () {
		$('.introBannerTop').addClass('exit');
	}, 4000);

	setTimeout(function () {
		$('.introBannerMiddle > div:nth-of-type(1)').addClass('exit');
	}, 4300);

	setTimeout(function () {
		$('.introBannerMiddle > div:nth-of-type(2)').addClass('reveal');
	}, 5200);

	setTimeout(function () {
		$('.introBannerBottom').addClass('reveal');
	}, 5500);

	setTimeout(function () {
		$('.logo, nav > div, #intro').addClass('reveal');
	}, 7000);
	
	setTimeout( function(){
		$('.continue').addClass('reveal');
		$('.continue').css({
			'animation':'pulse 4s infinite'
		});
	}, 8000 );

	setTimeout( function(){
		$('.continue').addClass('reveal');
		$('.continue').css({
			'animation':'pulse 4s infinite'
		});
	}, 8000 );

	//  Load Pillars
	$('.continue').on('click', function (e) {
		// Remove intro content
		$('.introBannerMiddle > div:nth-of-type(2), #intro').addClass('exit');
		$('.continue').removeClass('reveal');
		setTimeout(function () {
			$('.introBannerBottom').addClass('exit');
		}, 600);

		// Load pillar content
		//setTimeout(function () {
			$.ajax({
				url: 'tpl/tpl-pillars.php',
				dataType: 'html'
			}).done(function (data) {
				$('[role="main"]').html(data);
				setTimeout(function () {
					var imgURL = $('.pillars > div:nth-of-type(' + step + ')').find('img').attr('src');
					$('.wrapper .bg').css({'background': 'url("' + imgURL + '") no-repeat center center / cover'});
					$('.wrapper, .bg').addClass('reveal');
				}, 300);
				setTimeout(function () {
					$('.leftBorder, .rightBorder, .topBorder, .bottomBorder').show();
				}, 2000);
				setTimeout(function () {
					$('.pillars > div:nth-of-type(1)').addClass('active');
					$('.pillars').css({'transform': 'translate3d(-50%, -50%, 0 ) rotate(-47deg)'});
				}, 1500);
			});
		//}, 1600);
		//e.preventDefault();
	});

	//  Open / Close Menu
	$('.open_menu').on('click', function (e) {
		//e.preventDefault();
		$('.menu').addClass('reveal');
	});

	$('.menu a.close').on('click', function (e) {
		$('.menu').removeClass('reveal');
	});

	$( document ).on( 'click', '.highlightItem a', function(){
		var storyImage = $(this).parents('.highlightItem').find('img').attr('src');
		var storyTitle = $(this).parents('.highlightItem').find('h3').html();
		var storyBody  = $(this).parents('.highlightItem').find('.body').html();
		var storyDescription = $(this).parents('.highlightItem').find('.fullDescription').html();
		//console.log('story body: ' + storyImage);
		$('#sidebar .content').empty();
		$('#sidebar img').attr( 'src', storyImage );
		$('#sidebar .content').append( '<h3>'+storyTitle+'</h3>' + storyBody + storyDescription);

		$('.overlay, #sidebar').addClass('reveal');
		// e.preventDefault();
	});

	$( document ).on( 'click', '#sidebar .close, .overlay', function(){
		$('.overlay, #sidebar').removeClass('reveal');
		// e.preventDefault();
	});

	$(document).on('mousewheel', $.throttle(1500, true, function (event) {
		if (!$('body').hasClass('unlocked') && !$('.introBannerMiddle').length) {
			cyclePillars(event.deltaY);
		}
		if ($('.introBannerMiddle > div:nth-of-type(2)').hasClass('reveal')) {
			$('[data-action="loadPillars"]').click();
		}
	}));

	$('.explore_home').on("click", function (e) {
		location.reload();
	});

	// when pillar is clicked on desktop. Calls pillars function to open the pillar in the center of the view.
	$(document).on( 'click', '[data-action="openPillar"]', function(e){
		if ($('.main_container div.wrapper').hasClass('reveal') === true) {
			var pillarID = $('.pillars div.active a').data('pillar-id');
			openPillarPage(pillarID);
		}
	});
	
	// listener for touch events. Used for swipes on mobile devices.
	var el = document.getElementsByClassName("main_container")[0];
	ontouch(el, function (evt, dir, phase, swipetype, distance) {
		var deltaY;
		// when touch has ended
		if (phase == 'end') {
			// only run this section if the pillar selection page is up
			if (!$('body').hasClass('unlocked') && !$('.introBannerMiddle').length) {
				var deltaY;

				if (dir == 'right' || dir == 'down') {
					deltaY = 1;
				}
				else if (dir == 'left' || dir == 'up') {
					deltaY = -1;
				}
				else {
					deltaY = 0;
				}

				// if swiped
				if (deltaY != 0) {
					cyclePillars(deltaY);
				} else { // 0 is a click with no movement. Choose pillar
					if ($('.main_container div.wrapper').hasClass('reveal') === true) {
						var pillarID = $('.pillars div.active a').data('pillar-id');
						openPillarPage(pillarID);
					}
				}
			}

			// swipe up event for intro page
			if ($('.introBannerMiddle > div:nth-of-type(2)').hasClass('reveal') && swipetype == 'up') {
				$('[data-action="loadPillars"]').click();
			}
		}
		//}
	});

	//  Close Pillar Content
	$('.back').on('click', function (e) {
		$('html, body').animate({scrollTop: 0}, 'slow', function () {
			$('.back, article').removeClass('reveal');
			setTimeout(function () {
				$('html, body').removeClass('unlocked');
				$('.wrapper, .bg').removeClass('exit');
				$('.pillars, .pillarTitles').removeClass('minimize');
				$('.logo, nav > div').addClass('reveal');
			}, 600);
		});
		//e.preventDefault();
	});

	//  Load Templates from links
	$(document).on('click', '#contribution', function (e) {
		$.ajax({
			url: 'tpl/tpl-contribute.php',
			dataType: 'html'
		}).done(function (data) {
			$('[role="main"]').html(data);
			$('html, body').addClass('unlocked');
			$('.menu').removeClass('reveal');
		});
		e.preventDefault();
	});

	$('#contacted').on('click', function (e) {
		$.ajax({
			url: 'tpl/tpl-contact.php',
			dataType: 'html'
		}).done(function (data) {
			$('[role="main"]').html(data);
			$('html, body').addClass('unlocked');
			$('.menu').removeClass('reveal');
		});
		//e.preventDefault();
	});

	$('a[href="#issues"]').on('click', function (e) {
		$.ajax({
			url: 'tpl/tpl-issues.php',
			dataType: 'html'
		}).done(function (data) {
			$('[role="main"]').html(data);
			$('html, body').addClass('unlocked');
			$('.menu').removeClass('reveal');
		});
		//e.preventDefault();
	});

	$('a[href="#publications"]').on('click', function (e) {
		$.ajax({
			url: 'tpl/tpl-publications.php',
			dataType: 'html'
		}).done(function (data) {
			$('[role="main"]').html(data);
			$('html, body').addClass('unlocked');
			$('.menu').removeClass('reveal');
		});
		//e.preventDefault();
	});

	//  Functions
	function cyclePillars(deltaY) {
		var currentStep = step;

		if (deltaY <= 0) {
			if (step == 5) {
				step = 1;
			}
			else {
				step++;
			}
		}
		if (deltaY > 0) {
			if (step == 1) {
				step = 5;
			}
			else {
				step--;
			}
		}

		$('.pillars > div').removeClass('active');
		$('.pillars > div:nth-of-type(' + step + ')').addClass('active');

		var imgURL = $('.pillars > div:nth-of-type(' + step + ')').find('img').attr('src');

		// console.log( step );
		// console.log( imgURL );

		if (step == 1) {
			$('.pillars').css({'transform': 'translate3d(-50%, -50%, 0 ) rotate(-47deg)'});
			$('.pillarTitles > div').css({'transform': 'translate3d( 0, 0, 0 )'});
			$('.wrapper .bg').css({'background': 'url("' + imgURL + '") no-repeat center center / cover'});
			//step++;
		}
		else if (step == 2) {
			$('.pillars').css({'transform': 'translate3d(-50%, -50%, 0 ) rotate(-87deg)'});
			$('.pillarTitles > div').css({'transform': 'translate3d( -100vw, 0, 0 )'});
			$('.wrapper .bg').css({'background': 'url("' + imgURL + '") no-repeat center center / cover'});
			//step++;
		}
		else if (step == 3) {
			$('.pillars').css({'transform': 'translate3d(-50%, -50%, 0 ) rotate(-127deg)'});
			$('.pillarTitles > div').css({'transform': 'translate3d( -200vw, 0, 0 )'});
			$('.wrapper .bg').css({'background': 'url("' + imgURL + '") no-repeat center center / cover'});
			//step++;
		}
		else if (step == 4) {
			$('.pillars').css({'transform': 'translate3d(-50%, -50%, 0 ) rotate(-167deg)'});
			$('.pillarTitles > div').css({'transform': 'translate3d( -300vw, 0, 0 )'});
			$('.wrapper .bg').css({'background': 'url("' + imgURL + '") no-repeat center center / cover'});
			//step++;
		}
		else if (step == 5) {
			$('.pillars').css({'transform': 'translate3d(-50%, -50%, 0 ) rotate(-207deg)'});
			$('.pillarTitles > div').css({'transform': 'translate3d( -400vw, 0, 0 )'});
			$('.wrapper .bg').css({'background': 'url("' + imgURL + '") no-repeat center center / cover'});
			//step = 0;
		}
	}
});

function ontouch(el, callback) {
	var touchsurface = el,
		dir,
		swipeType,
		startX,
		startY,
		distX,
		distY,
		threshold = 150, //required min distance traveled to be considered swipe
		restraint = 100, // maximum distance allowed at the same time in
										 // perpendicular direction
		allowedTime = 500, // maximum time allowed to travel that distance
		elapsedTime,
		startTime,
		handletouch = callback || function (evt, dir, phase, swipetype, distance) {
		}

	touchsurface.addEventListener('touchstart', function (e) {
		// ignore some touch events if done on form page, on buttons, and on links.
		if (
			(e.target.matches('.form-group, .form-group *') && e.target.parentElement.className == 'form-group') ||
			$(this).children(1).hasClass('exit') ||
			$(this).children(1).prop('id') == 'contribute' ||
			(e.target.matches('#contactsubmit, #contactsubmit *') && e.target.parentElement.id == 'contactsubmit') ||
			(e.target.matches('#contact, #contact *') &&
				(e.target.parentElement.id == 'contact' ||
				e.target.parentElement.parentElement.id == 'contact' ||
				e.target.parentElement.parentElement.parentElement.id == 'contact' ||
				e.target.parentElement.parentElement.parentElement.parentElement.id == 'contact')
			)
		) {
			return false;
		}
		var touchobj = e.changedTouches[0]
		dir = 'none'
		swipeType = 'none'
		dist = 0
		startX = touchobj.pageX
		startY = touchobj.pageY
		startTime = new Date().getTime() // record time when finger first makes
																		 // contact with surface
		handletouch(e, 'none', 'start', swipeType, 0) // fire callback function
																									// with params dir="none",
																									// phase="start",
																									// swipetype="none" etc
		e.preventDefault();
	}, {passive: false})

	touchsurface.addEventListener('touchmove', function (e) {
		// ignore some touch events if done on form page, on buttons, and on links.
		if (
			(e.target.matches('.form-group, .form-group *') && e.target.parentElement.className == 'form-group') ||
			$(this).children(1).hasClass('exit') ||
			$(this).children(1).prop('id') == 'contribute' ||
			(e.target.matches('#contactsubmit, #contactsubmit *') && e.target.parentElement.id == 'contactsubmit') ||
			(e.target.matches('#contact, #contact *') &&
				(e.target.parentElement.id == 'contact' ||
					e.target.parentElement.parentElement.id == 'contact' ||
					e.target.parentElement.parentElement.parentElement.id == 'contact' ||
					e.target.parentElement.parentElement.parentElement.parentElement.id == 'contact')
			)
		) {
			return false;
		}
		var touchobj = e.changedTouches[0]
		distX = touchobj.pageX - startX // get horizontal dist traveled by finger
																		// while in contact with surface
		distY = touchobj.pageY - startY // get vertical dist traveled by finger
																		// while in contact with surface
		if (Math.abs(distX) > Math.abs(distY)) { // if distance traveled horizontally is greater than vertically, consider
			// this a horizontal movement
			dir = (distX < 0) ? 'left' : 'right'
			handletouch(e, dir, 'move', swipeType, distX) // fire callback function
																										// with params
																										// dir="left|right",
																										// phase="move",
																										// swipetype="none" etc
		}
		else { // else consider this a vertical movement
			dir = (distY < 0) ? 'up' : 'down'
			handletouch(e, dir, 'move', swipeType, distY) // fire callback function
																										// with params
																										// dir="up|down",
																										// phase="move",
																										// swipetype="none" etc
		}
		e.preventDefault(); // prevent scrolling when inside DIV
	}, {passive: false})

	touchsurface.addEventListener('touchend', function (e) {
		// ignore some touch events if done on form page, on buttons, and on links.
		if (
			(e.target.matches('.form-group, .form-group *') && e.target.parentElement.className == 'form-group') ||
			$(this).children(1).hasClass('exit') ||
			$(this).children(1).prop('id') == 'contribute' ||
			(e.target.matches('#contactsubmit, #contactsubmit *') && e.target.parentElement.id == 'contactsubmit') ||
			(e.target.matches('#contact, #contact *') &&
				(e.target.parentElement.id == 'contact' ||
					e.target.parentElement.parentElement.id == 'contact' ||
					e.target.parentElement.parentElement.parentElement.id == 'contact' ||
					e.target.parentElement.parentElement.parentElement.parentElement.id == 'contact')
			)
		) {
			return false;
		}
		var touchobj = e.changedTouches[0]
		elapsedTime = new Date().getTime() - startTime // get time elapsed
		if (elapsedTime <= allowedTime) { // first condition for awipe met
			if (Math.abs(distX) >= threshold && Math.abs(distY) <= restraint) { // 2nd condition for horizontal swipe met
				swipeType = dir // set swipeType to either "left" or "right"
			}
			else if (Math.abs(distY) >= threshold && Math.abs(distX) <= restraint) { // 2nd condition for vertical swipe met
				swipeType = dir // set swipeType to either "top" or "down"
			}
		}
		// Fire callback function with params dir="left|right|up|down",
		// phase="end", swipetype=dir etc:
		handletouch(e, dir, 'end', swipeType, (dir == 'left' || dir == 'right') ? distX : distY)
		e.preventDefault();
	}, {passive: false})
}

// test if touch device
function is_touch_device4() {
	var prefixes = ' -webkit- -moz- -o- -ms- '.split(' ');
	var mq = function (query) {
		return window.matchMedia(query).matches;
	}
	if (('ontouchstart' in window) || window.DocumentTouch && document instanceof DocumentTouch) {
		return true;
	}
	// include the 'heartz' as a way to have a non matching MQ to help terminate
	// the join https://git.io/vznFH
	var query = ['(', prefixes.join('touch-enabled),('), 'heartz', ')'].join('');
	return mq(query);
}

// open pillar by id passed in
function openPillarPage (pillarID) {
	$('.pillars, .pillarTitles').addClass('minimize');
	$('.logo, nav > div').removeClass('reveal');
	$('.wrapper, .bg').addClass('exit');
	$('html, body').addClass('unlocked');

	$.ajax({
		url: 'models/json.php',
		data: {
			nid: pillarID
		},
		dataType: 'json'
	}).done(function (data) {
		//console.log('All data: ', data);
		// move white section in pillar page up a bit for mobile devices in portrait mode.
		if (is_touch_device4() && screen.height > screen.width && screen.width < 1000) {
			$('#opening').css('margin', '-25rem auto 0');
			$('.back').css('font-size', '7rem');
			$('.back').css('width', '10rem');
			$('.back').css('height', '10rem');
			$('.back').css('margin-top', '2rem');
		}
		
		// display description
		$('#opening .container').html(data.description);

		// display stats
		$('#stats').empty();
		$.each(data.stats, function (key, stat) {
			$('#stats').append('<div><figure>' + stat.number + '</figure><figcaption>' + stat.label + '</figcaption></div>');
		});

		// display highlights
		$('#highlights').empty();
		$.each(data.stories, function (key, story) {
			//console.log(story);
			$('#highlights').append(
				'<div class="highlightItem">' +
				'<a><img src="' + story.image + '" alt="image for ' + story.title + '"/></a>' +
				'<div>' +
				'<h3>' + story.title + '</h3>' +
				'<a data-id="' + story.id + '">Read This Story</a>' +
				'</div>' +
				'<div class="body" style="text-indent: -9999px; position: absolute; visibility: hidden;">' +
				story.body +
				'</div>' +
				'<hr>' +
				'<div class="fullDescription" style="text-indent: -9999px; position: absolute; visibility: hidden;">' +
				'<hr>' +
				'<br>' +
				story.description +
				'</div>' +
				'<div class="moreImages" style="text-indent: -9999px; position: absolute; visibility: hidden;">' +
				'</div>' +
				'</div>'
			);
		});

		$('#highlights').append(
			'<a class="read-articles" href="https://libraries.ou.edu/stories">View more examples of the Libraries' + "\'" + ' impact</a>'
		);

		//  Reveal content
		$('.back, article').addClass('reveal');
	});
}
