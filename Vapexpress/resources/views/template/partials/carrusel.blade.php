<div class="carousel relative shadow-2xl bg-white w-full" style="margin: 0; padding: 0;">
    <div class="carousel-inner relative overflow-hidden w-full">
        <input class="carousel-open" type="radio" id="carousel-1" name="carousel" aria-hidden="true" hidden=""
            checked="checked">
        <div class="carousel-item absolute opacity-0" style="height:300px;">
            <img src="{{ asset('img/carrusel/slider.avif') }}" class="block w-full object-cover" style="height: 300px;">
        </div>
        <label for="carousel-3"
            class="prev control-1 w-10 h-10 ml-2 md:ml-10 absolute cursor-pointer hidden text-3xl font-bold text-black hover:text-white rounded-full bg-white hover:bg-navbar leading-tight text-center z-10 inset-y-0 left-0 my-auto">‹</label>
        <label for="carousel-2"
            class="next control-1 w-10 h-10 mr-2 md:mr-10 absolute cursor-pointer hidden text-3xl font-bold text-black hover:text-white rounded-full bg-white hover:bg-navbar leading-tight text-center z-10 inset-y-0 right-0 my-auto">›</label>

        <input class="carousel-open" type="radio" id="carousel-2" name="carousel" aria-hidden="true" hidden="">
        <div class="carousel-item absolute opacity-0" style="height:300px;">
            <img src="{{ asset('img/carrusel/slider2.avif') }}" class="block w-full object-cover"
                style="height: 300px;">
        </div>
        <label for="carousel-1"
            class="prev control-2 w-10 h-10 ml-2 md:ml-10 absolute cursor-pointer hidden text-3xl font-bold text-black hover:text-white rounded-full bg-white hover:bg-navbar leading-tight text-center z-10 inset-y-0 left-0 my-auto">‹</label>
        <label for="carousel-3"
            class="next control-2 w-10 h-10 mr-2 md:mr-10 absolute cursor-pointer hidden text-3xl font-bold text-black hover:text-white rounded-full bg-white hover:bg-navbar leading-tight text-center z-10 inset-y-0 right-0 my-auto">›</label>

        <input class="carousel-open" type="radio" id="carousel-3" name="carousel" aria-hidden="true" hidden="">
        <div class="carousel-item absolute opacity-0" style="height:300px;">
            <img src="{{ asset('img/carrusel/33.png') }}" class="block w-full object-cover" style="height: 300px;">
        </div>
        <label for="carousel-2"
            class="prev control-3 w-10 h-10 ml-2 md:ml-10 absolute cursor-pointer hidden text-3xl font-bold text-black hover:text-white rounded-full bg-white hover:bg-navbar leading-tight text-center z-10 inset-y-0 left-0 my-auto">‹</label>
        <label for="carousel-1"
            class="next control-3 w-10 h-10 mr-2 md:mr-10 absolute cursor-pointer hidden text-3xl font-bold text-black hover:text-white rounded-full bg-white hover:bg-navbar leading-tight text-center z-10 inset-y-0 right-0 my-auto">›</label>
        <ol class="carousel-indicators">
            <li class="inline-block mr-3">
                <label for="carousel-1" class="carousel-bullet cursor-pointer block text-4xl text-white ">•</label>
            </li>
            <li class="inline-block mr-3">
                <label for="carousel-2" class="carousel-bullet cursor-pointer block text-4xl text-white ">•</label>
            </li>
            <li class="inline-block mr-3">
                <label for="carousel-3" class="carousel-bullet cursor-pointer block text-4xl text-white ">•</label>
            </li>
        </ol>
    </div>
</div>
<style>
    .carousel-open:checked+.carousel-item {
        position: static;
        opacity: 100;
    }

    .carousel-item {
        -webkit-transition: opacity 0.6s ease-out;
        transition: opacity 0.6s ease-out;
    }

    #carousel-1:checked~.control-1,
    #carousel-2:checked~.control-2,
    #carousel-3:checked~.control-3 {
        display: block;
    }

    .carousel-indicators {
        list-style: none;
        margin: 0;
        padding: 0;
        position: absolute;
        bottom: 2%;
        left: 0;
        right: 0;
        text-align: center;
        z-index: 10;
    }

    #carousel-1:checked~.control-1~.carousel-indicators li:nth-child(1) .carousel-bullet,
    #carousel-2:checked~.control-2~.carousel-indicators li:nth-child(2) .carousel-bullet,
    #carousel-3:checked~.control-3~.carousel-indicators li:nth-child(3) .carousel-bullet {
        color: #932F6D;
    }
</style>
<script>
    let currentIndex = 0;
    const radioButtons = document.querySelectorAll('.carousel-open');

    function changeSlide() {
        radioButtons[currentIndex].checked = false;
        currentIndex = (currentIndex + 1) % radioButtons.length;
        radioButtons[currentIndex].checked = true;
    }

    setInterval(changeSlide, 3000); // Cambia de imagen cada 3 segundos
</script>
