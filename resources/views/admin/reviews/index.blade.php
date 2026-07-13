@extends('layouts.admin')

@section('title', 'Review Management')

@section('content')
    <div class="p-4" style="overflow-y: auto; height: 100%;">

        {{-- ── Header ── --}}
        <div class="d-flex justify-content-between align-items-start mb-2">
            <div>
                <h4 class="fw-bold mb-1">Review Management</h4>
                <p class="text-muted mb-0" style="font-size:0.85rem;">You can manage and moderate reviews for Spot.</p>
            </div>
        </div>

        {{-- ── Category Tabs (metric style) ── --}}
        <div class="row g-0 mb-4 border-0 rounded overflow-hidden shadow-sm">
            @php
                $currentCategory = request('category', 'all');
                $tabs = [
                    ['label' => 'All reviews', 'count' => $counts['all'], 'key' => 'all', 'danger' => false],
                    ['label' => 'Working spots', 'count' => $counts['working'], 'key' => 'working', 'danger' => false],
                    ['label' => 'Tourism spots', 'count' => $counts['tourism'], 'key' => 'tourism', 'danger' => false],
                    ['label' => 'Needs attention', 'count' => $counts['pending'], 'key' => 'pending', 'danger' => true],
                ];
            @endphp
            @foreach ($tabs as $tab)
                @php $isActive = $currentCategory === $tab['key']; @endphp
                <div class="col-6 col-md-3 g-3">
                    <a href="{{ $tab['key'] === 'pending'
                        ? route('admin.reviews.index', ['status' => 'unpublished'])
                        : route('admin.reviews.index', $tab['key'] === 'all' ? [] : ['category' => $tab['key']]) }}"
                        class="d-block p-3 text-decoration-none h-100 {{ $isActive ? 'bg-dark text-white' : 'bg-white' }} {{ !$loop->last ? 'border-end' : '' }}">
                        <p class="mb-1"
                            style="font-size:0.75rem; opacity: {{ $isActive ? '0.7' : '1' }}; color: {{ $isActive ? '#fff' : '#6c757d' }};">
                            {{ $tab['label'] }}
                        </p>
                        <h4 class="fw-bold mb-0 {{ $tab['danger'] ? 'text-danger' : ($isActive ? 'text-white' : '') }}">
                            {{ number_format($tab['count']) }}
                        </h4>
                    </a>
                </div>
            @endforeach
        </div>

        {{-- ── Table Card ── --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body p-3">

                {{-- ── Filters ── --}}
                <form method="GET" action="{{ route('admin.reviews.index') }}"
                    class="d-flex flex-wrap gap-2 mb-3 align-items-center">
                    <div class="input-group input-group-sm flex-grow-1" style="max-width:320px;">
                        <span class="input-group-text bg-light border-0">
                            <i class="fa-solid fa-magnifying-glass fa-xs"></i>
                        </span>
                        <input type="text" name="q" value="{{ request('q') }}"
                            class="form-control bg-light border-0"
                            placeholder="Search by Review, Username, or Subject Name">
                    </div>
                    <select name="category" class="form-select form-select-sm" style="width:auto;"
                        onchange="this.form.submit()">
                        <option value="" {{ !request('category') ? 'selected' : '' }}>Category: All</option>
                        <option value="working" {{ request('category') === 'working' ? 'selected' : '' }}>Working</option>
                        <option value="tourism" {{ request('category') === 'tourism' ? 'selected' : '' }}>Tourism</option>
                    </select>
                    <select name="status" class="form-select form-select-sm" style="width:auto;"
                        onchange="this.form.submit()">
                        <option value="" {{ !request('status') ? 'selected' : '' }}>Status: All</option>
                        <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published
                        </option>
                        <option value="unpublished" {{ request('status') === 'unpublished' ? 'selected' : '' }}>Unpublished
                        </option>
                    </select>
                    <button type="submit" class="btn btn-outline-secondary btn-sm">Filter</button>
                </form>

                {{-- ── Bulk Actions (表示のみ、機能なし) ── --}}
                <div class="d-flex align-items-center gap-2 mb-3" style="font-size:0.82rem;">
                    <span class="text-muted" id="selectedItemCount">0 items selected</span>
                    <span class="ms-auto text-muted" style="font-size:0.78rem;">
                        {{ number_format($reviews->count()) }} In the document, it indicates
                    </span>
                </div>

                {{-- ── Table ── --}}
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="font-size:0.82rem;">
                        <thead class="table-light">
                            <tr>
                                <th style="width:32px;">
                                    <input type="checkbox" class="form-check-input" id="selectAllreviews">
                                </th>
                                <th>Content</th>
                                <th style="width:100px;">Evaluation</th>
                                <th style="width:90px;">Categories</th>
                                <th style="width:110px;">User</th>
                                <th style="width:120px;">Post day</th>
                                <th style="width:80px;">Status</th>
                                <th style="width:120px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($reviews as $review)
                                @php
                                    $categoryConfig = match ($review->category) {
                                        'working' => ['label' => 'Working', 'bg' => 'success'],
                                        'tourism' => ['label' => 'Tourism', 'bg' => 'primary'],
                                        default => ['label' => 'Others', 'bg' => 'secondary'],
                                    };
                                @endphp
                                <tr>
                                    <td><input type="checkbox" class="form-check-input item-check"></td>
                                    <td>
                                        <div class="fw-medium mb-1">{{ $review->comment }}</div>
                                        <div class="text-muted" style="font-size:0.75rem;">
                                            Target: {{ $review->title }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-warning">
                                            @for ($i = 1; $i <= 5; $i++)
                                                {{ $i <= round($review->rating) ? '★' : '☆' }}
                                            @endfor
                                        </span>
                                    </td>
                                    <td>
                                        <span
                                            class="badge bg-{{ $categoryConfig['bg'] }}-subtle
                                             text-{{ $categoryConfig['bg'] }}-emphasis
                                             border border-{{ $categoryConfig['bg'] }}-subtle"
                                            style="font-size:0.72rem;">
                                            {{ $categoryConfig['label'] }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <span
                                                style="display:inline-flex;align-items:center;justify-content:center;
                                                 width:28px;height:28px;border-radius:50%;background:#dee2e6;
                                                 font-size:0.7rem;font-weight:bold;color:#495057;flex-shrink:0;">
                                                {{ strtoupper(substr($review->user->name ?? '?', 0, 1)) }}
                                            </span>
                                            <div>
                                                <div style="font-size:0.78rem;">{{ $review->user->name ?? 'Unknown' }}
                                                </div>
                                                <div class="text-muted" style="font-size:0.7rem;">
                                                    {{ $review->user->email ?? '' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-nowrap text-muted">{{ $review->created_at?->format('Y-m-d H:i') }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button
                                                class="btn btn-sm dropdown-toggle status-dropdown-btn {{ $review->status === 'published' ? 'btn-success' : 'btn-secondary' }}"
                                                type="button" data-bs-toggle="dropdown"
                                                data-source="{{ $review->source }}" data-id="{{ $review->id }}"
                                                style="font-size:0.72rem;">
                                                {{ $review->status === 'published' ? 'Published' : 'Unpublished' }}
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-sm">
                                                <li><a class="dropdown-item status-option" href="#"
                                                        data-value="published">Published</a></li>
                                                <li><a class="dropdown-item status-option" href="#"
                                                        data-value="unpublished">Unpublished</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1 align-items-center">
                                            <a href="{{ $review->detail_url ?? '#' }}"
                                                class="btn btn-outline-secondary btn-sm py-0 px-2">Detail</a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">No reviews found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('selectAllreviews')?.addEventListener('change', function() {
            document.querySelectorAll('.item-check').forEach(cb => cb.checked = this.checked);
        });

        document.querySelectorAll('.status-option').forEach(option => {
            option.addEventListener('click', async function(e) {
                e.preventDefault();

                const dropdownBtn = this.closest('.dropdown').querySelector('.status-dropdown-btn');
                const newStatus = this.dataset.value;
                const source = dropdownBtn.dataset.source;
                const id = dropdownBtn.dataset.id;

                const res = await fetch(`/admin/reviews/${source}/${id}/status`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                            .content,
                    },
                    body: JSON.stringify({
                        status: newStatus
                    }),
                });

                if (res.ok) {
                    const data = await res.json();
                    dropdownBtn.textContent = data.status === 'published' ? 'Published' : 'Unpublished';
                    dropdownBtn.classList.toggle('btn-success', data.status === 'published');
                    dropdownBtn.classList.toggle('btn-secondary', data.status !== 'published');
                } else {
                    alert('The status update failed.');
                }
            });
        });
    </script>
@endpush
