/*!
 * bs Swiper
 * 
 * @version 5.8.5
 */


/**
 * Multiple Swiper instances per page 
 * See https://raddy.co.uk/blog/multiple-instances-of-swiperjs-on-the-same-page-with-the-same-settings/
 */


/**
 * Cards
 */
const bsSwiper = document.querySelectorAll('.cards');

for (i = 0; i < bsSwiper.length; i++) {

  bsSwiper[i].classList.add('cards-' + i);

  var slider = new Swiper('.cards-' + i, {

    // Options
    slidesPerView: 1,
    spaceBetween: 20,
    loop: true,
    grabCursor: true,
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    breakpoints: {
      768: {
        slidesPerView: 2,
      },
      992: {
        slidesPerView: 3,
      },
      1400: {
        slidesPerView: 4,
      },
    }

  });

}


/**
 * Cards Autoplay
 */
const bsSwiperAutoplay = document.querySelectorAll('.cards-autoplay');

for (i = 0; i < bsSwiperAutoplay.length; i++) {

  bsSwiperAutoplay[i].classList.add('cards-autoplay-' + i);

  var slider = new Swiper('.cards-autoplay-' + i, {

    // Options
    slidesPerView: 1,
    spaceBetween: 20,
    loop: true,
    grabCursor: true,
    autoplay: {
      delay: 4000,
      //disableOnInteraction: true,
      pauseOnMouseEnter: true,
    },
    disableOnInteraction: false,
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    breakpoints: {
      768: {
        slidesPerView: 2,
      },
      992: {
        slidesPerView: 3,
      },
      1400: {
        slidesPerView: 4,
      },
    }

  });

}


/**
 * Hero
 */
const bsSwiperHero = document.querySelectorAll('.heroes');

for (i = 0; i < bsSwiperHero.length; i++) {

  bsSwiperHero[i].classList.add('heroes-' + i);

  var slider = new Swiper('.heroes-' + i, {

    // Options
    slidesPerView: 1,
    loop: true,
    grabCursor: true,
    autoplay: {
      delay: 4000,
      //disableOnInteraction: true,
      pauseOnMouseEnter: true,
    },
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },

  });

}


/**
 * Hero Fade
 */
const bsSwiperHeroFade = document.querySelectorAll('.heroes-fade');

for (i = 0; i < bsSwiperHeroFade.length; i++) {

  bsSwiperHeroFade[i].classList.add('heroes-fade-' + i);

  var slider = new Swiper('.heroes-fade-' + i, {

    // Options
    slidesPerView: 1,
    loop: true,
    grabCursor: true,
    speed: 1500,
    effect: 'fade',
    fadeEffect: {
      crossFade: true
    },
    autoplay: {
      delay: 4000,
      //disableOnInteraction: true,
      pauseOnMouseEnter: true,
    },
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },

  });

}