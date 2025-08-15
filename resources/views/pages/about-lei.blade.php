@extends('layouts.app')

@section('title', $page->meta_title ?? $page->title ?? 'About LEI')

@section('content')

@include('partials.header')

<!-- main-area -->
<main class="fix">

	<!-- breadcrumb-area -->
	<section class="breadcrumb-area breadcrumb-bg" data-background="assets/img/bg/breadcrumb_bg.jpg">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="breadcrumb-content">
						<h2 class="title">{{ $page->title ?? 'About LEI' }}</h2>
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
								<li class="breadcrumb-item active" aria-current="page">{{ $page->title ?? 'About LEI' }}</li>
							</ol>
						</nav>
					</div>
				</div>
			</div>
		</div>
		<div class="breadcrumb-shape-wrap">
			<img src="assets/img/images/breadcrumb_shape01.png" alt="">
			<img src="assets/img/images/breadcrumb_shape02.png" alt="">
		</div>
	</section>
	<!-- breadcrumb-area-end -->

	<!-- faq-area -->
	<section class="faq-area section-py-120">
		<div class="container">
			<div class="row align-items-end justify-content-center">
				<div class="col-lg-12">
					<div class="faq-content">
						{!! $content['main_content'] ?? '' !!}
                        
                        @if(!empty($content['faqs']))
                            <div class="mt-5">
                                <!-- <h2>Frequently Asked Questions</h2> -->
                                <div class="accordion" id="leiAccordion">
                                    @foreach($content['faqs'] as $index => $faq)
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button {{ $index > 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#leiFaq{{ $index }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}">
                                                {{ $faq['question'] }}
                                            </button>
                                        </h2>
                                        <div id="leiFaq{{ $index }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" data-bs-parent="#leiAccordion">
                                            <div class="accordion-body">
                                                {!! $faq['answer'] !!}
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
					</div>
				</div>
			</div>
		</div>
    </section>
    <!-- faq-area-end -->
</main>
<!-- main-area-end -->

@include('partials.footer')

@endsection