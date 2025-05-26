(function ($) {
	"use strict";

/*=============================================
	=    		 Preloader			      =
=============================================*/
function preloader() {
	$('#preloader').delay(0).fadeOut();
};

$(window).on('load', function () {
	preloader();
	mainSlider();
	wowAnimation();
	aosAnimation();
	tg_title_animation();
});



/*=============================================
	=    		Mobile Menu			      =
=============================================*/
//SubMenu Dropdown Toggle
if ($('.menu-area li.menu-item-has-children ul').length) {
	$('.menu-area .navigation li.menu-item-has-children').append('<div class="dropdown-btn"><span class="fas fa-angle-down"></span></div>');

}

//Mobile Nav Hide Show
if ($('.mobile-menu').length) {

	var mobileMenuContent = $('.menu-area .main-menu').html();
	$('.mobile-menu .menu-box .menu-outer').append(mobileMenuContent);

	//Dropdown Button
	$('.mobile-menu li.menu-item-has-children .dropdown-btn').on('click', function () {
		$(this).toggleClass('open');
		$(this).prev('ul').slideToggle(300);
	});
	//Menu Toggle Btn
	$('.mobile-nav-toggler').on('click', function () {
		$('body').addClass('mobile-menu-visible');
	});

	//Menu Toggle Btn
	$('.menu-backdrop, .mobile-menu .close-btn').on('click', function () {
		$('body').removeClass('mobile-menu-visible');
	});
}



/*=============================================
	=     Menu sticky & Scroll to top      =
=============================================*/
$(window).on('scroll', function () {
	var scroll = $(window).scrollTop();
	if (scroll < 245) {
		$("#sticky-header").removeClass("sticky-menu");
        $('.scroll-to-target').removeClass('open');
		$("#header-fixed-height").removeClass("active-height");

	} else {
		$("#sticky-header").addClass("sticky-menu");
        $('.scroll-to-target').addClass('open');
		$("#header-fixed-height").addClass("active-height");
	}
});


/*=============================================
	=    		 Scroll Up  	         =
=============================================*/
if ($('.scroll-to-target').length) {
  $(".scroll-to-target").on('click', function () {
    var target = $(this).attr('data-target');
    // animate
    $('html, body').animate({
      scrollTop: $(target).offset().top
    }, 1000);

  });
}


/*=============================================
	=            Header Search            =
=============================================*/
$(".header-search > a").on('click', function () {
	$(".search-popup-wrap").slideToggle();
	return false;
});

$(".search-close").on('click', function () {
	$(".search-popup-wrap").slideUp(500);
});


/*=============================================
=     Offcanvas Menu      =
=============================================*/
$(".menu-tigger").on("click", function () {
	$(".extra-info,.offcanvas-overly").addClass("active");
	return false;
});
$(".menu-close,.offcanvas-overly").on("click", function () {
	$(".extra-info,.offcanvas-overly").removeClass("active");
});



/*=============================================
	=          Data Background               =
=============================================*/
$("[data-background]").each(function () {
	$(this).css("background-image", "url(" + $(this).attr("data-background") + ")")
})


/*=============================================
	=    		 Main Slider		      =
=============================================*/
function mainSlider() {
	var BasicSlider = $('.slider-active');
	BasicSlider.on('init', function (e, slick) {
		var $firstAnimatingElements = $('.single-slider:first-child').find('[data-animation]');
		doAnimations($firstAnimatingElements);
	});
	BasicSlider.on('beforeChange', function (e, slick, currentSlide, nextSlide) {
		var $animatingElements = $('.single-slider[data-slick-index="' + nextSlide + '"]').find('[data-animation]');
		doAnimations($animatingElements);
	});
	BasicSlider.slick({
		autoplay: false,
		autoplaySpeed: 10000,
		dots: false,
		fade: true,
		arrows: false,
		responsive: [
			{ breakpoint: 767, settings: { dots: false, arrows: false } }
		]
	});

	function doAnimations(elements) {
		var animationEndEvents = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
		elements.each(function () {
			var $this = $(this);
			var $animationDelay = $this.data('delay');
			var $animationType = 'animated ' + $this.data('animation');
			$this.css({
				'animation-delay': $animationDelay,
				'-webkit-animation-delay': $animationDelay
			});
			$this.addClass($animationType).one(animationEndEvents, function () {
				$this.removeClass($animationType);
			});
		});
	}
}


/*=============================================
	=    		Brand Active		      =
=============================================*/
$('.slider-active-two').slick({
	autoplay: true,
    autoplaySpeed: 10000,
    dots: true,
    fade: true,
    arrows: false,
});

/*=============================================
	=    		Brand Active		      =
=============================================*/
$('.brand-active').slick({
	dots: false,
	infinite: true,
	speed: 1000,
	autoplay: true,
	arrows: false,
	slidesToShow: 5,
	slidesToScroll: 1,
	responsive: [
		{
			breakpoint: 1200,
			settings: {
				slidesToShow: 5,
				slidesToScroll: 1,
				infinite: true,
			}
		},
		{
			breakpoint: 992,
			settings: {
				slidesToShow: 4,
				slidesToScroll: 1
			}
		},
		{
			breakpoint: 767,
			settings: {
				slidesToShow: 3,
				slidesToScroll: 1,
				arrows: false,
			}
		},
		{
			breakpoint: 575,
			settings: {
				slidesToShow: 2,
				slidesToScroll: 1,
				arrows: false,
			}
		},
	]
});

/*=============================================
	=    		services Active		      =
=============================================*/
$('.services-active').slick({
	dots: true,
	infinite: true,
	speed: 1000,
	autoplay: true,
	arrows: false,
	slidesToShow: 3,
	slidesToScroll: 1,
	responsive: [
		{
			breakpoint: 1200,
			settings: {
				slidesToShow: 3,
				slidesToScroll: 1,
				infinite: true,
			}
		},
		{
			breakpoint: 992,
			settings: {
				slidesToShow: 2,
				slidesToScroll: 1
			}
		},
		{
			breakpoint: 767,
			settings: {
				slidesToShow: 1,
				slidesToScroll: 1,
				arrows: false,
			}
		},
		{
			breakpoint: 575,
			settings: {
				slidesToShow: 1,
				slidesToScroll: 1,
				arrows: false,
			}
		},
	]
});

/*=============================================
	=    	services Active	Two      =
=============================================*/
$('.services-active-two').slick({
	dots: true,
	infinite: true,
	speed: 1000,
	autoplay: true,
	arrows: false,
	slidesToShow: 4,
	slidesToScroll: 1,
	responsive: [
		{
			breakpoint: 1200,
			settings: {
				slidesToShow: 3,
				slidesToScroll: 1,
				infinite: true,
			}
		},
		{
			breakpoint: 992,
			settings: {
				slidesToShow: 2,
				slidesToScroll: 1
			}
		},
		{
			breakpoint: 767,
			settings: {
				slidesToShow: 2,
				slidesToScroll: 1,
				arrows: false,
			}
		},
		{
			breakpoint: 575,
			settings: {
				slidesToShow: 1,
				slidesToScroll: 1,
				arrows: false,
			}
		},
	]
});


/*=============================================
	=    		Brand Active		      =
=============================================*/
$('.testimonial-active').slick({
	dots: false,
	infinite: true,
	speed: 1000,
	autoplay: true,
	fade: true,
	arrows: true,
	prevArrow: '<button type="button" class="slick-prev"><i class="flaticon-right-arrow"></i></button>',
	nextArrow: '<button type="button" class="slick-next"><i class="flaticon-right-arrow"></i></button>',
	appendArrows: ".testimonial-nav",
	slidesToShow: 1,
	slidesToScroll: 1,
	responsive: [
		{
			breakpoint: 1200,
			settings: {
				slidesToShow: 1,
				slidesToScroll: 1,
				infinite: true,
			}
		},
		{
			breakpoint: 992,
			settings: {
				slidesToShow: 1,
				slidesToScroll: 1
			}
		},
		{
			breakpoint: 767,
			settings: {
				slidesToShow: 1,
				slidesToScroll: 1,
			}
		},
		{
			breakpoint: 575,
			settings: {
				slidesToShow: 1,
				slidesToScroll: 1,
			}
		},
	]
});



/*=============================================
	=    		testimonial Active		      =
=============================================*/
$('.testimonial-active-two').slick({
	dots: false,
	infinite: true,
	speed: 1000,
	autoplay: true,
	arrows: true,
	prevArrow: '<button type="button" class="slick-prev"><i class="flaticon-right-arrow"></i></button>',
	nextArrow: '<button type="button" class="slick-next"><i class="flaticon-right-arrow"></i></button>',
	appendArrows: ".testimonial-nav-two",
	slidesToShow: 2,
	slidesToScroll: 1,
	responsive: [
		{
			breakpoint: 1200,
			settings: {
				slidesToShow: 2,
				slidesToScroll: 1,
				infinite: true,
			}
		},
		{
			breakpoint: 992,
			settings: {
				slidesToShow: 1,
				slidesToScroll: 1
			}
		},
		{
			breakpoint: 767,
			settings: {
				slidesToShow: 1,
				slidesToScroll: 1,
			}
		},
		{
			breakpoint: 575,
			settings: {
				slidesToShow: 1,
				slidesToScroll: 1,
			}
		},
	]
});



/*=============================================
	=    		testimonial Active		      =
=============================================*/
$('.testimonial-active-three').slick({
	dots: false,
	infinite: true,
	speed: 1000,
	autoplay: true,
    fade: true,
	arrows: true,
	prevArrow: '<button type="button" class="slick-prev"><i class="flaticon-right-arrow"></i></button>',
	nextArrow: '<button type="button" class="slick-next"><i class="flaticon-right-arrow"></i></button>',
	appendArrows: ".testimonial-nav-three",
	slidesToShow: 1,
	slidesToScroll: 1,
	responsive: [
		{
			breakpoint: 1200,
			settings: {
				slidesToShow: 1,
				slidesToScroll: 1,
				infinite: true,
			}
		},
		{
			breakpoint: 992,
			settings: {
				slidesToShow: 1,
				slidesToScroll: 1
			}
		},
		{
			breakpoint: 767,
			settings: {
				slidesToShow: 1,
				slidesToScroll: 1,
			}
		},
		{
			breakpoint: 575,
			settings: {
				slidesToShow: 1,
				slidesToScroll: 1,
			}
		},
	]
});


/*=============================================
	=    		testimonial Active		      =
=============================================*/
$('.testimonial-active-four').slick({
	dots: false,
	infinite: true,
	speed: 1000,
	autoplay: true,
	arrows: true,
	prevArrow: '<button type="button" class="slick-prev"><i class="flaticon-right-arrow"></i></button>',
	nextArrow: '<button type="button" class="slick-next"><i class="flaticon-right-arrow"></i></button>',
	appendArrows: ".testimonial-nav-four",
	slidesToShow: 1,
	slidesToScroll: 1,
	responsive: [
		{
			breakpoint: 1200,
			settings: {
				slidesToShow: 1,
				slidesToScroll: 1,
				infinite: true,
			}
		},
		{
			breakpoint: 992,
			settings: {
				slidesToShow: 1,
				slidesToScroll: 1
			}
		},
		{
			breakpoint: 767,
			settings: {
				slidesToShow: 1,
				slidesToScroll: 1,
			}
		},
		{
			breakpoint: 575,
			settings: {
				slidesToShow: 1,
				slidesToScroll: 1,
			}
		},
	]
});



/*=============================================
	=    		testimonial Active		      =
=============================================*/
$('.testimonial-active-five').slick({
	dots: false,
	infinite: true,
	speed: 1000,
	autoplay: true,
	arrows: true,
	prevArrow: '<button type="button" class="slick-prev"><i class="flaticon-right-arrow"></i></button>',
	nextArrow: '<button type="button" class="slick-next"><i class="flaticon-right-arrow"></i></button>',
	appendArrows: ".testimonial-nav-five",
	vertical: true,
	slidesToShow: 1,
	slidesToScroll: 1,
	responsive: [
		{
			breakpoint: 1200,
			settings: {
				slidesToShow: 1,
				slidesToScroll: 1,
				infinite: true,
			}
		},
		{
			breakpoint: 992,
			settings: {
				slidesToShow: 1,
				slidesToScroll: 1
			}
		},
		{
			breakpoint: 767,
			settings: {
				slidesToShow: 1,
				slidesToScroll: 1,
			}
		},
		{
			breakpoint: 575,
			settings: {
				slidesToShow: 1,
				slidesToScroll: 1,
			}
		},
	]
});


/*=============================================
	=    		testimonial Active		      =
=============================================*/
$('.testimonial-active-six').slick({
	dots: false,
	infinite: true,
	speed: 1000,
	autoplay: true,
	arrows: true,
    fade: true,
	prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-arrow-left"></i></button>',
	nextArrow: '<button type="button" class="slick-next"><i class="fas fa-arrow-right"></i></button>',
	appendArrows: ".testimonial-nav-six",
	slidesToShow: 1,
	slidesToScroll: 1,
	responsive: [
		{
			breakpoint: 1200,
			settings: {
				slidesToShow: 1,
				slidesToScroll: 1,
				infinite: true,
			}
		},
		{
			breakpoint: 992,
			settings: {
				slidesToShow: 1,
				slidesToScroll: 1
			}
		},
		{
			breakpoint: 767,
			settings: {
				slidesToShow: 1,
				slidesToScroll: 1,
			}
		},
		{
			breakpoint: 575,
			settings: {
				slidesToShow: 1,
				slidesToScroll: 1,
			}
		},
	]
});


/*=============================================
	=         Project Active           =
=============================================*/
if (jQuery(".project-active").length > 0) {
	let courses = new Swiper(".project-active", {
		slidesPerView: 1,
		spaceBetween: 30,
		loop: true,
		autoplay: false,
		breakpoints: {
			500: {
				slidesPerView: 1.5,
				spaceBetween: 20,
			},
			768: {
				slidesPerView: 2,
				spaceBetween: 20,
			},
			992: {
				slidesPerView: 3.5,
				spaceBetween: 20,
			},
			1200: {
				slidesPerView: 3.5,
				spaceBetween: 20,
			},
			1500: {
				slidesPerView: 4,
				spaceBetween: 24,
			},
		},
		// If we need pagination
		pagination: {
			el: ".project-swiper-pagination",
			clickable: true,
		},

		// Navigation arrows
		navigation: {
			nextEl: ".swiper-button-next",
			prevEl: ".swiper-button-prev",
		},

		// And if we need scrollbar
		scrollbar: {
			el: ".swiper-scrollbar",
		},
	});
}


/*=============================================
	=         Project Active           =
=============================================*/
if (jQuery(".project-active-two").length > 0) {
	let courses = new Swiper(".project-active-two", {
		slidesPerView: 1,
		spaceBetween: 30,
		loop: true,
		autoplay: false,
        centeredSlides: true,
		breakpoints: {
			500: {
				slidesPerView: 1,
				spaceBetween: 20,
			},
			768: {
				slidesPerView: 2.5,
				spaceBetween: 20,
			},
			992: {
				slidesPerView: 3,
				spaceBetween: 20,
			},
			1200: {
				slidesPerView: 3,
				spaceBetween: 30,
			},
			1500: {
				slidesPerView: 3,
				spaceBetween: 40,
			},
		},

		// Navigation arrows
		navigation: {
			nextEl: ".project-seven-button-next",
			prevEl: ".project-seven-button-prev",
		},
	});
}

/*=============================================
	=    		pricing Active  	       =
=============================================*/
$(".pricing-tab-switcher, .tab-btn").on("click", function () {
	$(".pricing-tab-switcher, .tab-btn").toggleClass("active"),
	$(".pricing-tab").toggleClass("seleceted"),
	$(".pricing-price, .pricing-price-two").toggleClass("change-subs-duration");
});


/*=============================================
	=          services Active               =
=============================================*/
$('.services-item-two').hover(function () {
	$(this).find('.services-content-two p').slideToggle(300);
	return false;
});


/*=============================================
	=        Team Social Active 	       =
=============================================*/
$('.social-toggle-icon').on('click', function () {
	$(this).parent().find('ul').slideToggle(400);
	$(this).find('i').toggleClass('fa-times');
	return false;
});


/*=============================================
	    =           Partical JS        =
=============================================*/
if ($('.banner-area-three, .banner-area-five').length) {
	const colors = ["#FF4D4D", "#1AD6FF", "#FFCD4D", "#BB6BD9", "#1A66FF"];

	const numBalls = 30;
	const balls = [];

	for (let i = 0; i < numBalls; i++) {
		let ball = document.createElement("div");
		ball.classList.add("ball");
		ball.style.background = colors[Math.floor(Math.random() * colors.length)];
		ball.style.left = `${Math.floor(Math.random() * 100)}%`;
		ball.style.top = `${Math.floor(Math.random() * 100)}%`;
		ball.style.transform = `scale(${Math.random()})`;
		ball.style.width = `${Math.random() * 10}px`;
		ball.style.height = ball.style.width;
		balls.push(ball);

		$('.banner-area-three, .banner-area-five').append(ball);
	}

	balls.forEach((el, i, ra) => {
		let to = {
			x: Math.random() * (i % 2 === 0 ? -10 : 11),
			y: Math.random() * 12
		};

		let anim = el.animate(
			[
				{ transform: "translate(0, 0)" },
				{ transform: `translate(${to.x}rem, ${to.y}rem)` }
			],
			{
				duration: (Math.random() + 1) * 2000,
				direction: "alternate",
				fill: "both",
				iterations: Infinity,
				easing: "ease-in-out"
			}
		);
	});
}


/*=============================================
	    =           Partical JS        =
=============================================*/
if ($('.about-area-six').length) {
	const colors = ["#FF4D4D", "#1AD6FF", "#FFCD4D", "#BB6BD9", "#1A66FF"];

	const numBalls = 30;
	const balls = [];

	for (let i = 0; i < numBalls; i++) {
		let ball = document.createElement("div");
		ball.classList.add("ball");
		ball.style.background = colors[Math.floor(Math.random() * colors.length)];
		ball.style.left = `${Math.floor(Math.random() * 100)}%`;
		ball.style.top = `${Math.floor(Math.random() * 100)}%`;
		ball.style.transform = `scale(${Math.random()})`;
		ball.style.width = `${Math.random() * 10}px`;
		ball.style.height = ball.style.width;
		balls.push(ball);

		$('.about-area-six').append(ball);
	}

	balls.forEach((el, i, ra) => {
		let to = {
			x: Math.random() * (i % 2 === 0 ? -10 : 11),
			y: Math.random() * 12
		};

		let anim = el.animate(
			[
				{ transform: "translate(0, 0)" },
				{ transform: `translate(${to.x}rem, ${to.y}rem)` }
			],
			{
				duration: (Math.random() + 1) * 2000,
				direction: "alternate",
				fill: "both",
				iterations: Infinity,
				easing: "ease-in-out"
			}
		);
	});
}

/*=============================================
	    =           Partical JS        =
=============================================*/
if ($('.testimonial-area-five').length) {
	const colors = ["#FF4D4D", "#1AD6FF", "#FFCD4D", "#BB6BD9", "#1A66FF"];

	const numBalls = 30;
	const balls = [];

	for (let i = 0; i < numBalls; i++) {
		let ball = document.createElement("div");
		ball.classList.add("ball");
		ball.style.background = colors[Math.floor(Math.random() * colors.length)];
		ball.style.left = `${Math.floor(Math.random() * 100)}%`;
		ball.style.top = `${Math.floor(Math.random() * 100)}%`;
		ball.style.transform = `scale(${Math.random()})`;
		ball.style.width = `${Math.random() * 10}px`;
		ball.style.height = ball.style.width;
		balls.push(ball);

		$('.testimonial-area-five').append(ball);
	}

	balls.forEach((el, i, ra) => {
		let to = {
			x: Math.random() * (i % 2 === 0 ? -10 : 11),
			y: Math.random() * 12
		};

		let anim = el.animate(
			[
				{ transform: "translate(0, 0)" },
				{ transform: `translate(${to.x}rem, ${to.y}rem)` }
			],
			{
				duration: (Math.random() + 1) * 2000,
				direction: "alternate",
				fill: "both",
				iterations: Infinity,
				easing: "ease-in-out"
			}
		);
	});
}


/*=============================================
	=          easyPieChart Active          =
=============================================*/
function easyPieChart() {
	$('.circle-item').on('inview', function (event, isInView) {
		if (isInView) {
			$('.chart').easyPieChart({
				scaleLength: 0,
				lineWidth: 10,
				trackWidth: 10,
				size: 160,
				rotate: 360,
				animate: 3000,
				trackColor: '#2A3E66',
				barColor: '#0055FF',
			});
		}
	});
}
easyPieChart();


/*-------------------------------------
Intersection Observer
-------------------------------------*/
if (!!window.IntersectionObserver) {
let observer = new IntersectionObserver((entries, observer) => {
	entries.forEach(entry => {
	if (entry.isIntersecting) {
		entry.target.classList.add("active-animation");
		//entry.target.src = entry.target.dataset.src;
		observer.unobserve(entry.target);
	}
	});
}, {
	rootMargin: "0px 0px -100px 0px"
});
document.querySelectorAll('.has-animation').forEach(block => {
	observer.observe(block)
});
} else {
document.querySelectorAll('.has-animation').forEach(block => {
	block.classList.remove('has-animation')
});
}


/*=============================================
	=    		 Jarallax Active  	         =
=============================================*/
$('.jarallax').jarallax({
	speed: 0.2,
});


/*=============================================
	=    		Odometer Active  	       =
=============================================*/
$('.odometer').appear(function (e) {
	var odo = $(".odometer");
	odo.each(function () {
		var countNumber = $(this).attr("data-count");
		$(this).html(countNumber);
	});
});


/*=============================================
	=    		Magnific Popup		      =
=============================================*/
$('.popup-image').magnificPopup({
	type: 'image',
	gallery: {
		enabled: true
	}
});

/* magnificPopup video view */
$('.popup-video').magnificPopup({
	type: 'iframe'
});


/*=============================================
	=    		 Wow Active  	         =
=============================================*/
function wowAnimation() {
	var wow = new WOW({
		boxClass: 'wow',
		animateClass: 'animated',
		offset: 0,
		mobile: false,
		live: true
	});
	wow.init();
}


/*=============================================
	=           Aos Active       =
=============================================*/
function aosAnimation() {
	AOS.init({
		duration: 1000,
		mirror: true,
		once: true,
		disable: 'mobile',
	});
}


})(jQuery);


document.addEventListener("DOMContentLoaded", function () {
    var header = document.querySelector("header");

    if (header) {
        if (window.location.pathname === "/") {
            header.classList.remove("header-style-six");
            header.classList.add("transparent-header");
        } else {
            header.classList.remove("transparent-header");
            header.classList.add("header-style-six");
        }
    }
});


document.addEventListener('DOMContentLoaded', function() {
    // Tab switching functionality
    const tabButtons = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');
    
    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            const tabId = button.getAttribute('data-tab');
            
            // Remove active class from all buttons and contents
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabContents.forEach(content => content.classList.remove('active'));
            
            // Add active class to current button and content
            button.classList.add('active');
            document.getElementById(tabId).classList.add('active');
        });
    });
    
    // Plan selection functionality
    const planCards = document.querySelectorAll('.plan-card');
    
    planCards.forEach(card => {
        card.addEventListener('click', () => {
            // Remove selected class from all cards
            planCards.forEach(c => c.classList.remove('selected'));
            
            // Add selected class to clicked card
            card.classList.add('selected');
            
            // Update plan information if needed
            updatePlanSummary(card);
        });
    });
    
    function updatePlanSummary(selectedCard) {
        const planTitle = selectedCard.querySelector('.plan-title').textContent;
        const planTotal = selectedCard.querySelector('.plan-total').textContent;
        
        // If there's a summary section, update it
        // This can be expanded based on your needs
        console.log(`Selected plan: ${planTitle}, ${planTotal}`);
    }
    
    // Multi-step form navigation
    const steps = document.querySelectorAll('.step-section');
    const progressSteps = document.querySelectorAll('.progress-step');
    const nextButtons = document.querySelectorAll('.next-step-btn');
    const prevButtons = document.querySelectorAll('.prev-step-btn');
    
    // Function to show specific step
    function showStep(stepNumber) {
        // Hide all steps
        steps.forEach(step => step.classList.remove('active'));
        
        // Show the target step
        document.getElementById(`step-${stepNumber}`).classList.add('active');
        
        // Update progress indicator
        progressSteps.forEach(step => {
            const stepNum = parseInt(step.getAttribute('data-step'));
            if (stepNum <= stepNumber) {
                step.classList.add('active');
            } else {
                step.classList.remove('active');
            }
        });
        
        // Scroll to top of the form
        document.querySelector('.pricing-item-wrap').scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }
    
    // Next button click handlers
    nextButtons.forEach(button => {
        button.addEventListener('click', () => {
            const nextStep = button.getAttribute('data-goto');
            
            // If on step 2, validate the form before proceeding
            if (button.closest('#step-2')) {
                const form = document.getElementById('register-form');
                if (validateForm(form)) {
                    showStep(nextStep);
                }
            } else {
                showStep(nextStep);
            }
        });
    });
    
    // Previous button click handlers
    prevButtons.forEach(button => {
        button.addEventListener('click', () => {
            const prevStep = button.getAttribute('data-goto');
            showStep(prevStep);
        });
    });
    
    // Form validation
    function validateForm(form) {
        let isValid = true;
        const requiredFields = form.querySelectorAll('[required]');
        
        // Remove previous validation messages
        const oldMessages = form.querySelectorAll('.validation-message');
        oldMessages.forEach(msg => msg.remove());
        
        // Reset field styles
        form.querySelectorAll('input, select').forEach(field => {
            field.classList.remove('is-invalid');
        });
        
        // Check each required field
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                isValid = false;
                field.classList.add('is-invalid');
                
                // Create validation message
                const validationMsg = document.createElement('div');
                validationMsg.className = 'validation-message';
                validationMsg.textContent = 'This field is required';
                validationMsg.style.color = 'var(--secondary)';
                validationMsg.style.fontSize = '12px';
                validationMsg.style.marginTop = '5px';
                
                // Insert after the field or its parent if inside input-with-icon
                const parent = field.closest('.input-with-icon') || field.parentElement;
                parent.appendChild(validationMsg);
            }
        });
        
        // Check email format
        const emailField = form.querySelector('input[type="email"]');
        if (emailField && emailField.value.trim()) {
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(emailField.value)) {
                isValid = false;
                emailField.classList.add('is-invalid');
                
                const validationMsg = document.createElement('div');
                validationMsg.className = 'validation-message';
                validationMsg.textContent = 'Please enter a valid email address';
                validationMsg.style.color = 'var(--secondary)';
                validationMsg.style.fontSize = '12px';
                validationMsg.style.marginTop = '5px';
                
                const parent = emailField.closest('.input-with-icon') || emailField.parentElement;
                parent.appendChild(validationMsg);
            }
        }
        
        // If validation fails, scroll to first invalid field
        if (!isValid) {
            const firstInvalid = form.querySelector('.is-invalid');
            if (firstInvalid) {
                firstInvalid.focus();
                firstInvalid.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }
        }
        
        return isValid;
    }
    
    // Form submission handlers
    const registerForm = document.getElementById('register-form');
    const renewForm = document.getElementById('renew-form');
    const transferForm = document.getElementById('transfer-form');
    
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            if (!validateForm(this)) {
                e.preventDefault();
            } else {
                // Add loading state to button
                const submitBtn = this.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    const originalText = submitBtn.innerHTML;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
                    
                    // Re-enable button after 3 seconds if the form is not actually submitted
                    // This would be removed in a real implementation
                    setTimeout(() => {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalText;
                    }, 3000);
                }
            }
        });
    }
    
    if (renewForm) {
        renewForm.addEventListener('submit', function(e) {
            if (!validateForm(this)) {
                e.preventDefault();
            } else {
                // Add loading state to button
                const submitBtn = this.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
                }
            }
        });
    }
    
    if (transferForm) {
        transferForm.addEventListener('submit', function(e) {
            if (!validateForm(this)) {
                e.preventDefault();
            } else {
                // Add loading state to button
                const submitBtn = this.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
                }
            }
        });
    }
    
    // Add input validation on blur
    const formInputs = document.querySelectorAll('input[required], select[required]');
    
    formInputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (!this.value.trim()) {
                this.classList.add('is-invalid');
                
                // Check if validation message already exists
                const parent = this.closest('.input-with-icon') || this.parentElement;
                let validationMsg = parent.querySelector('.validation-message');
                
                if (!validationMsg) {
                    validationMsg = document.createElement('div');
                    validationMsg.className = 'validation-message';
                    validationMsg.textContent = 'This field is required';
                    validationMsg.style.color = 'var(--secondary)';
                    validationMsg.style.fontSize = '12px';
                    validationMsg.style.marginTop = '5px';
                    parent.appendChild(validationMsg);
                }
            }
        });
        
        input.addEventListener('focus', function() {
            this.classList.remove('is-invalid');
            
            // Remove validation message if it exists
            const parent = this.closest('.input-with-icon') || this.parentElement;
            const validationMsg = parent.querySelector('.validation-message');
            if (validationMsg) {
                validationMsg.remove();
            }
        });
    });
    
    // Format phone number input if it exists
    // const phoneInput = document.getElementById('phone');
    
    // if (phoneInput) {
    //     phoneInput.addEventListener('input', function(e) {
    //         let value = this.value.replace(/\D/g, '');
            
    //         // Format the phone number
    //         if (value.length > 0) {
    //             if (value.length <= 3) {
    //                 value = '+' + value;
    //             } else if (value.length <= 6) {
    //                 value = '+' + value.substring(0, 1) + ' (' + value.substring(1);
    //             } else if (value.length <= 9) {
    //                 value = '+' + value.substring(0, 1) + ' (' + value.substring(1, 4) + ') ' + value.substring(4);
    //             } else {
    //                 value = '+' + value.substring(0, 1) + ' (' + value.substring(1, 4) + ') ' + value.substring(4, 7) + '-' + value.substring(7, 11);
    //             }
    //         }
            
    //         this.value = value;
    //     });
    // }
    
    // Add some animations to make the form more engaging
    // Animate plan cards on page load
    setTimeout(() => {
        planCards.forEach((card, index) => {
            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });
    }, 300);
    
    // Add initial styles for animation
    planCards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
    });
    
    // CSS for validation styling
    const style = document.createElement('style');
    style.textContent = `
        .is-invalid {
            border-color: var(--secondary) !important;
            background-color: rgba(229, 62, 62, 0.05);
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }
        
        .shake {
            animation: shake 0.5s ease-in-out;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        .fa-spinner {
            display: inline-block;
            animation: spin 1s linear infinite;
        }
    `;
    document.head.appendChild(style);
    
    // Fix any links with ahref (if present in your HTML)
    document.querySelectorAll('ahref').forEach(brokenLink => {
        // Get the href and text content
        const href = brokenLink.textContent || '#';
        const text = brokenLink.textContent || 'Link';
        
        // Create a proper anchor element
        const properLink = document.createElement('a');
        properLink.href = href;
        properLink.textContent = text;
        
        // Replace the broken link with the proper one
        brokenLink.parentNode.replaceChild(properLink, brokenLink);
    });
});



// Place this script in a separate JavaScript file and include it AFTER jQuery and CKEditor
// For example: /public/js/faq-management.js

$(function() {
    console.log('FAQ Management Script Loaded');
    
    // Add regular FAQ item
    $('#add-faq').on('click', function() {
        console.log('Add FAQ button clicked');
        var count = $('#faq-container .faq-item').length + 1;
        var newItemId = 'faq-' + new Date().getTime();
        
        var newItem = 
            '<div class="card mb-3 faq-item">' +
                '<div class="card-header bg-light d-flex justify-content-between align-items-center">' +
                    '<h6 class="mb-0">FAQ Item #' + count + '</h6>' +
                    '<button type="button" class="btn btn-sm btn-danger remove-faq">Remove</button>' +
                '</div>' +
                '<div class="card-body">' +
                    '<div class="mb-3">' +
                        '<label class="form-label">Question</label>' +
                        '<input type="text" name="faq_question[]" class="form-control">' +
                    '</div>' +
                    '<div class="mb-3">' +
                        '<label class="form-label">Answer</label>' +
                        '<textarea id="' + newItemId + '" name="faq_answer[]" class="form-control" rows="3"></textarea>' +
                    '</div>' +
                '</div>' +
            '</div>';
        
        $('#faq-container').append(newItem);
        
        // Initialize CKEditor for the new textarea
        CKEDITOR.replace(newItemId, {
            height: 200,
            filebrowserUploadUrl: faqConfig.uploadUrl,
            filebrowserUploadMethod: 'form'
        });
    });
    
    // Add About LEI FAQ item
    $('#add-aboutlei-faq').on('click', function() {
        console.log('Add About LEI FAQ button clicked');
        var count = $('#aboutlei-faq-container .faq-item').length + 1;
        var newItemId = 'aboutlei-faq-' + new Date().getTime();
        
        var newItem = 
            '<div class="card mb-3 faq-item">' +
                '<div class="card-header bg-light d-flex justify-content-between align-items-center">' +
                    '<h6 class="mb-0">FAQ Item #' + count + '</h6>' +
                    '<button type="button" class="btn btn-sm btn-danger remove-faq">Remove</button>' +
                '</div>' +
                '<div class="card-body">' +
                    '<div class="mb-3">' +
                        '<label class="form-label">Question</label>' +
                        '<input type="text" name="aboutlei_faq_question[]" class="form-control">' +
                    '</div>' +
                    '<div class="mb-3">' +
                        '<label class="form-label">Answer</label>' +
                        '<textarea id="' + newItemId + '" name="aboutlei_faq_answer[]" class="form-control" rows="3"></textarea>' +
                    '</div>' +
                '</div>' +
            '</div>';
        
        $('#aboutlei-faq-container').append(newItem);
        
        // Initialize CKEditor for the new textarea
        CKEDITOR.replace(newItemId, {
            height: 200,
            filebrowserUploadUrl: faqConfig.uploadUrl,
            filebrowserUploadMethod: 'form'
        });
    });
    
    // Remove FAQ item (using event delegation for dynamically added elements)
    $(document).on('click', '.remove-faq', function() {
        console.log('Remove FAQ button clicked');
        var faqItem = $(this).closest('.faq-item');
        
        // Find textarea and destroy CKEditor instance if exists
        var textarea = faqItem.find('textarea');
        if (textarea.length && textarea.attr('id') && CKEDITOR.instances[textarea.attr('id')]) {
            CKEDITOR.instances[textarea.attr('id')].destroy();
        }
        
        // Remove the FAQ item
        faqItem.remove();
    });
});



// popup

document.addEventListener('DOMContentLoaded', function() {
    // Tab switching functionality
    const tabButtons = document.querySelectorAll('.tab-btn');
    
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Get the tab ID this button controls
            const tabId = this.getAttribute('data-tab');
            
            // Remove active class from all tab buttons
            tabButtons.forEach(btn => {
                btn.classList.remove('active');
            });
            
            // Add active class to clicked button
            this.classList.add('active');
            
            // Hide all tab contents
            const allTabContents = document.querySelectorAll('.tab-content');
            allTabContents.forEach(content => {
                content.classList.remove('active');
            });
            
            // Show the selected tab content
            const selectedTab = document.getElementById(tabId);
            if (selectedTab) {
                selectedTab.classList.add('active');
            }
        });
    });
    
    // Step navigation in Register tab
    const nextButtons = document.querySelectorAll('.next-step-btn');
    const prevButtons = document.querySelectorAll('.prev-step-btn');
    
    nextButtons.forEach(button => {
        button.addEventListener('click', function() {
            const nextStepNumber = this.getAttribute('data-goto');
            goToStep(nextStepNumber);
        });
    });
    
    prevButtons.forEach(button => {
        button.addEventListener('click', function() {
            const prevStepNumber = this.getAttribute('data-goto');
            goToStep(prevStepNumber);
        });
    });
    
    function goToStep(stepNumber) {
        // Hide all step sections
        const allStepSections = document.querySelectorAll('.step-section');
        allStepSections.forEach(section => {
            section.classList.remove('active');
        });
        
        // Show the target step section
        const targetStep = document.getElementById('step-' + stepNumber);
        if (targetStep) {
            targetStep.classList.add('active');
        }
        
        // Update step indicators
        const allStepIndicators = document.querySelectorAll('.progress-step');
        allStepIndicators.forEach(indicator => {
            const indicatorStep = indicator.getAttribute('data-step');
            if (parseInt(indicatorStep) <= parseInt(stepNumber)) {
                indicator.classList.add('active');
            } else {
                indicator.classList.remove('active');
            }
        });
    }
    
    // Popup functionality for Bulk Registration
    const openBulkPopupBtn = document.getElementById('open-bulk-popup');
    const closeBulkPopupBtn = document.getElementById('close-bulk-popup');
    const bulkPopupOverlay = document.getElementById('bulk-popup-overlay');
    
    if (openBulkPopupBtn) {
        openBulkPopupBtn.addEventListener('click', function(e) {
            e.preventDefault();
            if (bulkPopupOverlay) {
                bulkPopupOverlay.classList.add('active');
            }
        });
    }
    
    if (closeBulkPopupBtn && bulkPopupOverlay) {
        closeBulkPopupBtn.addEventListener('click', function() {
            bulkPopupOverlay.classList.remove('active');
        });
    }
    
    if (bulkPopupOverlay) {
        bulkPopupOverlay.addEventListener('click', function(e) {
            if (e.target === bulkPopupOverlay) {
                bulkPopupOverlay.classList.remove('active');
            }
        });
    }

    // Initialize select2 for bulk form if you're using select2 plugin
    if(typeof $.fn !== 'undefined' && typeof $.fn.select2 !== 'undefined') {
        $('#bulk-country').select2({
            dropdownParent: $('#bulk-popup-overlay')
        });
    }
});







// Add direct form submission with redirect handling
document.addEventListener('DOMContentLoaded', function() {
    const registerForm = document.getElementById('register-form');
    
    if (registerForm && !registerForm.hasAttribute('data-ajax-handled')) {
        console.log('Registration form found, adding redirect handler');
        
        registerForm.addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent the default form submission
            console.log('Registration form submitted, handling manually');
            
            // Show loading state
            const submitBtn = registerForm.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
                submitBtn.disabled = true;
            }
            
            // Create form data object
            const formData = new FormData(registerForm);
            
            // Submit form using fetch
            fetch(registerForm.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                redirect: 'manual' // Don't automatically follow redirects
            })
            .then(response => {
                console.log('Server response received:', response);
                
                // Check if we got a redirect
                if (response.type === 'opaqueredirect' || response.redirected) {
                    // If redirected, get the URL from the Location header or response.url
                    const redirectUrl = response.url || response.headers.get('Location');
                    console.log('Redirecting to:', redirectUrl);
                    
                    if (redirectUrl) {
                        window.location.href = redirectUrl;
                    } else {
                        // If no redirect URL is found but we know it's a redirect,
                        // try to extract the ID from the form data and build the URL
                        const orderId = registerForm.querySelector('input[name="id"]')?.value || 
                                       Math.floor(Date.now() / 1000); // Fallback to timestamp
                        
                        console.log('No redirect URL found, trying fallback to /payment/' + orderId);
                        window.location.href = '/payment/' + orderId;
                    }
                    return;
                }
                
                // If we get a response with status 200, try to parse it
                if (response.ok) {
                    console.log('Form submitted successfully, checking content type');
                    
                    // Check content type
                    const contentType = response.headers.get('content-type');
                    if (contentType && contentType.includes('application/json')) {
                        return response.json().then(data => {
                            console.log('JSON response:', data);
                            
                            // Check if JSON contains a redirect URL
                            if (data.redirect) {
                                console.log('JSON redirect to:', data.redirect);
                                window.location.href = data.redirect;
                            } else {
                                // If successful but no redirect, show success message
                                alert('Registration successful!');
                                window.location.reload();
                            }
                        });
                    } else {
                        return response.text().then(text => {
                            console.log('Text response');
                            // For HTML responses, we could be getting an error page
                            // Try to extract any error message
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(text, 'text/html');
                            const errorMsg = doc.querySelector('.alert-danger')?.textContent || 
                                          'Unknown error occurred';
                            
                            console.error('Server returned HTML with potential error:', errorMsg);
                            
                            // Show error message
                            alert('Registration error: ' + errorMsg);
                            
                            // Reset button
                            if (submitBtn) {
                                submitBtn.innerHTML = 'CONFIRM & CONTINUE';
                                submitBtn.disabled = false;
                            }
                        });
                    }
                } else {
                    // Handle error response
                    console.error('Server error:', response.status);
                    return response.text().then(text => {
                        console.error('Error response text:', text);
                        
                        // Show error message
                        alert('Registration error: ' + response.status + ' - ' + response.statusText);
                        
                        // Reset button
                        if (submitBtn) {
                            submitBtn.innerHTML = 'CONFIRM & CONTINUE';
                            submitBtn.disabled = false;
                        }
                    });
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
                
                // Show error message
                alert('An error occurred while submitting the form. Please try again.');
                
                // Reset button
                if (submitBtn) {
                    submitBtn.innerHTML = 'CONFIRM & CONTINUE';
                    submitBtn.disabled = false;
                }
            });
        });
    }
});





document.addEventListener('DOMContentLoaded', function() {
    // Get all plan cards
    const planCards = document.querySelectorAll('.plan-card');
    
    // Function to update plan selection
    function updatePlanSelection(selectedPlan) {
        // Remove active class from all plans
        planCards.forEach(plan => {
            plan.classList.remove('active');
        });
        
        // Add active class to selected plan
        selectedPlan.classList.add('active');
        
        // Update state and hidden input
        const planType = selectedPlan.getAttribute('data-plan');
        document.getElementById('selected_plan').value = planType;
        
        // Update displayed amounts
        updatePlanState(planType);
    }
    
    // Add click events to plan cards
    planCards.forEach(plan => {
        plan.addEventListener('click', function() {
            updatePlanSelection(this);
        });
    });
    
    // Function to update plan state and calculate amounts
    function updatePlanState(planType) {
        const prices = {
            '1-year': 75,
            '3-years': 165,
            '5-years': 250
        };
        
        const planAmount = prices[planType] || 75;
        document.getElementById('plan-amount').textContent = '€' + planAmount.toFixed(2);
        
        // Update total
        calculateTotal();
    }
    
    // Function to update service state
    function updateServiceState(serviceType) {
        const serviceAmount = serviceType === 'complete' ? 21 : 0;
        document.getElementById('service-amount').textContent = '€' + serviceAmount.toFixed(2);
        
        // Update total
        calculateTotal();
    }
    
    // Calculate total amount
    function calculateTotal() {
        // Get plan amount
        const planText = document.getElementById('plan-amount').textContent;
        const planAmount = parseFloat(planText.replace('€', '')) || 0;
        
        // Get service amount
        const serviceText = document.getElementById('service-amount').textContent;
        const serviceAmount = parseFloat(serviceText.replace('€', '')) || 0;
        
        // Calculate total
        const total = planAmount + serviceAmount;
        
        // Update total display
        document.getElementById('total-amount').textContent = '€' + total.toFixed(2);
        
        // Update button amount
        const buttonAmount = document.getElementById('button-amount');
        if (buttonAmount) {
            buttonAmount.textContent = total.toFixed(2);
        }
    }
});

// Add toggle switch style checkboxes to plan options
document.querySelectorAll('.plan-option').forEach(option => {
    // Create checkbox element
    const checkbox = document.createElement('div');
    checkbox.className = 'plan-checkbox';
    option.appendChild(checkbox);
});

// Plan option selection with toggle
document.querySelectorAll('.plan-option').forEach(option => {
    option.addEventListener('click', function() {
        // Remove active class from all options
        document.querySelectorAll('.plan-option').forEach(o => {
            o.classList.remove('active');
        });
        
        // Add active class to clicked option
        this.classList.add('active');
        
        // Update state based on selected plan
        const planId = this.id.replace('plan-', '');
        
        // Your plan selection logic here...
        // Example:
        if (planId === '1-year') {
            // Update to 1-year plan
        } else if (planId === '3-years') {
            // Update to 3-year plan
        } else if (planId === '5-years') {
            // Update to 5-year plan
        }
    });
});