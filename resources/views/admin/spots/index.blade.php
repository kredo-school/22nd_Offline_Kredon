@extends('layouts.admin')

@section('title', 'Spot')

@section('content')
    <div class="p-4" style="overflow-y: auto; height: 100%;">
        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <h4 class="fw-bold mb-1">Spot Management</h4>
                <p class="text-muted mb-0" style="font-size:0.85rem;">Manage Working, Tourism, and Hospital spots</p>
            </div>
            {{-- <button type="button" class="btn btn-primary"
                onclick="document.querySelector('[data-bs-target=&quot;#tab-working&quot;]')?.click()">
                <i class="fa-solid fa-plus me-1"></i> New Spot
            </button> --}}
        </div>

        {{-- Category Tabs --}}
        <ul class="nav nav-tabs mb-3" id="spotTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="tab-working-btn" data-bs-toggle="tab" data-bs-target="#tab-working"
                    type="button" role="tab">
                    <i class="fa-solid fa-briefcase me-1"></i> Working
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab-hospital-btn" data-bs-toggle="tab" data-bs-target="#tab-hospital"
                    type="button" role="tab">
                    <i class="fa-solid fa-hospital me-1"></i> Hospital
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab-tourism-btn" data-bs-toggle="tab" data-bs-target="#tab-tourism"
                    type="button" role="tab">
                    <i class="fa-solid fa-map-pin me-1"></i> Tourism
                </button>
            </li>
        </ul>

        <div class="tab-content" id="spotTabsContent">

            {{-- ============ TAB 1: WORKING ============ --}}
            <div class="tab-pane fade show active" id="tab-working" role="tabpanel">

                {{-- Metric cards: status列が無いためDBに実在する値で構成 --}}
                <div class="row g-3 mb-3">
                    <div class="col-12 col-md-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body p-3">
                                <p class="text-muted mb-1" style="font-size:0.8rem;">Total Spots</p>
                                <h4 class="fw-bold mb-0">{{ $workingSpots->count() }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body p-3">
                                <p class="text-muted mb-1" style="font-size:0.8rem;">Published</p>
                                <h4 class="fw-bold mb-0">{{ $workingSpots->where('status', 'published')->count() }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body p-3">
                                <p class="text-muted mb-1" style="font-size:0.8rem;">Draft</p>
                                <h4 class="fw-bold mb-0">{{ $workingSpots->where('status', 'draft')->count() }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body p-3">
                                <p class="text-muted mb-1" style="font-size:0.8rem;">Unpublished</p>
                                <h4 class="fw-bold mb-0">{{ $workingSpots->where('status', 'unpublished')->count() }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">

                        {{-- Filter row: status列が無いため検索のみ --}}
                        <div class="d-flex gap-2 mb-3 flex-wrap">
                            <input type="text" id="working-search" class="form-control form-control-sm flex-grow-1"
                                placeholder="Search by spot name or area..." style="min-width:200px;">
                        </div>

                        <div class="table-responsive">
                            <table class="table align-middle" id="working-table">
                                <thead>
                                    <tr class="text-muted" style="font-size:0.75rem;">
                                        <th>Spot Name</th>
                                        <th>Area</th>
                                        <th>Hours</th>
                                        <th>Evaluation</th>
                                        <th>WiFi</th>
                                        <th>Power</th>
                                        <th>Updated</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody style="font-size:0.875rem;">
                                    @forelse ($workingSpots as $spot)
                                        <tr data-name="{{ strtolower($spot->name . ' ' . $spot->area) }}">
                                            <td class="fw-semibold">
                                                <div class="d-flex align-items-center gap-2">
                                                    @if ($spot->photo_path)
                                                        <img src="{{ asset('storage/' . $spot->photo_path) }}"
                                                            alt="{{ $spot->name }}" class="rounded"
                                                            style="width:32px;height:32px;object-fit:cover;">
                                                    @else
                                                        <span
                                                            class="d-inline-flex align-items-center justify-content-center bg-light rounded"
                                                            style="width:32px;height:32px;color:#adb5bd;">
                                                            <i class="fa-solid fa-image"></i>
                                                        </span>
                                                    @endif
                                                    {{ $spot->name }}
                                                </div>
                                            </td>
                                            <td class="text-muted">{{ $spot->area }}</td>
                                            <td class="text-muted" style="font-size:0.8rem;">{{ $spot->hours ?? '—' }}</td>
                                            <td>
                                                @if ($spot->reviews_count > 0)
                                                    <span style="color:#854F0B; font-size:0.8rem;">
                                                        <i class="fa-solid fa-star"></i>
                                                        {{ number_format($spot->reviews_avg_rating, 1) }}
                                                    </span>
                                                    <span class="text-muted"
                                                        style="font-size:0.72rem;">({{ $spot->reviews_count }})</span>
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($spot->has_wifi)
                                                    <span class="badge rounded-pill"
                                                        style="background-color:#EAF3DE; color:#27500A; font-weight:500;">
                                                        <i class="fa-solid fa-wifi"></i>
                                                    </span>
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($spot->has_power)
                                                    <span class="badge rounded-pill"
                                                        style="background-color:#EAF3DE; color:#27500A; font-weight:500;">
                                                        <i class="fa-solid fa-plug"></i>
                                                    </span>
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td class="text-muted" style="font-size:0.8rem;">
                                                {{ optional($spot->updated_at)->format('Y/m/d') ?? '—' }}
                                            </td>
                                            <td>
                                                @php
                                                    $statusColor = match ($spot->status) {
                                                        'published' => 'success',
                                                        'draft' => 'secondary',
                                                        'unpublished' => 'danger',
                                                        default => 'secondary',
                                                    };
                                                    $statusLabel = ucfirst($spot->status ?? 'published');
                                                @endphp
                                                <div class="dropdown">
                                                    <button
                                                        class="btn btn-sm btn-outline-{{ $statusColor }} dropdown-toggle py-0 px-2"
                                                        style="font-size:0.72rem;" type="button"
                                                        id="currentStatusBtn_working_{{ $spot->id }}"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        {{ $statusLabel }}
                                                    </button>
                                                    <ul class="dropdown-menu"
                                                        id="statusDropdownMenu_working_{{ $spot->id }}"></ul>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <a href="#" class="btn btn-outline-secondary btn-sm py-0 px-2"
                                                        style="font-size:0.72rem;">Detail</a>
                                                    <a href="#" class="btn btn-outline-secondary btn-sm py-0 px-2"
                                                        style="font-size:0.72rem;">Edit</a>
                                                    <button type="button"
                                                        class="btn btn-outline-danger btn-sm py-0 px-2 js-delete-spot"
                                                        data-id="{{ $spot->id }}"
                                                        style="font-size:0.72rem;">Delete</button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center text-muted py-4">No working spots found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>

            {{-- ============ TAB 2: TOURISM ============ --}}
            <div class="tab-pane fade" id="tab-tourism" role="tabpanel">

                {{-- Metrics cards --}}
                <div class="row g-3 mb-3">
                    <div class="col-12 col-md-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body p-3">
                                <p class="text-muted mb-1" style="font-size:0.8rem;">Total Spots</p>
                                <h4 class="fw-bold mb-0">{{ $tourismSpots->count() }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body p-3">
                                <p class="text-muted mb-1" style="font-size:0.8rem;">With Activity</p>
                                <h4 class="fw-bold mb-0">{{ $tourismSpots->where('has_activity', 1)->count() }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body p-3">
                                <p class="text-muted mb-1" style="font-size:0.8rem;">With Great View</p>
                                <h4 class="fw-bold mb-0">{{ $tourismSpots->where('has_view', 1)->count() }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body p-3">
                                <p class="text-muted mb-1" style="font-size:0.8rem;">With Food</p>
                                <h4 class="fw-bold mb-0">{{ $tourismSpots->where('has_food', 1)->count() }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">

                        <div class="d-flex gap-2 mb-3 flex-wrap">
                            <input type="text" id="tourism-search" class="form-control form-control-sm flex-grow-1"
                                placeholder="Search by spot name or area..." style="min-width:200px;">
                        </div>

                        <div class="table-responsive">
                            <table class="table align-middle" id="tourism-table">
                                <thead>
                                    <tr class="text-muted" style="font-size:0.75rem;">
                                        <th>Spot Name</th>
                                        <th>Area</th>
                                        <th>Budget</th>
                                        <th>Evaluation</th>
                                        <th>Amenities</th>
                                        <th>Updated</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody style="font-size:0.875rem;">
                                    @forelse ($tourismSpots as $spot)
                                        <tr data-name="{{ strtolower($spot->name . ' ' . $spot->area) }}">
                                            <td class="fw-semibold">
                                                <div class="d-flex align-items-center gap-2">
                                                    @if ($spot->photo_path)
                                                        <img src="{{ asset('storage/' . $spot->photo_path) }}"
                                                            alt="{{ $spot->name }}" class="rounded"
                                                            style="width:32px;height:32px;object-fit:cover;">
                                                    @else
                                                        <span
                                                            class="d-inline-flex align-items-center justify-content-center bg-light rounded"
                                                            style="width:32px;height:32px;color:#adb5bd;">
                                                            <i class="fa-solid fa-image"></i>
                                                        </span>
                                                    @endif
                                                    {{ $spot->name }}
                                                </div>
                                            </td>
                                            <td class="text-muted">{{ $spot->area }}</td>
                                            <td class="text-muted">{{ $spot->budget ?? '—' }}</td>
                                            <td>
                                                @if ($spot->reviews_count > 0)
                                                    <span style="color:#854F0B; font-size:0.8rem;">
                                                        <i class="fa-solid fa-star"></i>
                                                        {{ number_format($spot->reviews_avg_rating, 1) }}
                                                    </span>
                                                    <span class="text-muted"
                                                        style="font-size:0.72rem;">({{ $spot->reviews_count }})</span>
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1 flex-wrap">
                                                    @if ($spot->has_activity)
                                                        <span class="badge rounded-pill"
                                                            style="background-color:#EAF3DE; color:#27500A;"><i
                                                                class="fa-solid fa-person-hiking"></i></span>
                                                    @endif
                                                    @if ($spot->has_view)
                                                        <span class="badge rounded-pill"
                                                            style="background-color:#EAF3DE; color:#27500A;"><i
                                                                class="fa-solid fa-mountain-sun"></i></span>
                                                    @endif
                                                    @if ($spot->has_shopping)
                                                        <span class="badge rounded-pill"
                                                            style="background-color:#EAF3DE; color:#27500A;"><i
                                                                class="fa-solid fa-bag-shopping"></i></span>
                                                    @endif
                                                    @if ($spot->has_food)
                                                        <span class="badge rounded-pill"
                                                            style="background-color:#EAF3DE; color:#27500A;"><i
                                                                class="fa-solid fa-utensils"></i></span>
                                                    @endif
                                                    @if (!$spot->has_activity && !$spot->has_view && !$spot->has_shopping && !$spot->has_food)
                                                        <span class="text-muted">—</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="text-muted" style="font-size:0.8rem;">
                                                {{ optional($spot->updated_at)->format('Y/m/d') ?? '—' }}
                                            </td>
                                            <td>
                                                @php
                                                    $statusColor = match ($spot->status) {
                                                        'published' => 'success',
                                                        'draft' => 'secondary',
                                                        'unpublished' => 'danger',
                                                        default => 'secondary',
                                                    };
                                                    $statusLabel = ucfirst($spot->status ?? 'published');
                                                @endphp
                                                <div class="dropdown">
                                                    <button
                                                        class="btn btn-sm btn-outline-{{ $statusColor }} dropdown-toggle py-0 px-2"
                                                        style="font-size:0.72rem;" type="button"
                                                        id="currentStatusBtn_tourism_{{ $spot->id }}"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        {{ $statusLabel }}
                                                    </button>
                                                    <ul class="dropdown-menu"
                                                        id="statusDropdownMenu_tourism_{{ $spot->id }}"></ul>
                                                </div>
                                            </td>
                                            <td>
                                                {{-- 表示か非表示だけでもいいかも？ --}}

                                                <div class="d-flex gap-1">
                                                    <a href="#" class="btn btn-outline-secondary btn-sm py-0 px-2"
                                                        style="font-size:0.72rem;">Detail</a>
                                                    <a href="#" class="btn btn-outline-secondary btn-sm py-0 px-2"
                                                        style="font-size:0.72rem;">Edit</a>
                                                    <button type="button"
                                                        class="btn btn-outline-danger btn-sm py-0 px-2 js-delete-spot"
                                                        data-id="{{ $spot->id }}"
                                                        style="font-size:0.72rem;">Delete</button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-muted py-4">No tourism spots found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>

            {{-- ============ TAB 3: HOSPITAL ============ --}}
            <div class="tab-pane fade" id="tab-hospital" role="tabpanel">

                {{-- Metric cards --}}
                <div class="row g-3 mb-3">
                    <div class="col-12 col-md-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body p-3">
                                <p class="text-muted mb-1" style="font-size:0.8rem;">Total Spots</p>
                                <h4 class="fw-bold mb-0">{{ $hospitals->count() }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body p-3">
                                <p class="text-muted mb-1" style="font-size:0.8rem;">Published</p>
                                <h4 class="fw-bold mb-0">{{ $hospitals->where('status', 'published')->count() }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body p-3">
                                <p class="text-muted mb-1" style="font-size:0.8rem;">Draft</p>
                                <h4 class="fw-bold mb-0">{{ $hospitals->where('status', 'draft')->count() }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body p-3">
                                <p class="text-muted mb-1" style="font-size:0.8rem;">Unpublished</p>
                                <h4 class="fw-bold mb-0">{{ $hospitals->where('status', 'unpublished')->count() }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">

                        <div class="d-flex gap-2 mb-3 flex-wrap">
                            <input type="text" id="hospital-search" class="form-control form-control-sm flex-grow-1"
                                placeholder="Search by spot name or area..." style="min-width:200px;">
                        </div>

                        <div class="table-responsive">
                            <table class="table align-middle" id="hospital-table">
                                <thead>
                                    <tr class="text-muted" style="font-size:0.75rem;">
                                        <th>Spot Name</th>
                                        <th>Area</th>
                                        <th>Specialty</th>
                                        <th>Hours</th>
                                        <th>Support</th>
                                        <th>Updated</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody style="font-size:0.875rem;">
                                    @forelse ($hospitals as $spot)
                                        <tr data-name="{{ strtolower($spot->name . ' ' . $spot->address_en) }}">
                                            <td class="fw-semibold">
                                                <div class="d-flex align-items-center gap-2">
                                                    <span
                                                        class="d-inline-flex align-items-center justify-content-center bg-light rounded"
                                                        style="width:32px;height:32px;color:#adb5bd;">
                                                        <i class="fa-solid fa-hospital"></i>
                                                    </span>
                                                    {{ $spot->name }}
                                                </div>
                                            </td>
                                            <td class="text-muted">{{ $spot->address_en ?? '—' }}</td>
                                            <td class="text-muted" style="font-size:0.8rem;">
                                                {{ $spot->specialties->pluck('name')->join(', ') ?: '—' }}
                                            </td>
                                            <td class="text-muted" style="font-size:0.8rem;">
                                                {{ $spot->is_24_hours ? '24 Hours' : $spot->business_hours ?? '—' }}
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    @if ($spot->is_clinic)
                                                        <span class="badge rounded-pill"
                                                            style="background-color:#EAF3DE; color:#27500A;">Clinic</span>
                                                    @endif
                                                    @if ($spot->is_jhd_supported)
                                                        <span class="badge rounded-pill"
                                                            style="background-color:#E6F1FB; color:#0C447C;">JHD</span>
                                                    @endif
                                                    @if (!$spot->is_clinic && !$spot->is_jhd_supported)
                                                        <span class="text-muted">—</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="text-muted" style="font-size:0.8rem;">
                                                {{ optional($spot->updated_at)->format('Y/m/d') ?? '—' }}
                                            </td>
                                            <td>
                                                @php
                                                    $statusColor = match ($spot->status) {
                                                        'published' => 'success',
                                                        'draft' => 'secondary',
                                                        'unpublished' => 'danger',
                                                        default => 'secondary',
                                                    };
                                                    $statusLabel = ucfirst($spot->status ?? 'published');
                                                @endphp
                                                <div class="dropdown">
                                                    <button
                                                        class="btn btn-sm btn-outline-{{ $statusColor }} dropdown-toggle py-0 px-2"
                                                        style="font-size:0.72rem;" type="button"
                                                        id="currentStatusBtn_hospital_{{ $spot->id }}"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        {{ $statusLabel }}
                                                    </button>
                                                    <ul class="dropdown-menu"
                                                        id="statusDropdownMenu_hospital_{{ $spot->id }}"></ul>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <a href="#" class="btn btn-outline-secondary btn-sm py-0 px-2"
                                                        style="font-size:0.72rem;">Detail</a>
                                                    <a href="#" class="btn btn-outline-secondary btn-sm py-0 px-2"
                                                        style="font-size:0.72rem;">Edit</a>
                                                    <button type="button"
                                                        class="btn btn-outline-danger btn-sm py-0 px-2 js-delete-spot"
                                                        data-id="{{ $spot->id }}"
                                                        style="font-size:0.72rem;">Delete</button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-muted py-4">No hospital spots
                                                found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function initSpotStatusDropdown(spotId, type, initialStatus) {
            const statusConfig = {
                'published': {
                    btn: 'btn-outline-success'
                },
                'draft': {
                    btn: 'btn-outline-secondary'
                },
                'unpublished': {
                    btn: 'btn-outline-danger'
                },
            };

            const currentBtn = document.getElementById(`currentStatusBtn_${type}_${spotId}`);
            const dropdownMenu = document.getElementById(`statusDropdownMenu_${type}_${spotId}`);
            if (!currentBtn || !dropdownMenu) return;

            function updateDropdownMenu(currentStatus) {
                dropdownMenu.innerHTML = '';
                Object.keys(statusConfig).forEach(status => {
                    if (status !== currentStatus) {
                        const li = document.createElement('li');
                        li.innerHTML =
                            `<button class="dropdown-item" type="button">${status.charAt(0).toUpperCase() + status.slice(1)}</button>`;
                        li.querySelector('button').addEventListener('click', () => changeStatus(status));
                        dropdownMenu.appendChild(li);
                    }
                });
            }

            function changeStatus(newStatus) {
                const oldStatus = currentBtn.dataset.status || initialStatus;

                fetch(`/admin/spots/${type}/${spotId}/status`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        },
                        body: JSON.stringify({
                            status: newStatus
                        }),
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (!data.success) return;

                        currentBtn.classList.remove(statusConfig[oldStatus].btn);
                        currentBtn.classList.add(statusConfig[newStatus].btn);
                        currentBtn.textContent = newStatus.charAt(0).toUpperCase() + newStatus.slice(1);
                        currentBtn.dataset.status = newStatus;

                        updateDropdownMenu(newStatus);
                    })
                    .catch(err => console.error('ステータス更新に失敗しました', err));
            }

            currentBtn.dataset.status = initialStatus;
            updateDropdownMenu(initialStatus);
        }

        document.addEventListener('DOMContentLoaded', function() {
            @foreach ($workingSpots as $spot)
                initSpotStatusDropdown({{ $spot->id }}, 'working', '{{ $spot->status ?? 'published' }}');
            @endforeach
            @foreach ($tourismSpots as $spot)
                initSpotStatusDropdown({{ $spot->id }}, 'tourism', '{{ $spot->status ?? 'published' }}');
            @endforeach

            // 削除確認（既存のまま）
            document.querySelectorAll('.btn-outline-danger').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    if (!confirm('Are you sure you want to delete this spot?')) {
                        return;
                    }
                    // TODO: submit delete request to controller
                });
            });
        });
    </script>
@endpush
