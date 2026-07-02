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
            <div class="col-12 col-md-8 col-lg-6" data-aos="fade-up" data-aos-delay="100">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden hs-card">
                    <div class="hs-image-container hs-image-container--gallery">
                        @include('healthcare.partials._hospital_gallery', ['hospital' => $hospital])
                    </div>

                    <div class="card-body p-4">
                        @include('healthcare.partials._hospital_badges', ['hospital' => $hospital])

                        <h5 class="fw-bold mb-3">{{ $hospital->short_name ?? $hospital->name }}</h5>

                        <div class="small text-muted mb-2">
                            @if($hospital->duration_grab)
                                <div class="mb-2"><i class="fa-solid fa-car me-2"></i>{{ __('healthcare.travel.grab', ['minutes' => $hospital->duration_grab]) }}</div>
                            @endif
                            @if($hospital->duration_walk)
                                <div class="mb-2"><i class="fa-solid fa-person-walking me-2"></i>{{ __('healthcare.travel.walk', ['minutes' => $hospital->duration_walk]) }}</div>
                            @endif
                        </div>

                        @include('healthcare.partials._hospital_hours', ['hospital' => $hospital])

                        @if($hospital->guideTips())
                            <div class="alert alert-light border small mb-3 mt-3">
                                {{ $hospital->guideTips() }}
                            </div>
                        @endif

                        <div class="d-grid gap-2">
                            <a href="{{ route('healthcare.index') }}#hospital-list" class="btn btn-outline-secondary">
                                {{ __('healthcare.action.view_list') }}
                            </a>
                            @if(!$hospital->is_clinic && $hospital->grab_link)
                                <a href="{{ $hospital->grab_link }}"
                                   class="btn btn-success fw-bold hs-grab-link"
                                   data-loader-text="{{ __('healthcare.grab.loading') }}"
                                   target="_blank"
                                   rel="noopener noreferrer">
                                    <i class="fa-solid fa-location-arrow me-1"></i>{{ __('healthcare.action.grab') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <p class="text-center text-muted" data-aos="fade-up">
            {{ __('healthcare.wizard.no_result') }}
        </p>
    @endif

    <div class="text-center mt-4" data-aos="fade-up" data-aos-delay="200">
        <a href="{{ route('wizard.start') }}" class="btn btn-link text-muted">{{ __('healthcare.wizard.retry') }}</a>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        if (typeof AOS !== 'undefined') {
            AOS.refresh();
        }
    });
</script>
@endpush
