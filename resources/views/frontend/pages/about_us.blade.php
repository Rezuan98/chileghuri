@extends('frontend.master.master')
@section('keyTitle','About Us')

@push('ecomcss')
<style>
:root{
  --brand:#9A0000;          /* Meron */
  --brand-dark:#4f0808;     /* Deep meron */
  --ink:#0f1115;            /* Body text */
  --muted:#6c757d;          /* Secondary */
  --card:#ffffff;
  --line:#ECEEF2;
  --bg:#f6f7fb;
}

/* Page */
.about-page{
  background:
    radial-gradient(1200px 600px at 90% -10%, rgba(154,0,0,.06), transparent 60%),
    linear-gradient(180deg, #fafbff 0%, var(--bg) 100%);
  padding: 56px 0 88px;
}

/* Card */
.card-neutral{
  background: var(--card);
  border: 1px solid var(--line);
  border-radius: 16px;
  box-shadow: 0 10px 30px rgba(16,20,40,.04);
}

/* Headers */
.kicker{
  display:inline-flex; align-items:center; gap:.5rem;
  padding:.35rem .75rem; border-radius:999px;
  font-weight:600; font-size:.8rem; letter-spacing:.02em;
  color:#fff; background:linear-gradient(135deg,var(--brand),var(--brand-dark));
}
.section-title{ font-weight:800; color:var(--ink); margin:.6rem 0 .25rem; letter-spacing:-.02em; }
.section-subtitle{ color:var(--muted); margin:0 0 1.25rem; }

/* Button */
.btn-neutral{
  background: var(--ink); color:#fff; border:0; font-weight:600;
  padding:.85rem 1.25rem; border-radius:999px;
  transition: transform .2s ease, box-shadow .25s ease, opacity .2s ease;
}
.btn-neutral:hover{ transform: translateY(-2px); box-shadow:0 10px 24px rgba(0,0,0,.12); }
.btn-accent{
  background: linear-gradient(135deg,var(--brand),var(--brand-dark));
}

/* HERO */
.about-hero .copy{
  padding: clamp(20px,2vw,28px) clamp(20px,2vw,32px);
}
.about-hero ul{ color:var(--muted); margin:0; padding-left:1.1rem; }
.about-hero li{ margin:.4rem 0; }
.hero-card{
  position:relative; overflow:hidden; border-radius:16px; height:100%;
  background:linear-gradient(180deg, rgba(154,0,0,.08), rgba(154,0,0,.02));
  border:1px solid var(--line);
}
.hero-img{
  width:100%; height:100%; object-fit:cover; min-height:360px; border-radius:14px;
  mask-image: linear-gradient(to bottom, rgba(0,0,0,.95), rgba(0,0,0,.92));
}
.ribbon{
  position:absolute; left:18px; top:18px; z-index:2;
  background:#fff; border:1px solid var(--line); border-radius:999px;
  padding:.35rem .65rem; font-size:.8rem; font-weight:600; color:var(--brand-dark);
  box-shadow:0 6px 18px rgba(16,20,40,.06);
}
.angle{
  position:absolute; inset:auto -30% -30% auto; width:70%; height:60%;
  background: radial-gradient(60% 60% at 40% 50%, rgba(154,0,0,.16), transparent 70%);
  transform: rotate(-12deg);
}

/* STATS */
.stat{
  text-align:center; padding:18px 12px;
  border:1px solid var(--line); border-radius:14px; background:#fff;
}
.stat h3{ margin:0; font-weight:900; letter-spacing:-.02em; color:var(--ink); font-size: clamp(1.4rem, 2.3vw, 1.8rem); }
.stat p{ margin:.2rem 0 0; color:var(--muted); }

/* STORY */
.story-block{ padding: clamp(22px, 3vw, 38px); }
.story-block p{ color:#485060; line-height:1.8; }
.story-highlight{
  background: linear-gradient(180deg,#fff, #fafbfd);
  border:1px dashed var(--line); border-radius:14px; padding:1rem 1.1rem;
}
.story-quote{
  border-left:4px solid var(--brand); padding-left:14px; color:#2b2f39; font-weight:600;
}

/* TIMELINE */
.timeline{
  position:relative; padding-left:26px; margin-top:6px;
}
.timeline:before{
  content:""; position:absolute; left:10px; top:2px; bottom:2px; width:2px; background:linear-gradient(var(--brand),var(--brand-dark));
  border-radius:2px; opacity:.6;
}
.tl-item{ position:relative; margin:16px 0; }
.tl-item:before{
  content:""; position:absolute; left:-2px; top:.35rem; width:10px; height:10px; border-radius:50%;
  background:#fff; border:2px solid var(--brand);
  box-shadow:0 0 0 4px rgba(154,0,0,.08);
}
.tl-title{ font-weight:700; color:var(--ink); margin-bottom:4px; }
.tl-sub{ color:var(--muted); margin:0; }

/* VALUES */
.value{
  display:flex; gap:14px; align-items:flex-start;
}
.value-icon{
  width:48px; height:48px; border-radius:12px; flex:0 0 48px;
  background: linear-gradient(135deg, rgba(154,0,0,.12), rgba(154,0,0,.04));
  display:flex; align-items:center; justify-content:center;
  border:1px solid var(--line);
}
.value h5{ margin:2px 0 6px; font-weight:700; }
.value p{ color:var(--muted); margin:0; }

/* CTA */
.cta{
  background:
    linear-gradient(135deg, rgba(154,0,0,.10), rgba(79,8,8,.10)),
    #fff;
  border:1px solid var(--line); border-radius:16px;
}

/* Responsive */
@media (max-width: 991px){
  .hero-img{ min-height:300px; }
}
@media (prefers-reduced-motion: reduce){
  .btn-neutral:hover{ transform:none; box-shadow:none; }
}
</style>
@endpush

@section('contents')
<section class="about-page">
  <div class="container">

    {{-- HERO: Copy + Image --}}
    <div class="row g-4 align-items-stretch about-hero">
      <div class="col-lg-6">
        <div class="card-neutral h-100">
          <div class="copy">
            <span class="kicker">About Chileghuri</span>
            <h1 class="section-title">Shopping that feels personal, fast, and fair</h1>
            <p class="section-subtitle">We blend quality curation with transparent service—so every order feels effortless.</p>

            <p class="mb-3">
              At <strong>Chileghuri</strong>, we’re obsessed with removing friction. From honest product pages to reliable logistics and helpful humans, we focus on the little details that make a big difference.
            </p>
            <ul class="mb-4">
              <li>Authentic products from trusted partners</li>
              <li>Clear ETAs and proactive updates</li>
              <li>Friendly support that actually solves problems</li>
            </ul>

            <div class="d-flex flex-wrap gap-2">
              <a href="{{ route('contact.us') }}" class="btn btn-neutral">Contact our team</a>
              <a href="{{ route('home') }}" class="btn btn-neutral btn-accent">Browse products</a>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="hero-card">
          <span class="ribbon">Trusted by thousands</span>
          <span class="angle"></span>
          <img
            src="{{ asset('frontend/images/about-hero.jpg') }}"
            alt="Chileghuri team and products"
            class="hero-img"
            loading="lazy">
        </div>
      </div>
    </div>

    {{-- STATS --}}
   

    
    



  </div>
</section>
@endsection

@push('ecomjs')
<script>
// (Optional) add tiny hover lift to cards
document.querySelectorAll('.card-neutral').forEach(c=>{
  c.addEventListener('mouseenter',()=> c.style.boxShadow='0 14px 38px rgba(16,20,40,.09)');
  c.addEventListener('mouseleave',()=> c.style.boxShadow='0 10px 30px rgba(16,20,40,.04)');
});
</script>
@endpush
