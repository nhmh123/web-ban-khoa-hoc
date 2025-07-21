<div class="container-fluid">
    <div class="swiper mySwiper">
        <div class="swiper-wrapper">
            @foreach ($sliders as $slider)
                <div class="swiper-slide">
                    <div class="border rounded-3 w-100 overflow-hidden" style="height: 550px;">
                        <img src="{{ asset($slider->image) }}" alt="Slider {{ $slider->id }}" class="w-100 h-100"
                            style="object-fit: fill;">
                    </div>
                </div>
            @endforeach
        </div>
        <div class="swiper-pagination"></div>
    </div>
</div>
