@extends('layouts.admin')

@section('title', 'Market Management')

@section('content')
    <div class="p-4" style="overflow-y: auto; height: 100%;">

        {{-- ── Header ── --}}
        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <h4 class="fw-bold mb-1">Market Management</h4>
                <p class="text-muted mb-0" style="font-size:0.85rem;">Manage items listed by outgoing residents</p>
            </div>
        </div>

        {{-- ── Metric Cards ── --}}
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-3">
                        <p class="text-muted mb-1" style="font-size:0.78rem;">Total Listings</p>
                        <h4 class="fw-bold mb-0">{{ $metrics['total'] }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-3">
                        <p class="text-muted mb-1" style="font-size:0.78rem;">Needs Review</p>
                        <h4 class="fw-bold mb-0 text-danger">{{ $metrics['flagged'] }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-3">
                        <p class="text-muted mb-1" style="font-size:0.78rem;">Active</p>
                        <h4 class="fw-bold mb-0">{{ $metrics['active'] }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-3">
                        <p class="text-muted mb-1" style="font-size:0.78rem;">Sold</p>
                        <h4 class="fw-bold mb-0 text-success">{{ $metrics['sold'] }}</h4>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Tabs ── --}}
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom px-3 pt-3 pb-0">
                <ul class="nav nav-tabs card-header-tabs" id="marketTabs" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active" id="items-tab" data-bs-toggle="tab" data-bs-target="#items"
                            type="button" role="tab" style="font-size:0.85rem;">
                            Listings
                            <span class="badge bg-secondary ms-1" style="font-size:0.7rem;">{{ $paginatedItems->total() }}</span>
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link text-danger" id="comments-tab" data-bs-toggle="tab"
                            data-bs-target="#comments" type="button" role="tab" style="font-size:0.85rem;">
                            Comment Management
                            <span class="badge bg-danger ms-1" style="font-size:0.7rem;">{{ $paginatedComments->total() }}</span>
                        </button>
                    </li>
                </ul>
            </div>

            <div class="tab-content" id="marketTabsContent">

                {{-- ══════════════════════════════════
                 Listings Tab
            ══════════════════════════════════ --}}
                <div class="tab-pane fade show active p-3" id="items" role="tabpanel">

                    {{-- Filters --}}
                    <form method="GET" class="d-flex flex-wrap gap-2 mb-3 align-items-center">
                        <div class="input-group input-group-sm flex-grow-1" style="max-width:280px;">
                            <span class="input-group-text bg-light border-0">
                                <i class="fa-solid fa-magnifying-glass fa-xs"></i>
                            </span>
                            <input type="text" name="search" value="{{ request('search') }}"
                                class="form-control bg-light border-0" placeholder="Search by item or seller name">
                        </div>
                        <select name="category" class="form-select form-select-sm" style="width:auto;" onchange="this.form.submit()">
                            <option value="all">Categories: All</option>
                            @foreach(config('marketplace.categories') as $category)
                                <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                    {{ $category }}
                                </option>
                            @endforeach
                        </select>
                        <select name="status" class="form-select form-select-sm" style="width:auto;" onchange="this.form.submit()">
                            <option value="all">Status: All</option>
                            <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Active</option>
                            <option value="sold" {{ request('status') == 'sold' ? 'selected' : '' }}>Sold</option>
                        </select>
                        <select name="sort" class="form-select form-select-sm" style="width:auto;" onchange="this.form.submit()">
                            <option value="latest" {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}>Newest</option>
                            <option value="comments" {{ request('sort') == 'comments' ? 'selected' : '' }}>Most Commented</option>
                        </select>
                    </form>

                    {{-- Bulk actions --}}
                    <div class="d-flex align-items-center gap-2 mb-3" style="font-size:0.82rem;">
                        <span class="text-muted" id="selectedItemCount">0 selected</span>
                        <button class="btn btn-outline-secondary btn-sm py-0 px-2">Publish</button>
                        <button class="btn btn-outline-secondary btn-sm py-0 px-2">Unpublish</button>
                        <button class="btn btn-outline-danger btn-sm py-0 px-2">Delete</button>
                        <span class="ms-auto text-muted" style="font-size:0.78rem;">
                            Showing {{ $paginatedItems->firstItem() ?? 0 }}-{{ $paginatedItems->lastItem() ?? 0 }} of {{ $paginatedItems->total() }}
                        </span>
                    </div>

                    {{-- ── Table ── --}}
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" style="font-size:0.82rem;">
                            <thead class="table-light">
                                <tr>
                                    <th style="width:36px;">
                                        <input type="checkbox" class="form-check-input" id="selectAllItems">
                                    </th>
                                    <th style="width:44px;"></th>
                                    <th>Item</th>
                                    <th>User</th>
                                    <th style="width:100px;">Category</th>
                                    <th style="width:120px;">Status</th>
                                    <th style="width: 100px;">Comments</th>
                                    <th style="width:70px;">Reports</th>
                                    <th style="width:80px;">Views</th>
                                    <th style="width: 120px;">Date</th>
                                    <th style="width:160px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($items as $item)
                                    @php
                                        $statusConfig = match ($item['status']) {
                                            'Active'  => ['bg' => 'success'],
                                            'Sold'    => ['bg' => 'primary'],
                                            'Unknown' => ['bg' => 'secondary'],
                                            default   => ['bg' => 'secondary'],
                                        };
                                    @endphp
                                    <tr class="{{ $item['flagged'] ? 'table-danger' : '' }}">
                                        <td>
                                            <input type="checkbox" class="form-check-input item-check">
                                        </td>
                                        <td>
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                                style="width:36px;height:36px;">
                                                <i class="fa-solid {{ $item['icon'] }} text-secondary"></i>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="fw-semibold" style="font-size:0.82rem;">{{ $item['name'] }}</div>
                                            <div class="text-muted" style="font-size:0.72rem;">{{ $item['meta'] }}</div>
                                        </td>
                                        <td>{{ $item['user'] }}</td>
                                        <td class="text-muted">{{ $item['category'] }}</td>
                                        <td>
                                            <span class="badge rounded-pill bg-{{ $statusConfig['bg'] }} px-2 py-1"
                                                style="font-size:0.72rem;">
                                                @if ($item['status'] === 'Active')
                                                    <i class="fa-solid fa-circle-check me-1" style="font-size:0.65rem;"></i>
                                                @elseif($item['status'] === 'Sold')
                                                    <i class="fa-solid fa-circle-info me-1" style="font-size:0.65rem;"></i>
                                                @else
                                                    <i class="fa-solid fa-circle-exclamation me-1" style="font-size:0.65rem;"></i>
                                                @endif
                                                {{ $item['status'] }}
                                            </span>
                                        </td>
                                        <td class="text-muted text-center">
                                            @if ($item['comments'] > 0)
                                                <span class="fw-semibold text-dark">
                                                    <i class="fa-regular fa-comment text-secondary me-1" style="font-size:0.75rem;"></i>
                                                    {{ number_format($item['comments']) }}
                                                </span>
                                            @else
                                                <span class="text-muted" style="opacity: 0.5;">0</span>
                                            @endif
                                        </td>
                                        <td class="{{ $item['reports'] > 0 ? 'text-danger fw-semibold' : 'text-muted' }}">
                                            {{ $item['reports'] }}
                                        </td>
                                        <td class="text-muted">{{ number_format($item['views']) }}</td>
                                        <td>{{ $item['created_at'] ?? '' }}</td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <a href="{{ route('admin.markets.show', $item['id']) }}"
                                                    class="btn btn-outline-secondary btn-sm py-0 px-2"
                                                    style="font-size:0.72rem;">Detail</a>
                                                {{-- <button class="btn btn-outline-secondary btn-sm py-0 px-2"
                                                    style="font-size:0.72rem;">Edit</button> --}}
                                                <button class="btn btn-outline-danger btn-sm py-0 px-2"
                                                    style="font-size:0.72rem;">Delete</button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center text-muted py-4">No listings found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <span class="text-muted" style="font-size:0.78rem;">
                            Showing {{ $paginatedItems->firstItem() ?? 0 }}-{{ $paginatedItems->lastItem() ?? 0 }} of {{ $paginatedItems->total() }}
                        </span>
                        {{ $paginatedItems->onEachSide(1)->links() }}
                    </div>
                </div>

                {{-- Comment Management Tab --}}
                <div class="tab-pane fade p-3" id="comments" role="tabpanel">

                    {{-- Filters --}}
                    <div class="d-flex flex-wrap gap-2 mb-3 align-items-center">
                        <div class="input-group input-group-sm flex-grow-1" style="max-width:280px;">
                            <span class="input-group-text bg-light border-0">
                                <i class="fa-solid fa-magnifying-glass fa-xs"></i>
                            </span>
                            <input type="text" class="form-control bg-light border-0" placeholder="Search by comment or user">
                        </div>
                        <select class="form-select form-select-sm" style="width:auto;">
                            <option>Status: All</option>
                            <option>Approved</option>
                            <option>Pending</option>
                            <option>Spam</option>
                        </select>
                    </div>

                    {{-- Bulk actions --}}
                    <div class="d-flex align-items-center gap-2 mb-3" style="font-size:0.82rem;">
                        <span class="text-muted" id="selectedCommentCount">0 selected</span>
                        <button class="btn btn-outline-secondary btn-sm py-0 px-2">Approve</button>
                        <button class="btn btn-outline-secondary btn-sm py-0 px-2">Hide</button>
                        <button class="btn btn-outline-danger btn-sm py-0 px-2">Delete</button>
                        <span class="ms-auto text-muted" style="font-size:0.78rem;">
                            Showing {{ $paginatedComments->firstItem() ?? 0 }}-{{ $paginatedComments->lastItem() ?? 0 }} of {{ $paginatedComments->total() }}
                        </span>
                    </div>

                    {{-- Table --}}
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" style="font-size:0.82rem;">
                            <thead class="table-light">
                                <tr>
                                    <th style="width:32px;"><input type="checkbox" class="form-check-input" id="selectAllComments"></th>
                                    <th>Comment</th>
                                    <th style="width:160px;">Item</th>
                                    <th style="width:130px;">User</th>
                                    <th style="width:130px;">Date</th>
                                    <th style="width:80px;">Status</th>
                                    <th style="width:160px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($comments as $comment)
                                    @php
                                        $statusBg = match ($comment['status']) {
                                            'Approved' => 'success',
                                            'Pending'  => 'warning',
                                            'Spam'     => 'danger',
                                            default    => 'secondary',
                                        };
                                    @endphp
                                    <tr>
                                        <td><input type="checkbox" class="form-check-input comment-check"></td>
                                        <td>{{ $comment['text'] }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="bg-light rounded d-flex align-items-center justify-content-center flex-shrink-0"
                                                    style="width:32px;height:32px;">
                                                    <i class="fa-solid fa-box fa-xs text-secondary"></i>
                                                </div>
                                                <span class="text-truncate" style="max-width:110px;">
                                                    {{ $comment['item_name'] }}
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <span
                                                    style="display:inline-flex;align-items:center;justify-content:center;
                                                     width:24px;height:24px;border-radius:50%;background:#dee2e6;
                                                     font-size:0.65rem;font-weight:bold;color:#495057;flex-shrink:0;">
                                                    {{ strtoupper(substr(ltrim($comment['handle'], '@'), 0, 1)) }}
                                                </span>
                                                <span class="text-muted" style="font-size:0.75rem;">{{ $comment['handle'] }}</span>
                                            </div>
                                        </td>
                                        <td class="text-muted text-nowrap">{{ $comment['date'] }}</td>
                                        <td>
                                            <span class="badge bg-{{ $statusBg }}" style="font-size:0.72rem;">
                                                {{ $comment['status'] }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <a href="{{ route('admin.markets.show', $comment['item_id']) }}"
                                                    class="btn btn-outline-secondary btn-sm py-0 px-2"
                                                    style="font-size:0.72rem;">Detail</a>
                                                <button class="btn btn-outline-secondary btn-sm py-0 px-2"
                                                    style="font-size:0.72rem;">Edit</button>
                                                <button class="btn btn-outline-danger btn-sm py-0 px-2"
                                                    style="font-size:0.72rem;">Delete</button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">No comments found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="d-flex justify-content-end mt-3">
                        {{ $paginatedComments->onEachSide(1)->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Listings - select all
            document.getElementById('selectAllItems')?.addEventListener('change', function() {
                document.querySelectorAll('.item-check').forEach(cb => cb.checked = this.checked);
                updateCount('.item-check', 'selectedItemCount');
            });
            document.querySelectorAll('.item-check').forEach(cb => {
                cb.addEventListener('change', () => updateCount('.item-check', 'selectedItemCount'));
            });

            // Comments - select all
            document.getElementById('selectAllComments')?.addEventListener('change', function() {
                document.querySelectorAll('.comment-check').forEach(cb => cb.checked = this.checked);
                updateCount('.comment-check', 'selectedCommentCount');
            });
            document.querySelectorAll('.comment-check').forEach(cb => {
                cb.addEventListener('change', () => updateCount('.comment-check', 'selectedCommentCount'));
            });

            function updateCount(selector, counterId) {
                const count = document.querySelectorAll(selector + ':checked').length;
                const el = document.getElementById(counterId);
                if (el) el.textContent = count + ' selected';
            }
        </script>
    @endpush

@endsection