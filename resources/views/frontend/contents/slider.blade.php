<div class="slidercontainer">
    <div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @forelse($sliders as $key => $slider)
            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                @if($slider->link)
                <a href="{{ $slider->link }}">
                    @endif
                    <img src="{{ asset('uploads/sliders/' . $slider->image) }}" style="" class="d-block w-100" alt="{{ $slider->title ?? 'Slide Image' }}">
                    @if($slider->link)
                </a>
                @endif
            </div>
            @empty
            <div class="carousel-item active">
                <img src="#" class="d-block w-100" alt="Default Slide">
            </div>
            @endforelse
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

</div>
@push('ecomcss')
    <style>
        /* .slider-container {
    width: 100%;
   
    overflow: hidden; /* Prevent unwanted scrollbars */
    /* display: flex; */
    /* justify-content: center;
    align-items: center; */
    /* margin-top: 10px; */
    /* height: 400px; */
 

.slidercontainer {
    /* position: relative; */
    
   
    /* display: flex; */
   
    /* height: 400px; */
}

.slidercontainer .carousel-control-prev,
.slidercontainer .carousel-control-next {
    opacity: 0;
    transition: opacity 0.3s ease;
}

.slidercontainer:hover .carousel-control-prev,
.slidercontainer:hover .carousel-control-next {
    opacity: 1;
}

/* Rounded arrows with white background */
.carousel-control-prev-icon,
.carousel-control-next-icon {
    background-color: transparent;
    border-radius: 50%;
    border: 2px solid #f5f5f5;
    width: 40px;
    height: 40px;
    background-size: 100% 100%;
    background-position: center;
    background-repeat: no-repeat;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
}

/* Optional: adjust the button container to center better */
.carousel-control-prev,
.carousel-control-next {
    width: auto;
    padding: 10px;
}

@media (max-width:768px){
  .slider-container{
    height: 100%;
  }

  .slidercontainer .carousel-control-prev,
.slidercontainer .carousel-control-next {
    opacity: 1;
    transition: opacity 0.3s ease;
}


.carousel-control-prev,
.carousel-control-next {
    width: auto;
    padding: 5px;
}

.carousel-control-prev-icon,
.carousel-control-next-icon {
    background-color: transparent;
    border-radius: 50%;
    border: 1px solid #f5f5f5;
    width: 25px;
    height: 25px;
    background-size: 100% 100%;
    background-position: center;
    background-repeat: no-repeat;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
}
/* Add background color on hover */
.carousel-control-prev:hover,
.carousel-control-next:hover {
   
}
}
    </style>
@endpush