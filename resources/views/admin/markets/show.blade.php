@extends('layouts.admin')

@section('title', 'Item Detail')

@section('content')
<div class="p-4" style="overflow-y: auto; height: 100%;">

    {{-- ── Breadcrumb ── --}}
    <nav class="mb-3" style="font-size:0.82rem;">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.markets.index') }}" class="text-decoration-none">Market</a>
            </li>
            <li class="breadcrumb-item active">Item Detail</li>
        </ol>
    </nav>

    {{-- ── Header ── --}}
    <div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-2">
        <div>
            <h4 class="fw-bold mb-1">{{ $item['name'] }}</h4>
            <p class="text-muted mb-0" style="font-size:0.85rem;">
                {{ $item['category'] }} · Posted: {{ $item['posted_at'] }}
            </p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-secondary btn-sm px-3">Edit</button>
            <button class="btn btn-outline-danger btn-sm px-3">Delete</button>
        </div>
    </div>

    <div class="row g-4">

        {{-- ── Left Column: Item Info ── --}}
        <div class="col-12 col-lg-7">

            {{-- Photos --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-3">
                    <h6 class="fw-bold mb-3">Photos</h6>

                    @if(count($item['images']) > 0)
                        {{-- Main photo --}}
                        <div class="bg-light rounded overflow-hidden mb-2" style="height:260px;">
                            <img src="{{ $item['images'][0] }}" alt="{{ $item['name'] }}"
                                 class="w-100 h-100" style="object-fit:cover;" id="mainPhoto">
                        </div>
                        {{-- Thumbnails --}}
                        @if(count($item['images']) > 1)
                        <div class="d-flex gap-2 flex-wrap">
                            @foreach($item['images'] as $index => $imageUrl)
                            <div class="bg-light rounded overflow-hidden flex-shrink-0"
                                 style="width:68px;height:68px;cursor:pointer;
                                        {{ $index === 0 ? 'border:2px solid #212529;' : '' }}"
                                 onclick="document.getElementById('mainPhoto').src = '{{ $imageUrl }}'">
                                <img src="{{ $imageUrl }}" class="w-100 h-100" style="object-fit:cover;">
                            </div>
                            @endforeach
                        </div>
                        @endif
                    @else
                        <div class="bg-light rounded d-flex align-items-center justify-content-center"
                             style="height:260px;">
                            <div class="text-center text-muted">
                                <i class="fa-solid fa-image fa-3x mb-2"></i>
                                <p class="mb-0" style="font-size:0.8rem;">No photos</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Item info --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-3">
                    <h6 class="fw-bold mb-3">Item Information</h6>
                    <table class="table table-sm mb-0" style="font-size:0.85rem;">
                        <tbody>
                            <tr>
                                <td class="text-muted" style="width:120px;">Item Name</td>
                                <td class="fw-medium">{{ $item['name'] }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Category</td>
                                <td>{{ $item['category'] }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Condition</td>
                                <td>{{ $item['condition'] }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Status</td>
                                <td>
                                    @php
                                    $statusBg = match($item['status']) {
                                        'Active'  => 'success',
                                        'Sold'    => 'primary',
                                        'Unknown' => 'secondary',
                                        default   => 'secondary',
                                    };
                                    @endphp
                                    <span class="badge bg-{{ $statusBg }}">{{ $item['status'] }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted">Posted</td>
                                <td>{{ $item['posted_at'] }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Pickup Location</td>
                                <td>{{ $item['location'] }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Description --}}
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <h6 class="fw-bold mb-3">Description</h6>
                    <p class="mb-0" style="font-size:0.85rem;line-height:1.7;">
                        {{ $item['description'] }}
                    </p>
                </div>
            </div>
        </div>

        {{-- ── Right Column: Seller & Comments ── --}}
        <div class="col-12 col-lg-5">

            {{-- Seller info --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-3">
                    <h6 class="fw-bold mb-3">Seller</h6>
                    <div class="d-flex align-items-center gap-3">
                        <span style="display:inline-flex;align-items:center;justify-content:center;
                                     width:44px;height:44px;border-radius:50%;background:#dee2e6;
                                     font-size:1rem;font-weight:bold;color:#495057;flex-shrink:0;">
                            {{ strtoupper(substr($item['user'], 0, 1)) }}
                        </span>
                        <div>
                            <div class="fw-medium">{{ $item['user'] }}</div>
                            <div class="text-muted" style="font-size:0.78rem;">{{ $item['handle'] }}</div>
                        </div>
                        <a href="#" class="btn btn-outline-secondary btn-sm ms-auto py-0 px-2"
                           style="font-size:0.75rem;">Profile</a>
                    </div>
                </div>
            </div>

            {{-- Comments --}}
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold mb-0">
                            Comments
                            <span class="badge bg-secondary ms-1" style="font-size:0.72rem;">
                                {{ count($item['comments']) }}
                            </span>
                        </h6>
                        <div class="d-flex gap-2">
                            <select class="form-select form-select-sm" style="width:auto;font-size:0.75rem;">
                                <option>All</option>
                                <option>Approved</option>
                                <option>Pending</option>
                                <option>Spam</option>
                            </select>
                        </div>
                    </div>

                    {{-- Comment list --}}
                    <div class="d-flex flex-column gap-3">
                        @forelse($item['comments'] as $comment)
                        @php
                        $statusBg = match($comment['status']) {
                            'Approved' => 'success',
                            'Pending'  => 'warning',
                            'Spam'     => 'danger',
                            default    => 'secondary',
                        };
                        @endphp
                        <div class="p-2 rounded {{ $comment['status'] === 'Spam' ? 'bg-danger bg-opacity-10 border border-danger border-opacity-25' : 'bg-light' }}">
                            {{-- Comment header --}}
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span style="display:inline-flex;align-items:center;justify-content:center;
                                             width:28px;height:28px;border-radius:50%;background:#dee2e6;
                                             font-size:0.7rem;font-weight:bold;color:#495057;flex-shrink:0;">
                                    {{ strtoupper(substr($comment['user'], 0, 1)) }}
                                </span>
                                <div class="flex-grow-1">
                                    <span class="fw-medium" style="font-size:0.78rem;">{{ $comment['user'] }}</span>
                                    <span class="text-muted ms-1" style="font-size:0.72rem;">{{ $comment['handle'] }}</span>
                                </div>
                                <span class="badge bg-{{ $statusBg }}" style="font-size:0.65rem;">
                                    {{ $comment['status'] }}
                                </span>
                            </div>
                            {{-- Comment body --}}
                            <p class="mb-2" style="font-size:0.82rem;">{{ $comment['text'] }}</p>
                            {{-- Comment footer --}}
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted" style="font-size:0.72rem;">{{ $comment['date'] }}</span>
                                <div class="d-flex gap-1">
                                    <button class="btn btn-outline-secondary btn-sm py-0 px-2"
                                            style="font-size:0.68rem;">Edit</button>
                                    <button class="btn btn-outline-danger btn-sm py-0 px-2"
                                            style="font-size:0.68rem;">Delete</button>
                                </div>
                            </div>
                        </div>
                        @empty
                        <p class="text-muted text-center py-3 mb-0" style="font-size:0.82rem;">No comments yet.</p>
                        @endforelse
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection