//Multiple Swiper instances per page https://raddy.co.uk/blog/multiple-instances-of-swiperjs-on-the-same-page-with-the-same-settings/

// Cards
const bSSwiper = document.querySelectorAll('.cards');

for (i = 0; i < bSSwiper.length; i++) {

  bSSwiper[i].classList.add('cards-' + i);

  var slider = new Swiper('.cards-' + i, {

    /* Options */
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


// Hero
const bSSwiperHero = document.querySelectorAll('.heroes');

for (i = 0; i < bSSwiperHero.length; i++) {

  bSSwiperHero[i].classList.add('heroes-' + i);

  var slider = new Swiper('.heroes-' + i, {

    /* Options */
    slidesPerView: 1,
    loop: true,
    grabCursor: true,
    autoplay: {
      delay: 4000,
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


// Hero Fade
const bSSwiperHeroFade = document.querySelectorAll('.heroes-fade');

for (i = 0; i < bSSwiperHeroFade.length; i++) {

  bSSwiperHeroFade[i].classList.add('heroes-fade-' + i);

  var slider = new Swiper('.heroes-fade-' + i, {

    /* Options */
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