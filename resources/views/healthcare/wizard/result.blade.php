@extends('layouts.app')

@section('title', __('healthcare.wizard.result_title'))

@section('content')
<div class="container py-5 mt-5">
    <div class="text-center mb-4" data-aos="fade-up">
        <h1 class="fw-bold">{{ __('healthcare.wizard.result_heading') }}</h1>
        <p class="text-muted mb-2">{{ __('healthcare.wizard.result_subheading') }}</p>
        <p class="small text-muted">{{ __('healthcare.wizard.disclaimer') }}</p>
    </div>

    @if($hospital)
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8" data-aos="fade-up" data-aos-delay="100">
                @include('healthcare.partials._hospital_detail', [
                    'hospital' => $hospital,
                    'recommendationReason' => $recommendationReason ?? null,
                    'showJhdDocuments' => $showJhdDocuments ?? false,
                    'backUrl' => route('healthcare.index', ['from_result' => 1]) . '#search-section',
                ])
            </div>
        </div>
    @else
        <p class="text-center text-muted" data-aos="fade-up">
            {{ __('healthcare.wizard.no_result') }}
        </p>

        <div class="text-center mt-4" data-aos="fade-up" data-aos-delay="200">
            <a href="{{ route('healthcare.index', ['from_result' => 1]) }}#search-section"
               class="btn btn-outline-secondary px-4">
                <i class="fa-solid fa-arrow-left me-1" aria-hidden="true"></i>{{ __('healthcare.wizard.back_to_previous') }}
            </a>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        if (typeof AOS !== 'undefined') {
            AOS.refresh();
        }

        document.querySelectorAll('.hs-gallery.carousel').forEach((carouselEl) => {
            carouselEl.addEventListener('slid.bs.carousel', (event) => {
                const counter = carouselEl.querySelector('.hs-gallery__counter-current');
                if (counter) {
                    counter.textContent = event.to + 1;
                }
            });
        });
    });
</script>
@endpush
