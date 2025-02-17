@extends('layouts.app')

@section('title', 'Home')

@section('content')

@include('partials.header')

<!-- main-area -->
<main class="fix">

	<!-- breadcrumb-area -->
	<section class="breadcrumb-area breadcrumb-bg" style="background-image: url('{{ asset('assets/img/bg/breadcrumb_bg.jpg') }}');">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="breadcrumb-content">
						<h2 class="title">{{ $blog->title }}</h2>
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
								<li class="breadcrumb-item"><a href="{{ route('blog.index') }}">Blog</a></li>
								<li class="breadcrumb-item active" aria-current="page">{{ $blog->title }}</li>
							</ol>
						</nav>
					</div>
				</div>
			</div>
		</div>
		<div class="breadcrumb-shape-wrap">
			<img src="{{ asset('assets/img/images/breadcrumb_shape01.png') }}" alt="">
			<img src="{{ asset('assets/img/images/breadcrumb_shape02.png') }}" alt="">
		</div>
	</section>
	<!-- breadcrumb-area-end -->

	<!-- blog-details-area -->
	<section class="blog-details-area pt-120 pb-120">
		<div class="container">
			<div class="blog-details-wrap">
				<div class="row justify-content-center">
					<div class="col-71">
						<div class="blog-details-thumb">
							<img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}">
						</div>
						<div class="blog-details-content">
							<h2 class="title">{{ $blog->title }}</h2>
							<div class="blog-meta-three">
								<ul class="list-wrap">
									<li><i class="far fa-calendar"></i> {{ $blog->created_at->format('d M, Y') }}</li>
								</ul>
							</div>
							{!! $blog->content !!}

							@if($blog->quote)
								<blockquote>
									“{{ $blog->quote }}”
								</blockquote>
							@endif

							@if($blog->subheading)
								<h4 class="title-two">{{ $blog->subheading }}</h4>
								<p>{!! nl2br(e($blog->subcontent)) !!}</p>
							@endif

							@if($blog->video_url)
							<div class="bd-inner-wrap">
								<div class="row align-items-center">
									<div class="col-46">
										<div class="thumb">
											<a href="{{ $blog->video_url }}" class="play-btn popup-video"><i class="fas fa-play"></i></a>
										</div>
									</div>
									<div class="col-54">
										<div class="content">
											<h3 class="title-two">{{ $blog->video_title }}</h3>
											<p>{!! nl2br(e($blog->video_description)) !!}</p>
											<ul class="list-wrap">
												<li><img src="{{ asset('assets/img/icons/check_icon.svg') }}" alt=""> High-Quality Content</li>
												<li><img src="{{ asset('assets/img/icons/check_icon.svg') }}" alt=""> Industry Insights</li>
												<li><img src="{{ asset('assets/img/icons/check_icon.svg') }}" alt=""> Engaging Storytelling</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
							@endif

							<div class="bd-content-bottom">
								<div class="row align-items-center">
									<div class="col-md-12">
										<div class="blog-post-share">
											<h5 class="title">Share:</h5>
											<ul class="list-wrap">
												<li><a href="https://facebook.com/sharer/sharer.php?u={{ url()->current() }}"><i class="fab fa-facebook-f"></i></a></li>
												<li><a href="https://twitter.com/intent/tweet?url={{ url()->current() }}&text={{ $blog->title }}"><i class="fab fa-twitter"></i></a></li>
												<li><a href="https://www.linkedin.com/shareArticle?mini=true&url={{ url()->current() }}"><i class="fab fa-linkedin-in"></i></a></li>
												<li><a href="https://pinterest.com/pin/create/button/?url={{ url()->current() }}&media={{ asset('storage/' . $blog->image) }}&description={{ $blog->title }}"><i class="fab fa-pinterest-p"></i></a></li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- Sidebar -->
					<div class="col-29">
						<aside class="blog-sidebar">
							<div class="sidebar-search">
								<form action="{{ route('blog.index') }}" method="GET">
									<input type="text" name="search" placeholder="Search Here . . .">
									<button type="submit"><i class="flaticon-search"></i></button>
								</form>
							</div>

							<div class="blog-widget">
								<h4 class="bw-title">Recent Posts</h4>
								<div class="rc-post-wrap">
									@foreach($recentBlogs as $recent)
									<div class="rc-post-item">
										<div class="thumb">
											<a href="{{ route('blog.show', $recent->slug) }}"><img src="{{ asset('storage/' . $recent->image) }}" alt="{{ $recent->title }}"></a>
										</div>
										<div class="content">
											<span class="date"><i class="far fa-calendar"></i> {{ $recent->created_at->format('d M, Y') }}</span>
											<h2 class="title"><a href="{{ route('blog.show', $recent->slug) }}">{{ $recent->title }}</a></h2>
										</div>
									</div>
									@endforeach
								</div>
							</div>
						</aside>
					</div>

				</div>
			</div>
		</div>
	</section>
	<!-- blog-details-area-end -->

</main>
<!-- main-area-end -->

@include('partials.footer')

@endsection