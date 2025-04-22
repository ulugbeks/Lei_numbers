@extends('layouts.app')

@section('title', 'Home')

@section('content')

@include('partials.header')
<main>
    <!-- Breadcrumb -->
    <section class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-content">
                        <h2 class="title">{{ $page->title }}</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $page->title }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb End -->

    <!-- Page Content -->
    <section class="about-area pt-100 pb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="about-content">
                        {!! $content['main_content'] ?? '' !!}
                    </div>
                </div>
            </div>
            
            @if(isset($content['faqs']) && count($content['faqs']) > 0)
            <div class="row mt-5">
                <div class="col-lg-12">
                    <h3 class="mb-4">Frequently Asked Questions</h3>
                    <div class="accordion" id="faqAccordion">
                        @foreach($content['faqs'] as $index => $faq)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading{{ $index }}">
                                <button class="accordion-button {{ $index > 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="collapse{{ $index }}">
                                    {{ $faq['question'] }}
                                </button>
                            </h2>
                            <div id="collapse{{ $index }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" aria-labelledby="heading{{ $index }}" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    {!! $faq['answer'] !!}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
    </section>
    <!-- Page Content End -->
</main>

@include('partials.footer')
@endsection