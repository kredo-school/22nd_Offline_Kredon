@extends('layouts.admin')

@section('title', 'Notification')

@section('content')
    <div class="p-4" style="overflow-y: auto; height: 100%;;">
        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <h4 class="fw-bold mb-1">Notification Management</h4>
                <p class="text-muted mb-0" style="font-size:0.85rem;">Each categories are moderated</p>
            </div>
        </div>

        {{-- Metric cards --}}
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-3">
                        <p class="text-muted mb-1" style="font-size:0.78rem;">Total System Notification</p>
                        <h4 class="fw-bold mb-0">14,500</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-3">
                        <p class="text-muted mb-1" style="font-size:0.78rem;">New Notification</p>
                        <h4 class="fw-bold mb-0">14</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-3">
                        <p class="text-muted mb-1" style="font-size:0.78rem;">Blocked</p>
                        <h4 class="fw-bold mb-0">14</h4>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
