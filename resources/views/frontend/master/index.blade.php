@extends('frontend.master.master')

@section('keyTitle','Home')

@section('contents')
@include('frontend.contents.popup') 

 @include('frontend.contents.slider') 
  @include('frontend.contents.featured')
    @include('frontend.contents.category-slider2')

  @include('frontend.contents.sbann')
@include('frontend.contents.new_arrivals')

{{-- @include('frontend.contents.best_selling_products') --}}
{{-- @include('frontend.contents.video') --}}
{{--@include('frontend.contents.category_slider')
@include('frontend.contents.amenities')
@include('frontend.contents.special_banner') --}}









@endsection
