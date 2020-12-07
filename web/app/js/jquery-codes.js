$(document).ready(function () {

	// SEARCH ANCHOR
//	$('#searchAnchor').on('click touchstart', function (e){
//		$('body').toggleClass('searchOpen');
//		$('body').removeClass('userOpen');
//		$('body').removeClass('alertOpen');
//		e.preventDefault();
//	});
//
//	// SEARCH SUGGESTIONS
//	$('#search form input').on('input',function(event) {
//		$('#search #suggests').addClass('open');
//
//		$('#search form input').on('focusout',function(event) {
//			$('#search #suggests').removeClass('open');
//		});
//
//		if ($(this).val() < 1){
//			$('#search #suggests').removeClass('open');
//		}
//
//	});

	// ALERT BOX ANCHOR
//	$('#alertsAnchor').on('click touchstart', function (e){
//		$('body').toggleClass('alertOpen');
//		$('body').removeClass('userOpen');
//		e.preventDefault();
//	});
//
//	// ALERT BOX CLOSE
//	$('.alertClose').on('click touchstart', function (e){
//		$('body').removeClass('alertOpen');
//		$('body').removeClass('userOpen');
//		e.preventDefault();
//	});

	// ACCOUNT BOX ANCHOR
//	$('#accountAnchor').on('click touchstart', function (e){
//		$('body').toggleClass('userOpen');
//		$('body').removeClass('alertOpen');
//		e.preventDefault();
//	});

	// ACCOUNT BOX CLOSE
//	$('.userBoxClose').on('click touchstart', function (e){
//		$('body').removeClass('userOpen');
//		$('body').removeClass('alertOpen');
//		e.preventDefault();
//	});

	// TOGGLE HISTORY
//	$('.userBox .history').on('click touchstart', function (e){
//		$(this).toggleClass('active');
//		e.preventDefault();
//	});

	// MENU ANCHOR
//	$('#menuAnchor').on('click touchstart', function (e){
//		$(this).toggleClass('open');
//		$('body').removeClass('searchOpen');
//		$('body').removeClass('userOpen');
//		$('body').removeClass('alertOpen');
//		$('body').toggleClass('menuOpen');
//		$('#closeMenu').toggleClass('open');
//		$('nav#menu > ul > li.has-children').removeClass('open');
//		setTimeout(function() {
//			$('#closeMenu').toggleClass('opacity');
//		}, 15);
//		e.preventDefault();
//	});

	// CLOSE MENU
//	$('#closeMenu').on('click', function (e){
//		$('#menuAnchor').toggleClass('open');
//		$('body').removeClass('searchOpen');
//		$('nav#menu > ul > li.has-children').removeClass('open');
//		$('body').toggleClass('menuOpen');
//		$('#closeMenu').toggleClass('open');
//		setTimeout(function() {
//			$('#closeMenu').toggleClass('opacity');
//		}, 15);
//		e.preventDefault();
//	});
//	$('nav#menu .close').on('click', function (e){
//		$('nav#menu > ul > li.has-children').removeClass('open');
//		e.preventDefault();
//	});

	// AGENDA TABS
//	$('.agenda .tabs a').on('click', function (e){
//
//		$('.agenda .tabs a').removeClass('active');
//		$(this).addClass('active');
//
//		var link = $(this).attr('href');
//		var item = '.tabContent'+link+'Item';
//		// alert(item);
//
//		$('.tabContent').removeClass('active');
//		$(item).addClass('active');
//
//		e.preventDefault();
//	});
//
//	// SUBMENU OPEN
//	$('nav#menu > ul > li.has-children > ul > li.has-children').on('click', function (e){
//		$(this).toggleClass('open');
//		e.preventDefault();
//	});
//
//	// MENU MOBILE click
//	$('nav#menu > ul > li.has-children.agend > a').on('click', function (e){
//		$('nav#menu > ul > li.has-children').not('.agend').removeClass('open');
//		$(this).parent().toggleClass('open');
//		e.preventDefault();
//	});
//	$('nav#menu > ul > li.has-children.alerts > a').on('click', function (e){
//		$('nav#menu > ul > li.has-children').not('.alerts').removeClass('open');
//		$(this).parent().toggleClass('open');
//		e.preventDefault();
//	});
//	$('nav#menu > ul > li.has-children.account > a').on('click', function (e){
//		$('nav#menu > ul > li.has-children').not('.account').removeClass('open');
//		$(this).parent().toggleClass('open');
//		e.preventDefault();
//	});
//	$('nav#menu > ul > li.has-children.cats > a').on('click', function (e){
//		$('nav#menu > ul > li.has-children').not('.cats').removeClass('open');
//		$(this).parent().toggleClass('open');
//		e.preventDefault();
//	});
//
//	// CLOSE SEARCH
//	$('main').not('#searchAnchor').on('click', function (e){
//		$('body').removeClass('searchOpen');
//	});
//	
//	// SCROLL TO TOP
//  $(function () {
//    $(window).scroll(function () {
//      if ($(this).scrollTop() > 150) {
//          $('#toTop').fadeIn();
//      } else {
//          $('#toTop').fadeOut();
//      }
//    });
//  });
//	var $doc = $('html, body');
//	$('#toTop').click(function() {
//	    $doc.animate({
//	        scrollTop: $("body").offset().top
//	    }, 500);
//	    return false;
//	});
//
//	$(window).bind("load", function(){
//		$('#preLoad').hide('600');
//		setTimeout(function() {
//			$('#preLoad').remove();
//		}, 1000);
//	});
//	setTimeout(function() {
//		$('#preLoad .status button').show();
//	}, 10000);

	// PREVENT SCROLL
	// window.blockMenuHeaderScroll = false;
	// $('.owl-carousel').on('touchstart', function(e) {
 //  	blockMenuHeaderScroll = true;
 //  });
	// $('.owl-carousel').on('touchend', function() {
 //    blockMenuHeaderScroll = false;
	// });
	// $('.owl-carousel').on('touchmove', function(e) {
 //    if (blockMenuHeaderScroll) {
 //    	e.preventDefault();
 //    }
	// });

});