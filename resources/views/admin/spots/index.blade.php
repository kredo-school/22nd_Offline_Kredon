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
            <button type="button" class="btn btn-primary"
                onclick="document.querySelector('[data-bs-target=&quot;#tab-working&quot;]')?.click()">
                <i class="fa-solid fa-plus me-1"></i> New Spot
            </button>
        </div>

        {{-- Category Tabs --}}
        <ul class="nav nav-tabs mb-3" id="spotTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="tab-working-btn" data-bs-toggle="tab" data-bs-target="#tab-working"
                    type="button" role="tab">
                    <i class="fa-solid fa-briefcase me-1"></i> Working <span
                        class="badge bg-light text-dark ms-1">128</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab-tourism-btn" data-bs-toggle="tab" data-bs-target="#tab-tourism"
                    type="button" role="tab">
                    <i class="fa-solid fa-camera me-1"></i> Tourism <span class="badge bg-light text-dark ms-1">214</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab-hospital-btn" data-bs-toggle="tab" data-bs-target="#tab-hospital"
                    type="button" role="tab">
                    <i class="fa-solid fa-hospital me-1"></i> Hospital <span class="badge bg-light text-dark ms-1">76</span>
                </button>
            </li>
        </ul>

        <div class="tab-content" id="spotTabsContent">

            {{-- ============ TAB 1: WORKING ============ --}}
            <div class="tab-pane fade show active" id="tab-working" role="tabpanel">

                {{-- Metric cards --}}
                <div class="row g-3 mb-3">
                    <div class="col-12 col-md-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body p-3">
                                <p class="text-muted mb-1" style="font-size:0.8rem;">Total Spots</p>
                                <h4 class="fw-bold mb-0">128</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body p-3">
                                <p class="text-muted mb-1" style="font-size:0.8rem;">Published</p>
                                <h4 class="fw-bold mb-0">104</h4>
                                <p class="text-muted mb-0" style="font-size:0.75rem;">81%</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body p-3">
                                <p class="text-muted mb-1" style="font-size:0.8rem;">Draft</p>
                                <h4 class="fw-bold mb-0">18</h4>
                                <p class="text-muted mb-0" style="font-size:0.75rem;">Pending review</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body p-3">
                                <p class="text-muted mb-1" style="font-size:0.8rem;">Unpublished</p>
                                <h4 class="fw-bold mb-0">6</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">

                        {{-- Filter row --}}
                        <div class="d-flex gap-2 mb-3 flex-wrap">
                            <select class="form-select form-select-sm" style="width:auto;">
                                <option>All Status</option>
                                <option>Published</option>
                                <option>Draft</option>
                                <option>Unpublished</option>
                            </select>
                            <input type="text" class="form-control form-control-sm flex-grow-1"
                                placeholder="Search by spot name..." style="min-width:200px;">
                        </div>

                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead>
                                    <tr class="text-muted" style="font-size:0.75rem;">
                                        <th>Spot Name</th>
                                        <th>Area</th>
                                        <th>Evaluation</th>
                                        <th>Status</th>
                                        <th>Updated</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody style="font-size:0.875rem;">
                                    @php
                                        $dummyWorkingSpots = [
                                            [
                                                'name' => 'Ayala Center Cebu - Office Tower',
                                                'area' => 'Cebu Business Park',
                                                'rating' => 4.5,
                                                'status' => 'published',
                                                'updated' => '2026/06/12',
                                            ],
                                            [
                                                'name' => 'IT Park Coworking Space',
                                                'area' => 'Lahug',
                                                'rating' => 4.2,
                                                'status' => 'published',
                                                'updated' => '2026/06/10',
                                            ],
                                            [
                                                'name' => 'Mandaue Manufacturing Hub',
                                                'area' => 'Mandaue',
                                                'rating' => null,
                                                'status' => 'draft',
                                                'updated' => '2026/06/15',
                                            ],
                                            [
                                                'name' => 'Old Town Print Shop',
                                                'area' => 'Colon',
                                                'rating' => 3.1,
                                                'status' => 'unpublished',
                                                'updated' => '2026/05/28',
                                            ],
                                        ];
                                    @endphp

                                    @foreach ($dummyWorkingSpots as $spot)
                                        <tr>
                                            <td class="fw-semibold">
                                                <div class="d-flex align-items-center gap-2">
                                                    <span
                                                        class="d-inline-flex align-items-center justify-content-center bg-light rounded"
                                                        style="width:32px;height:32px;color:#adb5bd;">
                                                        <i class="fa-solid fa-image"></i>
                                                    </span>
                                                    {{ $spot['name'] }}
                                                </div>
                                            </td>
                                            <td class="text-muted">{{ $spot['area'] }}</td>
                                            <td>
                                                @if ($spot['rating'])
                                                    <span style="color:#854F0B; font-size:0.8rem;"><i
                                                            class="fa-solid fa-star"></i> {{ $spot['rating'] }}</span>
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($spot['status'] === 'published')
                                                    <span class="badge rounded-pill"
                                                        style="background-color:#EAF3DE; color:#27500A; font-weight:500;">Published</span>
                                                @elseif ($spot['status'] === 'draft')
                                                    <span class="badge rounded-pill"
                                                        style="background-color:#F1EFE8; color:#444441; font-weight:500;">Draft</span>
                                                @else
                                                    <span class="badge rounded-pill"
                                                        style="background-color:#FCEBEB; color:#791F1F; font-weight:500;">Unpublished</span>
                                                @endif
                                            </td>
                                            <td class="text-muted" style="font-size:0.8rem;">{{ $spot['updated'] }}</td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <a href="#" class="btn btn-outline-secondary btn-sm py-0 px-2"
                                                        style="font-size:0.72rem;">Detail</a>
                                                    <button class="btn btn-outline-secondary btn-sm py-0 px-2"
                                                        style="font-size:0.72rem;">Edit</button>
                                                    <button class="btn btn-outline-danger btn-sm py-0 px-2"
                                                        style="font-size:0.72rem;">Delete</button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>

            {{-- ============ TAB 2: TOURISM ============ --}}
            <div class="tab-pane fade" id="tab-tourism" role="tabpanel">

                <div class="row g-3 mb-3">
                    <div class="col-12 col-md-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body p-3">
                                <p class="text-muted mb-1" style="font-size:0.8rem;">Total Spots</p>
                                <h4 class="fw-bold mb-0">214</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body p-3">
                                <p class="text-muted mb-1" style="font-size:0.8rem;">Published</p>
                                <h4 class="fw-bold mb-0">189</h4>
                                <p class="text-muted mb-0" style="font-size:0.75rem;">88%</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body p-3">
                                <p class="text-muted mb-1" style="font-size:0.8rem;">Draft</p>
                                <h4 class="fw-bold mb-0">21</h4>
                                <p class="text-muted mb-0" style="font-size:0.75rem;">Pending review</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body p-3">
                                <p class="text-muted mb-1" style="font-size:0.8rem;">Unpublished</p>
                                <h4 class="fw-bold mb-0">4</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">

                        <div class="d-flex gap-2 mb-3 flex-wrap">
                            <select class="form-select form-select-sm" style="width:auto;">
                                <option>All Status</option>
                                <option>Published</option>
                                <option>Draft</option>
                                <option>Unpublished</option>
                            </select>
                            <select class="form-select form-select-sm" style="width:auto;">
                                <option>All Price Ranges</option>
                                <option>Free</option>
                                <option>$</option>
                                <option>$$</option>
                                <option>$$$</option>
                            </select>
                            <input type="text" class="form-control form-control-sm flex-grow-1"
                                placeholder="Search by spot name..." style="min-width:200px;">
                        </div>

                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead>
                                    <tr class="text-muted" style="font-size:0.75rem;">
                                        <th>Spot Name</th>
                                        <th>Price Range</th>
                                        <th>Area</th>
                                        <th>Evaluation</th>
                                        <th>Status</th>
                                        <th>Updated</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody style="font-size:0.875rem;">
                                    @php
                                        $dummyTourismSpots = [
                                            [
                                                'name' => 'Temple of Leah',
                                                'price' => '$$',
                                                'area' => 'Busay',
                                                'rating' => 4.8,
                                                'status' => 'published',
                                                'updated' => '2026/06/14',
                                            ],
                                            [
                                                'name' => 'Kawasan Falls',
                                                'price' => '$',
                                                'area' => 'Badian',
                                                'rating' => 4.9,
                                                'status' => 'published',
                                                'updated' => '2026/06/09',
                                            ],
                                            [
                                                'name' => 'Sirao Flower Garden',
                                                'price' => 'Free',
                                                'area' => 'Sirao',
                                                'rating' => null,
                                                'status' => 'draft',
                                                'updated' => '2026/06/16',
                                            ],
                                            [
                                                'name' => "Magellan's Cross",
                                                'price' => 'Free',
                                                'area' => 'Cebu City',
                                                'rating' => 4.3,
                                                'status' => 'published',
                                                'updated' => '2026/06/01',
                                            ],
                                        ];
                                    @endphp

                                    @foreach ($dummyTourismSpots as $spot)
                                        <tr>
                                            <td class="fw-semibold">
                                                <div class="d-flex align-items-center gap-2">
                                                    <span
                                                        class="d-inline-flex align-items-center justify-content-center bg-light rounded"
                                                        style="width:32px;height:32px;color:#adb5bd;">
                                                        <i class="fa-solid fa-image"></i>
                                                    </span>
                                                    {{ $spot['name'] }}
                                                </div>
                                            </td>
                                            <td class="text-muted">{{ $spot['price'] }}</td>
                                            <td class="text-muted">{{ $spot['area'] }}</td>
                                            <td>
                                                @if ($spot['rating'])
                                                    <span style="color:#854F0B; font-size:0.8rem;"><i
                                                            class="fa-solid fa-star"></i> {{ $spot['rating'] }}</span>
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($spot['status'] === 'published')
                                                    <span class="badge rounded-pill"
                                                        style="background-color:#EAF3DE; color:#27500A; font-weight:500;">Published</span>
                                                @elseif ($spot['status'] === 'draft')
                                                    <span class="badge rounded-pill"
                                                        style="background-color:#F1EFE8; color:#444441; font-weight:500;">Draft</span>
                                                @else
                                                    <span class="badge rounded-pill"
                                                        style="background-color:#FCEBEB; color:#791F1F; font-weight:500;">Unpublished</span>
                                                @endif
                                            </td>
                                            <td class="text-muted" style="font-size:0.8rem;">{{ $spot['updated'] }}</td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <a href="#" class="btn btn-outline-secondary btn-sm py-0 px-2"
                                                        style="font-size:0.72rem;">Detail</a>
                                                    <button class="btn btn-outline-secondary btn-sm py-0 px-2"
                                                        style="font-size:0.72rem;">Edit</button>
                                                    <button class="btn btn-outline-danger btn-sm py-0 px-2"
                                                        style="font-size:0.72rem;">Delete</button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>

            {{-- ============ TAB 3: HOSPITAL ============ --}}
            <div class="tab-pane fade" id="tab-hospital" role="tabpanel">

                <div class="row g-3 mb-3">
                    <div class="col-12 col-md-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body p-3">
                                <p class="text-muted mb-1" style="font-size:0.8rem;">Total Spots</p>
                                <h4 class="fw-bold mb-0">76</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body p-3">
                                <p class="text-muted mb-1" style="font-size:0.8rem;">Published</p>
                                <h4 class="fw-bold mb-0">70</h4>
                                <p class="text-muted mb-0" style="font-size:0.75rem;">92%</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body p-3">
                                <p class="text-muted mb-1" style="font-size:0.8rem;">Draft</p>
                                <h4 class="fw-bold mb-0">4</h4>
                                <p class="text-muted mb-0" style="font-size:0.75rem;">Pending review</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body p-3">
                                <p class="text-muted mb-1" style="font-size:0.8rem;">Unpublished</p>
                                <h4 class="fw-bold mb-0">2</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">

                        <div class="d-flex gap-2 mb-3 flex-wrap">
                            <select class="form-select form-select-sm" style="width:auto;">
                                <option>All Status</option>
                                <option>Published</option>
                                <option>Draft</option>
                                <option>Unpublished</option>
                            </select>
                            <select class="form-select form-select-sm" style="width:auto;">
                                <option>All Departments</option>
                                <option>Internal Medicine</option>
                                <option>Surgery</option>
                                <option>Pediatrics</option>
                                <option>Emergency</option>
                            </select>
                            <input type="text" class="form-control form-control-sm flex-grow-1"
                                placeholder="Search by spot name..." style="min-width:200px;">
                        </div>

                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead>
                                    <tr class="text-muted" style="font-size:0.75rem;">
                                        <th>Spot Name</th>
                                        <th>Department</th>
                                        <th>Area</th>
                                        <th>Evaluation</th>
                                        <th>Status</th>
                                        <th>Updated</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody style="font-size:0.875rem;">
                                    @php
                                        $dummyHospitalSpots = [
                                            [
                                                'name' => "Cebu Doctors' University Hospital",
                                                'department' => 'Emergency / Internal Medicine',
                                                'area' => 'Osmeña Blvd',
                                                'rating' => 4.4,
                                                'status' => 'published',
                                                'updated' => '2026/06/11',
                                            ],
                                            [
                                                'name' => 'Chong Hua Hospital',
                                                'department' => 'Surgery / Pediatrics',
                                                'area' => 'Cebu City',
                                                'rating' => 4.6,
                                                'status' => 'published',
                                                'updated' => '2026/06/08',
                                            ],
                                            [
                                                'name' => 'Mandaue City Hospital',
                                                'department' => 'Internal Medicine',
                                                'area' => 'Mandaue',
                                                'rating' => null,
                                                'status' => 'draft',
                                                'updated' => '2026/06/16',
                                            ],
                                        ];
                                    @endphp

                                    @foreach ($dummyHospitalSpots as $spot)
                                        <tr>
                                            <td class="fw-semibold">
                                                <div class="d-flex align-items-center gap-2">
                                                    <span
                                                        class="d-inline-flex align-items-center justify-content-center bg-light rounded"
                                                        style="width:32px;height:32px;color:#adb5bd;">
                                                        <i class="fa-solid fa-image"></i>
                                                    </span>
                                                    {{ $spot['name'] }}
                                                </div>
                                            </td>
                                            <td class="text-muted">{{ $spot['department'] }}</td>
                                            <td class="text-muted">{{ $spot['area'] }}</td>
                                            <td>
                                                @if ($spot['rating'])
                                                    <span style="color:#854F0B; font-size:0.8rem;"><i
                                                            class="fa-solid fa-star"></i> {{ $spot['rating'] }}</span>
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($spot['status'] === 'published')
                                                    <span class="badge rounded-pill"
                                                        style="background-color:#EAF3DE; color:#27500A; font-weight:500;">Published</span>
                                                @elseif ($spot['status'] === 'draft')
                                                    <span class="badge rounded-pill"
                                                        style="background-color:#F1EFE8; color:#444441; font-weight:500;">Draft</span>
                                                @else
                                                    <span class="badge rounded-pill"
                                                        style="background-color:#FCEBEB; color:#791F1F; font-weight:500;">Unpublished</span>
                                                @endif
                                            </td>
                                            <td class="text-muted" style="font-size:0.8rem;">{{ $spot['updated'] }}</td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <a href="#" class="btn btn-outline-secondary btn-sm py-0 px-2"
                                                        style="font-size:0.72rem;">Detail</a>
                                                    <button class="btn btn-outline-secondary btn-sm py-0 px-2"
                                                        style="font-size:0.72rem;">Edit</button>
                                                    <button class="btn btn-outline-danger btn-sm py-0 px-2"
                                                        style="font-size:0.72rem;">Delete</button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Placeholder: wire up delete confirmation once route/controller exist
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
@endsection
