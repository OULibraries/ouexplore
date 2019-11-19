var step = 1;

$( document ).ready( function(){

	//  Animate Intro Text

		setTimeout( function(){
			$('.introBannerTop').addClass('reveal');
		}, 600 );
	
		setTimeout( function(){
			$('.introBannerMiddle > div:nth-of-type(1)').addClass('reveal');
		}, 1000 );

		setTimeout( function(){
			$('.introBannerTop').addClass('exit');
		}, 4000 );
		
		setTimeout( function(){
			$('.introBannerMiddle > div:nth-of-type(1)').addClass('exit');
		}, 4300 );

		setTimeout( function(){
			$('.introBannerMiddle > div:nth-of-type(2)').addClass('reveal');
		}, 5200 );

		setTimeout( function(){
			$('.introBannerBottom').addClass('reveal');
		}, 5500 );

		setTimeout( function(){
			$('.logo, nav > div, #intro').addClass('reveal');
		}, 7000 );

		setTimeout( function(){
			$('.continue').addClass('reveal');
			$('.continue').css({
				'animation':'pulse 4s infinite'
			})
		}, 8000 );

	//  Load Pillars

		$( document ).on( 'click', '[data-action="loadPillars"]', function(e){

			// Remove intro content
			$('.introBannerMiddle > div:nth-of-type(2), #intro').addClass('exit');
			$('.continue').removeClass('reveal');
			setTimeout( function(){
				$('.introBannerBottom').addClass('exit');
			}, 600 );

			// Load pillar content
			setTimeout( function(){
				$.ajax({
					url: 'tpl/tpl-pillars.php',
					dataType: 'html'
				}).done( function( data ){
					$('[role="main"]').html( data );
					setTimeout( function(){	
						var imgURL = $('.pillars > div:nth-of-type('+step+')').find('img').attr('src');
						$('.wrapper .bg').css({ 'background': 'url("'+imgURL+'") no-repeat center center / cover' });
						$('.wrapper, .bg').addClass('reveal');
					}, 300 );
					setTimeout( function(){	
						$('.leftBorder, .rightBorder, .topBorder, .bottomBorder').show();
					}, 2000 );
					setTimeout( function(){	
						$('.pillars > div:nth-of-type(1)').addClass('active');
						$('.pillars').css({ 'transform' : 'translate3d(-50%, -50%, 0 ) rotate(-47deg)' });
					}, 1500 );
				});
			}, 1600 );
			

			e.preventDefault();
		});

	//  Load highlight

		$( document ).on( 'click', '.highlightItem a', function(e){

			
			var storyImage = $(this).parents('.highlightItem').find('img').attr('src');
			var storyTitle = $(this).parents('.highlightItem').find('h3').html();
			var storyBody  = $(this).parents('.highlightItem').find('.body').html();

			$('#sidebar .content').empty();
			$('#sidebar img').attr( 'src', storyImage );
			$('#sidebar .content').append( '<h3>'+storyTitle+'</h3>' + storyBody );

			$('.overlay, #sidebar').addClass('reveal');
			e.preventDefault();
		});

		$( document ).on( 'click', '#sidebar .close, .overlay', function(e){
			$('.overlay, #sidebar').removeClass('reveal');
			e.preventDefault();
		});

	//  Open / Close Menu

		$( document ).on( 'click', '[data-action="openMenu"]', function(e){
			$('.menu').addClass('reveal');
			e.preventDefault();
		});

		$( document ).on( 'click', '.menu .close', function(e){
			$('.menu').removeClass('reveal');
			e.preventDefault();
		});

	//  Animate Bg on scroll

		$(window).scroll( function(){
			var scrollPos = $(this).scrollTop();
			var bgScrollPos = scrollPos * 0.5;
			$('.bg').css({
				'transform' : 'translate3d(0,'+bgScrollPos+'px,0) scale(1)'
			});
		});

	//  Move Scroller via mousewheel
	
		$( document ).on( 
			'mousewheel', 
			$.throttle( 1500, true, function(event) {
				if( !$('body').hasClass('unlocked') && !$('.introBannerMiddle').length ){
					cyclePillars( event.deltaY );
				}
			}    
		));

	//  Move Scroller via mousewheel
	
		$( document ).on( 
			'mousewheel', 
			$.throttle( 1500, true, function(event) {
				if( $('.introBannerMiddle > div:nth-of-type(2)').hasClass('reveal') ){
					$('[data-action="loadPillars"]').click();
				}
			}    
		));
	
	//  Open Pillar Content
	
		// $( document ).on( 'click', '.pillars > div > a, .pillarTitles', function(e){
		// 	$('.pillars, .pillarTitles').addClass('minimize');
		// 	$('.logo, nav > div').removeClass('reveal');
		// 	$('.wrapper, .bg').addClass('exit');
		// 	setTimeout( function(){
		// 		$('.back, article').addClass('reveal');
		// 		$('html, body').addClass('unlocked');
		// 	}, 1000);
		// 	e.preventDefault();
		// });

		//  Fetch pillar contents on click

		$( document ).on( 'click', '[data-action="openPillar"]', function(e){

			$('.pillars, .pillarTitles').addClass('minimize');
			$('.logo, nav > div').removeClass('reveal');
			$('.wrapper, .bg').addClass('exit');
			$('html, body').addClass('unlocked');
			
			var pillarID = $(this).attr('data-pillar-id');
			$.ajax({
				url: 'models/json.php',
				data:{
					nid: pillarID
				},
				dataType: 'json'
			}).done( function( data ){
				
				// display description
				$('#opening .container').html( data.description );
				
				// display stats
				$('#stats').empty();
				$.each( data.stats, function( key, stat ){
					$('#stats').append('<div><figure>'+stat.number+'</figure><figcaption>'+stat.label+'</figcaption></div>');
				});

				// display highlights
				$('#highlights').empty();
				$.each( data.stories, function( key, story ){
					$('#highlights').append(
						'<div class="highlightItem">'+
							'<a href="#"><img src="'+story.image+'" /></a>'+
							'<div>'+
								'<h3>'+story.title+'</h3>'+
								'<a href="#" data-id="'+story.id+'">Read More</a>'+
							'</div>'+
							'<div class="body" style="text-indent: -9999px; position: absolute; visibility: hidden;>'+
								story.body+
							'</div>'+
						'</div>'
					);
				});

				//  Reveal content
				$('.back, article').addClass('reveal');
			});
			e.preventDefault();
		});
	
	//  Close Pillar Content

		$( document ).on( 'click', '.back', function(e){

			$('html, body').animate({ scrollTop: 0 }, 'slow', function () {
				$('.back, article').removeClass('reveal');
				setTimeout( function(){
					$('html, body').removeClass('unlocked');
					$('.wrapper, .bg').removeClass('exit');
					$('.pillars, .pillarTitles').removeClass('minimize');
					$('.logo, nav > div').addClass('reveal');
				}, 600);	
			});
			e.preventDefault();
		});

	//  Load Templates from links
		
		$( document ).on( 'click', 'a[href="#contribute"]', function(e){
			$.ajax({
				url: 'tpl/tpl-contribute.php',
				dataType: 'html'
			}).done( function( data ){
				$('[role="main"]').html( data );
				$('html, body').addClass('unlocked');
				$('.menu').removeClass('reveal');
			});
			e.preventDefault();
		});

		$( document ).on( 'click', 'a[href="#contact"]', function(e){
			$.ajax({
				url: 'tpl/tpl-contact.php',
				dataType: 'html'
			}).done( function( data ){
				$('[role="main"]').html( data );
				$('html, body').addClass('unlocked');
				$('.menu').removeClass('reveal');
			});
			e.preventDefault();
		});

		$( document ).on( 'click', 'a[href="#issues"]', function(e){
			$.ajax({
				url: 'tpl/tpl-issues.php',
				dataType: 'html'
			}).done( function( data ){
				$('[role="main"]').html( data );
				$('html, body').addClass('unlocked');
				$('.menu').removeClass('reveal');
			});
			e.preventDefault();
		});

		$( document ).on( 'click', 'a[href="#publications"]', function(e){
			$.ajax({
				url: 'tpl/tpl-publications.php',
				dataType: 'html'
			}).done( function( data ){
				$('[role="main"]').html( data );
				$('html, body').addClass('unlocked');
				$('.menu').removeClass('reveal');
			});
			e.preventDefault();
		});
		

	//  Functions

		function cyclePillars( deltaY ){
			var currentStep = step;
			
			if( deltaY < 0 ){
				if( step == 5 ){
					step = 1;
				} else {
					step++;
				}
			} 
			if( deltaY > 0 ){
				if( step == 1 ){
					step = 5;
				} else {
					step--;
				}
			}  
			
			$('.pillars > div').removeClass('active');
			$('.pillars > div:nth-of-type('+step+')').addClass('active');

			var imgURL = $('.pillars > div:nth-of-type('+step+')').find('img').attr('src');
			
			// console.log( step );
			// console.log( imgURL );
			
			if( step == 1 ){
				$('.pillars').css({ 'transform' : 'translate3d(-50%, -50%, 0 ) rotate(-47deg)' });
				$('.pillarTitles > div').css({ 'transform' : 'translate3d( 0, 0, 0 )' });
				$('.wrapper .bg').css({ 'background': 'url("'+imgURL+'") no-repeat center center / cover' });
				//step++;
			} else if ( step == 2){
				$('.pillars').css({ 'transform': 'translate3d(-50%, -50%, 0 ) rotate(-87deg)' });
				$('.pillarTitles > div').css({ 'transform' : 'translate3d( -100vw, 0, 0 )' });
				$('.wrapper .bg').css({ 'background': 'url("'+imgURL+'") no-repeat center center / cover' });
				//step++;
			} else if ( step == 3){
				$('.pillars').css({ 'transform': 'translate3d(-50%, -50%, 0 ) rotate(-127deg)' });
				$('.pillarTitles > div').css({ 'transform' : 'translate3d( -200vw, 0, 0 )' });
				$('.wrapper .bg').css({ 'background': 'url("'+imgURL+'") no-repeat center center / cover' });
				//step++;
			} else if ( step == 4){
				$('.pillars').css({ 'transform': 'translate3d(-50%, -50%, 0 ) rotate(-167deg)' });
				$('.pillarTitles > div').css({ 'transform' : 'translate3d( -300vw, 0, 0 )' });
				$('.wrapper .bg').css({ 'background': 'url("'+imgURL+'") no-repeat center center / cover' });
				//step++;
			} else if ( step == 5){
				$('.pillars').css({ 'transform': 'translate3d(-50%, -50%, 0 ) rotate(-207deg)' });
				$('.pillarTitles > div').css({ 'transform' : 'translate3d( -400vw, 0, 0 )' });
				$('.wrapper .bg').css({ 'background': 'url("'+imgURL+'") no-repeat center center / cover' });
				//step = 0;
			}
		}

});




		

