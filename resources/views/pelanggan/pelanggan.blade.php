@include('header')
@include('nav')

@if (Session::has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ Session::get('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@php
$userId = Auth::id();
    $categories = \App\Models\Category::where('user_id', $userId)->get();
    $products = \App\Models\Product::where('user_id', $userId)->get();
@endphp


@include('footer')