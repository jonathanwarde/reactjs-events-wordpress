import Swiper from 'swiper'
import { Navigation, Autoplay } from 'swiper/modules'

const comediansSwiper = () => {

    var debug = false;

    const comedians = document.querySelector('.comedians-swiper');
    if(comedians){
        const swiper = new Swiper('.comedians-swiper', {
            modules: [Navigation, Autoplay],
            slidesPerView: "auto",
            spaceBetween: 30,
            freeMode: true,
            loop: true,
            // speed: 550 * e.dataset.letters,
            speed: 550 * 14,
            autoplay: {
                delay: 0,
                disableOnInteraction: false
            },
            /*pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },*/
        });
    }


    const testimonials = document.querySelector('.testimonials-slider');
    if(testimonials) {
        const swiper2 = new Swiper('.testimonials-slider', {
            slidesPerView: 1,
            loop: true,
            // speed: 550 * e.dataset.letters,
            //speed: 550 * 14,
            autoplay: {
                delay: 5000,
            },
            /*effect: 'fade',
            fadeEffect: {
                crossFade: true
            },*/
            /*pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },*/
        });
    }
}

export default comediansSwiper
