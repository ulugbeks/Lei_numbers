@extends('layouts.app')

@section('title', 'Home')

@section('content')

@include('partials.header')

<!-- main-area -->
<main class="fix">

	<!-- breadcrumb-area -->
	<section class="breadcrumb-area breadcrumb-bg" data-background="{{ asset('assets/img/bg/breadcrumb_bg.jpg') }}">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="breadcrumb-content">
						<h2 class="title">Latest Blog</h2>
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
								<li class="breadcrumb-item active" aria-current="page">Blog</li>
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

	<!-- blog-area -->
	<section class="blog-area pt-120 pb-120">
		<div class="container">
			<div class="inner-blog-wrap">
				<div class="row justify-content-center">
					<div class="col-71">
						<div class="blog-post-wrap">
							<div class="row">
								@foreach ($blogs as $blog)
								<div class="col-md-6">
									<div class="blog-post-item-two">
										<div class="blog-post-thumb-two">
											<a href="{{ route('blog.show', $blog->slug) }}">
												<img src="{{ url('storage/' . $blog->image) }}" alt="{{ $blog->title }}">
											</a>
										</div>
										<div class="blog-post-content-two">
											<h2 class="title"><a href="{{ route('blog.show', $blog->slug) }}">{{ $blog->title }}</a></h2>
											<p>{{ Str::limit(strip_tags($blog->content), 100) }}</p>
											<div class="blog-meta">
												<ul class="list-wrap">
													<li><i class="far fa-calendar"></i>
														{{ $blog->formatted_date }}
													</li>
												</ul>
											</div>
										</div>
									</div>
								</div>
								@endforeach
							</div>
							<div class="pagination-wrap mt-30">
								{{ $blogs->links() }}
							</div>
						</div>
					</div>
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
									@if(isset($recentBlogs) && $recentBlogs->count())
									@foreach ($recentBlogs as $recent)
									<div class="rc-post-item">
										<div class="thumb">
											<a href="{{ route('blog.show', $recent->slug) }}">
												<img src="{{ asset('storage/' . $recent->image) }}" alt="{{ $recent->title }}">
											</a>
										</div>
										<div class="content">
											<span class="date">
											    <i class="far fa-calendar"></i>
											    {{ $blog->formatted_date }}
											</span>

											<h2 class="title"><a href="{{ route('blog.show', $recent->slug) }}">{{ $recent->title }}</a></h2>
										</div>
									</div>
									@endforeach
									@else
									<p>No recent posts available.</p>
									@endif
								</div>
							</div>
						</aside>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- blog-area-end -->
</main>
<!-- main-area-end -->

@include('partials.footer')

@endsection