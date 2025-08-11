@push('ecomcss')
    <!-- Font Awesome (for arrow icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- Slick CSS first -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css">

    <style>
        html, body { overflow-x: hidden; }
        .catx-section {
            padding: 60px 0 80px;
            /* space for dots */
            /* background:linear-gradient(135deg,#f8f9fa 0%,#e9ecef 100%); */
        }

        .catx-title {
            text-align: center;
            margin-bottom: 50px;
            display: flex;
  align-items: center;
  text-align: center;
  margin: 50px 0;

        }

        
  

.catx-title::before,
.catx-title::after {
  content: "";
  flex: 1;
  border-bottom: 1px solid #8c7d7d;
}

        .catx-title h2 {
              font-family: "Faculty Glyphic", serif;
  font-size: 1.2rem;
  font-weight: 700;
  padding: 0 20px;
  color: #f2f2f2; /* Or use var(--primary-color) */
  letter-spacing: 1px;
  white-space: nowrap;
  border: 1px solid #987777;
  padding: 6px 20px;
  background-color: #9a0000;
        }

        .catx-title p {
            font-size: 16px;
            color: #6c757d;
            max-width: 600px;
            margin: 0 auto;
        }

        /* Give arrows breathing room */
        .catx-slider {
            position: relative;
            padding: 0 32px;
        }

        .catx-item {
            padding: 0 5px;
            outline: none;
        }

        .catx-card {
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0, 0, 0, .1);
            transition: transform .3s, box-shadow .3s;
            position: relative;
        }

        .catx-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 40px rgba(0, 0, 0, .18);
        }

        /* Slightly shorter than earlier */
        .catx-image {
            width: 100%;
            aspect-ratio: 5 / 7.4;
            position: relative;
            overflow: hidden;
        }

        .catx-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .3s;
        }

        .catx-card:hover .catx-image img {
            transform: scale(1.05);
        }

        /* Bottom name bar */
        .catx-namebar {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            padding: 12px 16px;
            background: linear-gradient(to top, rgba(0, 0, 0, .65), rgba(0, 0, 0, 0));
            color: #fff;
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }

        .catx-name {
            font-size: 18px;
            font-weight: 700;
        }

        .catx-count {
            font-size: 13px;
            opacity: .9;
        }

        /* Arrows (scoped, follow-up colors) */
        .catx-slider .slick-prev,
        .catx-slider .slick-next {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 100;
            width: 46px;
            height: 46px;
            border: none;
            border-radius: 50%;
            background: #e4c01f;
            color: #fff;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 16px rgba(0, 0, 0, .15);
        }

        .catx-slider .slick-prev:hover,
        .catx-slider .slick-next:hover {
            background: #719612;
        }

        .catx-slider .slick-prev {
            left: 0;
        }

        .catx-slider .slick-next {
            right: 0;
        }

        .catx-slider .slick-prev:before,
        .catx-slider .slick-next:before {
            display: none;
        }

        .catx-slider .slick-prev i,
        .catx-slider .slick-next i {
            font-size: 18px;
            line-height: 1;
        }

        /* Dots (follow-up color for active) */
        .catx-slider .slick-dots {
            bottom: -30px;
        }

        .catx-slider .slick-dots li button {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #ddd;
            border: none;
        }

        .catx-slider .slick-dots li button:before {
            display: none;
        }

        .catx-slider .slick-dots li.slick-active button {
            background: #e4c01f;
            transform: scale(1.2);
        }

        /* Responsive tweaks */
        @media (max-width: 992px) {
            .catx-name {
                font-size: 16px;
            }
        }

        @media (max-width: 576px) {

            .catx-slider .slick-prev,
            .catx-slider .slick-next {
                width: 40px;
                height: 40px;
            }
            .catx-title h2{
                padding: 5px;
        font-family:"Faculty Glyphic", serif;
        margin: 0px 0;
        font-size: 12px;
            }

            .catx-slider .slick-prev {
                left: 0;
            }

            .catx-slider .slick-next {
                right: 0;
            }
            .catx-item {
            padding: 0 0px;
            outline: none;
        }
        }
    </style>
@endpush


<section class="catx-section">
    <div class="container">
        <div class="catx-title">
            <h2>Shop by Category</h2>
        </div>

        @php
            // Fallback images (used if a category has no image, or when cycling)
            $fallbackImages = [
                'frontend/images/ch1.jpg',
                'frontend/images/ch2.jpg',
                'frontend/images/ch3.jpg',
                'frontend/images/ch1.jpg',
                'frontend/images/ch2.jpg',
            ];

            // Use the collection you pass directly
            $items      = collect($sliderCategory ?? []);
            $itemCount  = $items->count();
            $slideCount = max(5, $itemCount ?: 5); // ensure ≥ 5 slides so arrows/dots appear
        @endphp

        <div class="catx-slider">
            @for ($i = 0; $i < $slideCount; $i++)
                @php
                    // Cycle when fewer than $slideCount
                    $cat   = $itemCount ? $items[$i % $itemCount] : null;
                    $name  = $cat->name ?? 'Category';
                    $count = isset($cat->products_count) ? $cat->products_count : null;

                    // Resolve image (support remote URL or local storage path)
                    $rawImg = $cat->icon ?? null;

                    if ($rawImg) {
                        $isRemote  = (strpos($rawImg, 'http://') === 0) || (strpos($rawImg, 'https://') === 0);
                        if ($isRemote) {
                            $imgSrc = $rawImg; // use as-is
                        } else {
                            // prefix storage/ if it's a relative path like "categories/x.jpg"
                            $candidate = $rawImg;
                            if (strpos($candidate, '/') !== 0 && strpos($candidate, 'storage/') !== 0) {
                                $candidate = 'storage/' . ltrim($candidate, '/');
                            }
                            $imgSrc = $candidate; // will pass through asset()
                        }
                    } else {
                        $imgSrc  = $fallbackImages[$i % count($fallbackImages)];
                        $isRemote = false;
                    }
                @endphp

                <div class="catx-item">
                    <div class="catx-card">
                        <div class="catx-image">
                            <img
                                src="{{ isset($isRemote) && $isRemote ? $imgSrc : asset($imgSrc) }}"
                                alt="{{ $name }}"
                                onerror="this.onerror=null;this.src='{{ asset($fallbackImages[$i % count($fallbackImages)]) }}';"
                            >
                            <div class="catx-namebar">
                                <div class="catx-name">{{ $name }}</div>

                                @if(!is_null($count))
                                    <div class="catx-count">{{ $count }}+ Products</div>
                                @else
                                    {{-- Keep layout consistent even if no count --}}
                                    <div class="catx-count" style="visibility:hidden">0+ Products</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
    </div>
</section>



@push('ecomjs')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script>
        $(function() {
            $('.catx-slider').slick({
                slidesToShow: 3,
                slidesToScroll: 1,
                infinite: true,
                autoplay: true,
                autoplaySpeed: 3000,
                speed: 500,
                dots: true,
                arrows: true,
                centerMode: false,
                prevArrow: '<button type="button" class="slick-prev" aria-label="Previous"><i class="fa-solid fa-chevron-left"></i></button>',
                nextArrow: '<button type="button" class="slick-next" aria-label="Next"><i class="fa-solid fa-chevron-right"></i></button>',
                responsive: [{
                        breakpoint: 992,
                        settings: {
                            slidesToShow: 2
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            slidesToShow: 1,
                            arrows: false
                        }
                    }
                ]
            });
        });
    </script>
@endpush
