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
 * Enables keyboard navigation for the most recently interacted Swiper.
 * Ensures that only one Swiper responds to arrow keys at a time.
 */
function bsSwiperKeyFocus(swiper) {
  const root = swiper.el;

  /**
   * Activates keyboard navigation for the current Swiper.
   */
  function activate() {
    const previous = window.bootscoreActiveKeyboardSwiper;

    if (previous && previous !== swiper && !previous.destroyed) {
      previous.keyboard.disable();
    }

    window.bootscoreActiveKeyboardSwiper = swiper;
    swiper.keyboard.enable();
  }

  /**
   * Disables keyboard navigation when focus leaves the Swiper.
   */
  function deactivate(event) {
    if (event.relatedTarget && root.contains(event.relatedTarget)) {
      return;
    }

    if (window.bootscoreActiveKeyboardSwiper === swiper) {
      swiper.keyboard.disable();
      window.bootscoreActiveKeyboardSwiper = null;
    }
  }

  root.addEventListener('focusin', activate);
  root.addEventListener('focusout', deactivate);
  root.addEventListener('pointerdown', activate);
}

/**
 * Provides logical Tab navigation through Swiper slides.
 * Supports loop mode, duplicate slides and slides without focusable elements.
 */
function bsSwiperTabFocus(swiper) {
  const root = swiper.el;
  const totalSlides = root.querySelectorAll(
    '.swiper-slide:not(.swiper-slide-duplicate)'
  ).length;

  const focusableSelector =
    'a[href], button:not([disabled]), input:not([disabled]), ' +
    'select:not([disabled]), textarea:not([disabled]), ' +
    '[tabindex]:not([tabindex="-1"])';

  /**
   * Returns visible and focusable elements within a slide.
   */
  function getFocusableElements(slide) {
    return Array.from(slide.querySelectorAll(focusableSelector)).filter(function (element) {
      return !element.classList.contains('d-none') &&
        element.getClientRects().length > 0;
    });
  }

  /**
   * Removes duplicated slide elements from the keyboard Tab order.
   * Keeps the original slides accessible.
   */
  function disableDuplicateSlideFocus() {
    root.querySelectorAll('.swiper-slide-duplicate').forEach(function (slide) {
      slide.querySelectorAll(focusableSelector).forEach(function (element) {
        element.setAttribute('tabindex', '-1');
      });
    });
  }

  /**
   * Returns the original index of a slide.
   */
  function getSlideIndex(slide) {
    const index = Number(slide.getAttribute('data-swiper-slide-index'));

    return Number.isInteger(index) && index >= 0 && index < totalSlides
      ? index
      : -1;
  }

  /**
   * Returns the original slide matching the given index.
   */
  function getSlide(index) {
    return Array.from(swiper.slides).find(function (slide) {
      return !slide.classList.contains('swiper-slide-duplicate') &&
        getSlideIndex(slide) === index;
    });
  }

  /**
   * Navigates to a slide and focuses its target element.
   * Uses the original slide to avoid focusing an incorrect loop duplicate.
   */
  function focusSlide(index, elementIndex) {
    swiper.slideToLoop(index, 0, false);

    requestAnimationFrame(function () {
      const slide = getSlide(index);

      if (!slide) {
        return;
      }

      const elements = getFocusableElements(slide);
      const target = elements[elementIndex];

      if (target) {
        target.focus({ preventScroll: true });
      }
    });
  }

  /**
   * Returns the nearest focusable element outside the current Swiper
   * based on the document order and navigation direction.
   */
  function getOutsideFocusableElement(backwards) {
    const elements = Array.from(
      document.querySelectorAll(focusableSelector)
    ).filter(function (element) {
      return element.getClientRects().length > 0 &&
        !root.contains(element);
    });

    if (backwards) {
      return elements.filter(function (element) {
        return Boolean(
          element.compareDocumentPosition(root) &
          Node.DOCUMENT_POSITION_FOLLOWING
        );
      }).pop() || null;
    }

    return elements.find(function (element) {
      return Boolean(
        root.compareDocumentPosition(element) &
        Node.DOCUMENT_POSITION_FOLLOWING
      );
    }) || null;
  }

  /**
   * Handles Tab and Shift+Tab navigation between slides and controls.
   */
  root.addEventListener('keydown', function (event) {
    if (event.key !== 'Tab' || !swiper.params.loop) {
      return;
    }

    const slide = event.target.closest('.swiper-slide');

    // Return from the first navigation button to the active slide.
    if (!slide) {
      if (event.shiftKey && swiper.navigation) {
        const controls = [
          swiper.navigation.nextEl,
          swiper.navigation.prevEl
        ].flat().filter(function (element) {
          return element &&
            root.contains(element) &&
            element.getClientRects().length > 0;
        });

        if (event.target === controls[0]) {
          let index = swiper.realIndex;

          while (index >= 0) {
            const targetSlide = getSlide(index);
            const elements = targetSlide
              ? getFocusableElements(targetSlide)
              : [];

            if (elements.length) {
              event.preventDefault();
              focusSlide(index, elements.length - 1);
              return;
            }

            index--;
          }
        }
      }

      return;
    }

    if (!root.contains(slide)) {
      return;
    }

    const currentIndex = getSlideIndex(slide);
    const elements = getFocusableElements(slide);
    const elementIndex = elements.indexOf(event.target);

    if (currentIndex < 0 || elementIndex < 0) {
      return;
    }

    const backwards = event.shiftKey;

    // Allow native backward navigation within the same slide.
    if (backwards && elementIndex > 0) {
      return;
    }

    // Leave the Swiper when navigating backwards from the first slide.
    if (backwards && currentIndex === 0) {
      const target = getOutsideFocusableElement(true);

      if (target) {
        event.preventDefault();
        target.focus({ preventScroll: true });
      }

      return;
    }

    if (!backwards && elementIndex < elements.length - 1) {
      return;
    }

    // Skip slides without focusable elements.
    let nextIndex = currentIndex + (backwards ? -1 : 1);
    let nextElements = [];

    while (nextIndex >= 0 && nextIndex < totalSlides) {
      const nextSlide = getSlide(nextIndex);

      nextElements = nextSlide
        ? getFocusableElements(nextSlide)
        : [];

      if (nextElements.length) {
        break;
      }

      nextIndex += backwards ? -1 : 1;
    }

    // Move focus to the first navigation control after the last slide.
    if (!backwards && nextIndex >= totalSlides && swiper.navigation) {
      const nextButton = swiper.navigation.nextEl;

      if (nextButton && nextButton.getClientRects().length > 0) {
        event.preventDefault();
        nextButton.focus({ preventScroll: true });
        return;
      }
    }

    // Move focus outside the Swiper at either boundary.
    if (nextIndex < 0 || nextIndex >= totalSlides) {
      const target = getOutsideFocusableElement(backwards);

      event.preventDefault();

      if (target) {
        target.focus({ preventScroll: true });
      } else {
        root.setAttribute('tabindex', '-1');
        root.focus({ preventScroll: true });
      }

      return;
    }

    event.preventDefault();

    focusSlide(
      nextIndex,
      backwards ? nextElements.length - 1 : 0
    );
  });

  // Exclude loop duplicates from the keyboard Tab order.
  disableDuplicateSlideFocus();
}

/**
 * Cards
 */
const bsSwiper = document.querySelectorAll('.cards');

for (i = 0; i < bsSwiper.length; i++) {

  bsSwiper[i].classList.add('cards-' + i);

  // Scope pagination and navigation controls to the current Swiper instance
  // to prevent conflicts when multiple Swipers are present on the same page.
  const pagination = bsSwiper[i].querySelector('.swiper-pagination');
  const nextButton = bsSwiper[i].querySelector('.swiper-button-next');
  const prevButton = bsSwiper[i].querySelector('.swiper-button-prev');

  var slider = new Swiper('.cards-' + i, {

    // Options
    slidesPerView: 1,
    spaceBetween: 20,
    loop: true,
    grabCursor: true,
    keyboard: {
      enabled: false,
    },
    a11y: {
      enabled: true,
      scrollOnFocus: false,
    },
    pagination: {
      el: pagination,
      clickable: true,
    },
    navigation: {
      nextEl: nextButton,
      prevEl: prevButton,
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

  // Initialize keyboard and Tab navigation for the current Swiper.
  bsSwiperKeyFocus(slider);
  bsSwiperTabFocus(slider);

}


/**
 * Cards Autoplay
 */
const bsSwiperAutoplay = document.querySelectorAll('.cards-autoplay');

for (i = 0; i < bsSwiperAutoplay.length; i++) {

  bsSwiperAutoplay[i].classList.add('cards-autoplay-' + i);

  // Scope pagination and navigation controls to the current Swiper instance
  // to prevent conflicts when multiple Swipers are present on the same page.
  const pagination = bsSwiperAutoplay[i].querySelector('.swiper-pagination');
  const nextButton = bsSwiperAutoplay[i].querySelector('.swiper-button-next');
  const prevButton = bsSwiperAutoplay[i].querySelector('.swiper-button-prev');

  var slider = new Swiper('.cards-autoplay-' + i, {

    // Options
    slidesPerView: 1,
    spaceBetween: 20,
    loop: true,
    grabCursor: true,
    keyboard: {
      enabled: false,
    },
    a11y: {
      enabled: true,
      scrollOnFocus: false,
    },
    autoplay: {
      delay: 4000,
      //disableOnInteraction: true,
      pauseOnMouseEnter: true,
    },
    disableOnInteraction: false,
    pagination: {
      el: pagination,
      clickable: true,
    },
    navigation: {
      nextEl: nextButton,
      prevEl: prevButton,
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

  // Initialize keyboard and Tab navigation for the current Swiper.
  bsSwiperKeyFocus(slider);
  bsSwiperTabFocus(slider);

}


/**
 * Hero
 */
const bsSwiperHero = document.querySelectorAll('.heroes');

for (i = 0; i < bsSwiperHero.length; i++) {

  bsSwiperHero[i].classList.add('heroes-' + i);

  // Scope pagination and navigation controls to the current Swiper instance
  // to prevent conflicts when multiple Swipers are present on the same page.
  const pagination = bsSwiperHero[i].querySelector('.swiper-pagination');
  const nextButton = bsSwiperHero[i].querySelector('.swiper-button-next');
  const prevButton = bsSwiperHero[i].querySelector('.swiper-button-prev');

  var slider = new Swiper('.heroes-' + i, {

    // Options
    slidesPerView: 1,
    loop: true,
    grabCursor: true,
    keyboard: {
      enabled: false,
    },
    a11y: {
      enabled: true,
      scrollOnFocus: false,
    },
    autoplay: {
      delay: 4000,
      //disableOnInteraction: true,
      pauseOnMouseEnter: true,
    },
    pagination: {
      el: pagination,
      clickable: true,
    },
    navigation: {
      nextEl: nextButton,
      prevEl: prevButton,
    },
  });

  // Initialize keyboard and Tab navigation for the current Swiper.
  bsSwiperKeyFocus(slider);
  bsSwiperTabFocus(slider);

}


/**
 * Hero Fade
 */
const bsSwiperHeroFade = document.querySelectorAll('.heroes-fade');

for (i = 0; i < bsSwiperHeroFade.length; i++) {

  bsSwiperHeroFade[i].classList.add('heroes-fade-' + i);

  // Scope pagination and navigation controls to the current Swiper instance
  // to prevent conflicts when multiple Swipers are present on the same page.
  const pagination = bsSwiperHeroFade[i].querySelector('.swiper-pagination');
  const nextButton = bsSwiperHeroFade[i].querySelector('.swiper-button-next');
  const prevButton = bsSwiperHeroFade[i].querySelector('.swiper-button-prev');

  var slider = new Swiper('.heroes-fade-' + i, {

    // Options
    slidesPerView: 1,
    loop: true,
    grabCursor: true,
    keyboard: {
      enabled: false,
    },
    a11y: {
      enabled: true,
      scrollOnFocus: false,
    },
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
      el: pagination,
      clickable: true,
    },
    navigation: {
      nextEl: nextButton,
      prevEl: prevButton,
    },

  });

  // Initialize keyboard and Tab navigation for the current Swiper.
  bsSwiperKeyFocus(slider);
  bsSwiperTabFocus(slider);

}