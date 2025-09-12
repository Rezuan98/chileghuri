{{-- Updated frontend/contents/facebook_reviews.blade.php --}}

@push('ecomcss')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css">

<style>
.facebook-reviews { padding: 60px 0; background: #f8f9fa; }
.review-section-header {
    margin-bottom: 15px;
    margin-top:15px;
}

.review-section-title {
    font-family:"Conthic", sans-serif; font-weight:400;
    font-size: 30px;
    text-align: left;
    margin: 0;
    padding-bottom: 10px;
    border-bottom: 1px solid #ccc;
    width: 100%;
}
.reviews-slider { position: relative; padding: 0 0px; }
.review-slide { padding: 0 4px; outline: none; } /* Reduced from 8px to 4px */
.review-card { background: white; border-radius: 12px; padding: 0; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border: 1px solid #e4e6ea; transition: all 0.3s ease; height: 320px; overflow: hidden; }
.review-card:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
.facebook-embed { width: 100%; height: 100%; border-radius: 12px; overflow: hidden; }
.facebook-embed iframe { width: 100% !important; height: 320px !important; border: none; border-radius: 12px; }
.reviews-slider .slick-prev, .reviews-slider .slick-next { position: absolute; top: 50%; transform: translateY(-50%); z-index: 100; width: 40px; height: 40px; border: none; border-radius: 50%; background: white; color: #1c1e21; cursor: pointer; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(0,0,0,0.15); transition: all 0.3s ease; }
.reviews-slider .slick-prev:hover, .reviews-slider .slick-next:hover { background: #f0f2f5; transform: translateY(-50%) scale(1.1); }
.reviews-slider .slick-prev { left: 10px; }
.reviews-slider .slick-next { right: 10px; }
.reviews-slider .slick-prev:before, .reviews-slider .slick-next:before { display: none; }
.reviews-slider .slick-prev i, .reviews-slider .slick-next i { font-size: 16px; line-height: 1; }
.reviews-slider .slick-dots { bottom: -50px; display: flex !important; justify-content: center; gap: 8px; list-style: none; padding: 0; margin: 0; }
.reviews-slider .slick-dots li { width: auto; height: auto; margin: 0; }
.reviews-slider .slick-dots li button { width: 8px; height: 8px; border-radius: 50%; background: #bcc0c4; border: none; font-size: 0; padding: 0; transition: all 0.3s ease; }
.reviews-slider .slick-dots li button:before { display: none; }
.reviews-slider .slick-dots li.slick-active button { background: #1877f2; transform: scale(1.5); }
.view-all-btn { display: inline-flex; align-items: center; gap: 8px; background: #000; color: white; padding: 12px 24px; border-radius: 6px; text-decoration: none; font-weight: 500; transition: all 0.3s ease; margin-top: 40px; }
.view-all-btn:hover { background: #166fe5; color: white; text-decoration: none; }

/* Responsive adjustments */
@media (max-width: 1200px) { 
    .reviews-slider { padding: 0 30px; } 
    .review-slide { padding: 0 3px; } /* Further reduced spacing on smaller screens */
}
@media (max-width: 992px) { 
    .reviews-slider { padding: 0 25px; } 
    .review-card { height: 300px; } 
    .facebook-embed iframe { height: 300px !important; } 
    .review-slide { padding: 0 3px; }
}
@media (max-width: 768px) { 
    .reviews-slider { padding: 0 20px; } 
    .review-card { height: 280px; } 
    .facebook-embed iframe { height: 280px !important; } 
    .review-slide { padding: 0 2px; }
}
@media (max-width: 576px) { 
    .reviews-slider .slick-prev, .reviews-slider .slick-next { display: none !important; } 
    .review-card { height: 260px; } 
    .facebook-embed iframe { height: 260px !important; } 
    .review-slide { padding: 0 2px; }
    .reviews-slider { padding: 0 10px; }
}
</style>
@endpush

<section class="facebook-reviews">
    <div class="container-fluid">
        <div class="review-section-header">
            <h2 class="review-section-title">
                <i class="fab fa-facebook"></i>
                Customer Reviews
            </h2>
        </div>

        @if($reviews->isNotEmpty())
        <div class="reviews-slider">
            @foreach($reviews as $review)
            <div class="review-slide">
                <div class="review-card">
                    <div class="facebook-embed">
                        {!! $review->embed_code !!}
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @if($reviews->first() && $reviews->first()->all_review_link)
        <div class="text-center">
            <a href="{{ $reviews->first()->all_review_link }}" target="_blank" class="view-all-btn">
                <i class="fab fa-facebook"></i>
                <span>View All Reviews</span>
            </a>
        </div>
        @endif
        @endif
    </div>
</section>

@push('ecomjs')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script>
$(function(){
    $('.reviews-slider').slick({
        infinite: true,
        autoplay: true,
        autoplaySpeed: 4000,
        speed: 600,
        slidesToShow: 4,
        slidesToScroll: 1,
        dots: true,
        arrows: true,
        pauseOnHover: true,
        prevArrow: '<button type="button" class="slick-prev" aria-label="Previous"><i class="fas fa-chevron-left"></i></button>',
        nextArrow: '<button type="button" class="slick-next" aria-label="Next"><i class="fas fa-chevron-right"></i></button>',
        responsive: [
            { 
                breakpoint: 1400, 
                settings: { 
                    slidesToShow: 4, 
                    slidesToScroll: 1 
                } 
            },
            { 
                breakpoint: 1200, 
                settings: { 
                    slidesToShow: 3, 
                    slidesToScroll: 1 
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
                breakpoint: 768, 
                settings: { 
                    slidesToShow: 2, 
                    slidesToScroll: 1 
                } 
            },
            { 
                breakpoint: 576, 
                settings: { 
                    slidesToShow: 1, 
                    slidesToScroll: 1, 
                    arrows: false 
                } 
            }
        ]
    });
});
</script>
@endpush