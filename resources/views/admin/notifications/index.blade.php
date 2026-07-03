@extends('layouts.admin')
@section('title', 'Notification')
@section('content')

@section('styles')
    <style>
        .notif-calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, minmax(0, 1fr));
            gap: 4px;
        }

        .notif-cal-head {
            font-size: 0.7rem;
            color: #6c757d;
            text-align: center;
            padding: 4px 0;
            font-weight: 600;
        }

        .notif-cal-day {
            min-height: 80px;
            border: 1px solid #e9ecef;
            border-radius: 6px;
            padding: 6px;
            position: relative;
        }

        .notif-cal-day.other {
            opacity: 0.4;
        }

        .notif-cal-day-num {
            font-size: 0.75rem;
            color: #6c757d;
            margin-bottom: 4px;
        }

        .notif-cal-day-num.today {
            font-weight: 700;
            color: #fff;
            background-color: #0d6efd;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .notif-cal-event {
            font-size: 0.65rem;
            padding: 2px 5px;
            border-radius: 4px;
            margin-bottom: 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .notif-ev-system {
            background-color: #E6F1FB;
            color: #185FA5;
        }

        .notif-ev-event {
            background-color: #EAF3DE;
            color: #3B6D11;
        }

        .notif-ev-auto {
            background-color: #EEEDFE;
            color: #534AB7;
        }

        .notif-cal-dot {
            width: 10px;
            height: 10px;
            border-radius: 2px;
            display: inline-block;
        }

        /* Template part */
        .notif-template-card {
            cursor: pointer;
            transition: box-shadow 0.15s ease, transform 0.1s ease;
        }

        .notif-template-card:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1) !important;
        }

        .notif-template-card:active {
            transform: scale(0.997);
        }

        .notif-card-actions button {
            position: relative;
            z-index: 2;
        }
    </style>
@endsection

<div class="p-4" style="overflow-y: auto; height: 100%;">

    {{-- Flash message --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h4 class="fw-bold mb-1">Notification Management</h4>
            <p class="text-muted mb-0" style="font-size:0.85rem;">Manage system, event, and auto-generated
                notifications
            </p>
        </div>
    </div>

    @php
        $totalCount = $notifications->count();
        $sentCount = $notifications->where('status', 'sent')->count();
        $draftCount = $notifications->where('status', 'draft')->count();
        $scheduledCount = $notifications->where('status', 'scheduled')->count();
        $pendingCount = $notifications->where('status', 'pending')->count();
    @endphp

    {{-- Metric cards --}}
    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card h-100 border-0 shadow-sm p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <small class="text-muted d-block mb-1" style="font-size: 0.75rem;">Total Notifications</small>
                        <h3 class="mb-0 fw-bold" style="font-size: 1.5rem;">{{ number_format($totalCount) }}</h3>
                    </div>
                    <div class="bg-light rounded p-2 text-secondary">
                        <i class="fa-solid fa-paper-plane fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card h-100 border-0 shadow-sm p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <small class="text-muted d-block mb-1" style="font-size: 0.75rem;">Sent</small>
                        <h3 class="mb-0 fw-bold text-danger" style="font-size: 1.5rem;">{{ number_format($sentCount) }}
                        </h3>
                    </div>
                    <div class="bg-danger-subtle rounded p-2 text-danger">
                        <i class="fa-solid fa-paper-plane fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card h-100 border-0 shadow-sm p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <small class="text-muted d-block mb-1" style="font-size: 0.75rem;">Draft</small>
                        <h3 class="mb-0 fw-bold text-info" style="font-size: 1.5rem;">{{ number_format($draftCount) }}
                        </h3>
                    </div>
                    <div class="bg-info-subtle rounded p-2 text-info">
                        <i class="fa-solid fa-file-pen fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card h-100 border-0 shadow-sm p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <small class="text-muted d-block mb-1" style="font-size: 0.75rem;">Scheduled</small>
                        <h3 class="mb-0 fw-bold text-primary" style="font-size: 1.5rem;">
                            {{ number_format($scheduledCount) }}</h3>
                    </div>
                    <div class="bg-primary-subtle rounded p-2 text-primary">
                        <i class="fa-solid fa-clock fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card h-100 border-0 shadow-sm p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <small class="text-muted d-block mb-1" style="font-size: 0.75rem;">Pending</small>
                        <h3 class="mb-0 fw-bold text-warning" style="font-size: 1.5rem;">
                            {{ number_format($pendingCount) }}</h3>
                    </div>
                    <div class="bg-warning-subtle rounded p-2 text-warning">
                        <i class="fa-solid fa-paper-plane fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabs --}}
    <ul class="nav nav-tabs mb-3" id="notificationTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $activeTab === 'list' ? 'active' : '' }}" id="tab-list-btn" data-bs-toggle="tab"
                data-bs-target="#tab-list" type="button" role="tab">
                <i class="fa-solid fa-list me-1"></i> Notification List
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $activeTab === 'create' ? 'active' : '' }}" id="tab-create-btn"
                data-bs-toggle="tab" data-bs-target="#tab-create" type="button" role="tab">
                <i class="fa-solid fa-plus me-1"></i> Create / Edit
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $activeTab === 'calendar' ? 'active' : '' }}" id="tab-calendar-btn"
                data-bs-toggle="tab" data-bs-target="#tab-calendar" type="button" role="tab">
                <i class="fa-solid fa-calendar-days me-1"></i> Calendar
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $activeTab === 'templates' ? 'active' : '' }}" id="tab-templates-btn"
                data-bs-toggle="tab" data-bs-target="#tab-templates" type="button" role="tab">
                <i class="fa-solid fa-file-lines me-1"></i> Templates
            </button>
        </li>
    </ul>

    <div class="tab-content" id="notificationTabsContent">

        {{-- ============ TAB 1: LIST ============ --}}
        <div class="tab-pane fade {{ $activeTab === 'list' ? 'show active' : '' }}" id="tab-list" role="tabpanel">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">

                    {{-- Filter row --}}
                    <div class="d-flex gap-2 mb-3 flex-wrap">
                        <select class="form-select form-select-sm" style="width:auto;" id="filterCategory">
                            <option value="">All Categories</option>
                            <option value="system">System</option>
                            <option value="comment">Comment</option>
                            <option value="reply">Reply</option>
                            <option value="like">Like</option>
                            <option value="event">Event</option>
                            <option value="item_alert">Item Alert</option>
                            <option value="digest">Digest</option>
                        </select>

                        <select class="form-select form-select-sm" style="width:auto;" id="filterStatus">
                            <option value="">All Status</option>
                            <option value="draft">Draft</option>
                            <option value="scheduled">Scheduled</option>
                            <option value="pending">Pending</option>
                            <option value="sent">Sent</option>
                        </select>

                        <input type="text" class="form-control form-control-sm flex-grow-1"
                            placeholder="Search by title..." style="min-width:200px;" id="filterSearch">
                    </div>

                    {{-- Table --}}
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0" style="font-size:0.82rem;">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width:120px;">Notification ID</th>
                                            <th style="width:150px;">Category</th>
                                            <th style="width:120px;">Target</th>
                                            <th>Content / Message</th>
                                            <th style="width:100px;" class="text-center">Status</th>
                                            <th style="width:140px;">Send Date/Time</th>
                                            <th style="width:220px;" class="text-start">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($notifications as $notification)
                                            <tr class="notif-row" data-category="{{ $notification->category }}"
                                                data-status="{{ $notification->status }}">
                                                {{-- Notification ID --}}
                                                <td class="text-muted fw-mono">
                                                    NTF-{{ str_pad($notification->id, 5, '0', STR_PAD_LEFT) }}
                                                </td>

                                                {{-- Category --}}
                                                <td>

                                                    @php
                                                        $categoryBadgeMap = [
                                                            'system' => [
                                                                'bg' => '#E6F1FB',
                                                                'color' => '#0C447C',
                                                                'icon' => 'fa-gear',
                                                                'label' => 'System',
                                                            ],
                                                            'comment' => [
                                                                'bg' => '#EAF3DE',
                                                                'color' => '#3B6D11',
                                                                'icon' => 'fa-comment',
                                                                'label' => 'Comment',
                                                            ],
                                                            'reply' => [
                                                                'bg' => '#EAF3DE',
                                                                'color' => '#3B6D11',
                                                                'icon' => 'fa-reply',
                                                                'label' => 'Reply',
                                                            ],
                                                            'like' => [
                                                                'bg' => '#FDEEF1',
                                                                'color' => '#A3275B',
                                                                'icon' => 'fa-heart',
                                                                'label' => 'Like',
                                                            ],
                                                            'event' => [
                                                                'bg' => '#FFF4E0',
                                                                'color' => '#9A6700',
                                                                'icon' => 'fa-calendar-day',
                                                                'label' => 'Event',
                                                            ],
                                                            'item_alert' => [
                                                                'bg' => '#EEEDFE',
                                                                'color' => '#534AB7',
                                                                'icon' => 'fa-shop',
                                                                'label' => 'Item Alert',
                                                            ],
                                                            'digest' => [
                                                                'bg' => '#E6F1FB',
                                                                'color' => '#0C447C',
                                                                'icon' => 'fa-cubes',
                                                                'label' => 'Digest',
                                                            ],
                                                        ];
                                                        $badge = $categoryBadgeMap[$notification->category] ?? [
                                                            'bg' => '#F1F1F1',
                                                            'color' => '#555',
                                                            'icon' => 'fa-tag',
                                                            'label' => $notification->category,
                                                        ];
                                                    @endphp

                                                    <span class="badge rounded-pill"
                                                        style="background-color:{{ $badge['bg'] }}; color:{{ $badge['color'] }}; font-weight:500;">
                                                        <i class="fa-solid {{ $badge['icon'] }} me-1"></i>
                                                        {{ $badge['label'] }}
                                                    </span>
                                                </td>

                                                {{-- Target --}}
                                                <td>
                                                    @if ($notification->target_type === 'all')
                                                        All Users
                                                    @elseif ($notification->target_type === 'subscriber')
                                                        Subscribers
                                                    @else
                                                        {{ count($notification->data['user_ids'] ?? []) }} Selected
                                                    @endif
                                                </td>

                                                {{-- Content / Message --}}
                                                <td>
                                                    <div class="fw-semibold">{{ $notification->title }}</div>
                                                    <div class="text-muted text-truncate"
                                                        style="font-size:0.72rem; max-width:200px;">
                                                        {{ $notification->body }}
                                                    </div>
                                                </td>

                                                {{-- Status (表示専用バッジ) --}}
                                                <td class="text-center">
                                                    @php
                                                        $statusBadgeMap = [
                                                            'draft' => 'bg-secondary',
                                                            'scheduled' => 'bg-warning',
                                                            'pending' => 'bg-warning',
                                                            'sent' => 'bg-success',
                                                        ];
                                                        $statusBadgeClass =
                                                            $statusBadgeMap[$notification->status] ??
                                                            'bg-light text-dark';
                                                    @endphp
                                                    <span id="statusBadge_{{ $notification->id }}"
                                                        class="badge rounded-pill {{ $statusBadgeClass }} px-2 py-1"
                                                        style="font-size:0.72rem;">
                                                        {{ ucfirst($notification->status) }}
                                                    </span>
                                                </td>

                                                {{-- Send Date/Time --}}
                                                <td class="text-muted">
                                                    {{ optional($notification->scheduled_at ?? $notification->created_at)->format('Y-m-d H:i A') }}
                                                </td>

                                                {{-- Actions --}}
                                                <td>
                                                    <div class="d-flex gap-1 align-items-center">
                                                        <button type="button"
                                                            class="btn btn-outline-secondary btn-sm py-0 px-2 notif-detail-btn"
                                                            style="font-size:0.72rem;" data-bs-toggle="modal"
                                                            data-bs-target="#notifDetailModal"
                                                            data-id="{{ $notification->id }}"
                                                            data-ntf-id="NTF-{{ str_pad($notification->id, 5, '0', STR_PAD_LEFT) }}"
                                                            data-category="{{ $notification->category }}"
                                                            data-category-label="{{ $badge['label'] }}"
                                                            data-category-bg="{{ $badge['bg'] }}"
                                                            data-category-color="{{ $badge['color'] }}"
                                                            data-category-icon="{{ $badge['icon'] }}"
                                                            data-title="{{ $notification->title }}"
                                                            data-body="{{ $notification->body }}"
                                                            data-target-type="{{ $notification->target_type }}"
                                                            data-status="{{ $notification->status }}"
                                                            data-link-url="{{ $notification->data['link_url'] ?? '' }}"
                                                            data-send-push="{{ $notification->data['send_push'] ?? false ? '1' : '0' }}"
                                                            data-send-email="{{ $notification->data['send_email'] ?? false ? '1' : '0' }}"
                                                            data-user-ids='@json($notification->data['user_ids'] ?? [])'
                                                            data-created-at="{{ optional($notification->created_at)->format('Y-m-d H:i') }}"
                                                            data-scheduled-at="{{ optional($notification->scheduled_at)->format('Y-m-d H:i') }}"
                                                            data-sent-at="{{ optional($notification->sent_at)->format('Y-m-d H:i') }}">
                                                            Detail
                                                        </button>

                                                        {{-- Status変更ドロップダウン (Users方式) --}}
                                                        @php
                                                            $statusBtnStyleMap = [
                                                                'draft' => 'btn-outline-secondary',
                                                                'scheduled' => 'btn-outline-warning',
                                                                'pending' => 'btn-outline-warning',
                                                                'sent' => 'btn-outline-success',
                                                            ];
                                                            $statusBtnClass =
                                                                $statusBtnStyleMap[$notification->status] ??
                                                                'btn-outline-secondary';
                                                        @endphp
                                                        <div class="btn-group">
                                                            <button id="currentStatusBtn_{{ $notification->id }}"
                                                                type="button"
                                                                class="btn {{ $statusBtnClass }} btn-sm py-0 px-2 dropdown-toggle"
                                                                data-bs-toggle="dropdown" aria-expanded="false"
                                                                style="font-size:0.72rem;">
                                                                {{ ucfirst($notification->status) }}
                                                            </button>
                                                            <ul class="dropdown-menu"
                                                                id="statusDropdownMenu_{{ $notification->id }}">
                                                                @foreach (['draft', 'scheduled', 'pending', 'sent'] as $statusOption)
                                                                    <li>
                                                                        <a class="dropdown-item notif-status-option"
                                                                            href="#"
                                                                            data-notification-id="{{ $notification->id }}"
                                                                            data-status="{{ $statusOption }}">
                                                                            {{ ucfirst($statusOption) }}
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>

                                                        <form method="POST"
                                                            action="{{ route('admin.notifications.destroy', $notification->id) }}"
                                                            class="notif-delete-form mb-0 d-inline"
                                                            onsubmit="return confirm('Are you sure to delete this content?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn btn-outline-danger btn-sm py-0 px-2 notif-delete-btn"
                                                                style="font-size:0.72rem;"
                                                                data-title="{{ $notification->title }}">Delete</button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr id="notifEmptyRow">
                                                <td colspan="7" class="text-center text-muted py-4">
                                                    There are no notifications yet. Please create one from the ‘Create’
                                                    tab. </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- Notification Detail Modal (共通1つをJSで内容書き換え) --}}
                    <div class="modal fade" id="notifDetailModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <div class="d-flex align-items-center gap-2">
                                        <span id="detailCategoryBadge" class="badge rounded-pill"></span>
                                        <span class="text-muted fw-mono" id="detailNtfId"
                                            style="font-size:0.8rem;"></span>
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <h6 class="fw-bold mb-1" id="detailTitle"></h6>
                                    <p class="text-muted mb-3" id="detailBody" style="font-size:0.9rem;">
                                    </p>

                                    <div class="row g-3 mb-3">
                                        <div class="col-6 col-md-3">
                                            <p class="text-muted text-uppercase mb-1"
                                                style="font-size:0.68rem; letter-spacing:0.05em;">Status
                                            </p>
                                            <span id="detailStatusBadge" class="badge rounded-pill px-2 py-1"></span>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <p class="text-muted text-uppercase mb-1"
                                                style="font-size:0.68rem; letter-spacing:0.05em;">Target
                                            </p>
                                            <p class="mb-0" id="detailTargetType" style="font-size:0.85rem;"></p>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <p class="text-muted text-uppercase mb-1"
                                                style="font-size:0.68rem; letter-spacing:0.05em;">Delivery
                                            </p>
                                            <p class="mb-0" id="detailDeliveryMethod" style="font-size:0.85rem;">
                                            </p>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <p class="text-muted text-uppercase mb-1"
                                                style="font-size:0.68rem; letter-spacing:0.05em;">Link URL
                                            </p>
                                            <p class="mb-0 text-truncate" id="detailLinkUrl"
                                                style="font-size:0.85rem;"></p>
                                        </div>
                                    </div>

                                    <div class="row g-3 mb-3">
                                        <div class="col-6 col-md-4">
                                            <p class="text-muted text-uppercase mb-1"
                                                style="font-size:0.68rem; letter-spacing:0.05em;">Created
                                                At</p>
                                            <p class="mb-0" id="detailCreatedAt" style="font-size:0.85rem;"></p>
                                        </div>
                                        <div class="col-6 col-md-4">
                                            <p class="text-muted text-uppercase mb-1"
                                                style="font-size:0.68rem; letter-spacing:0.05em;">Scheduled
                                                At</p>
                                            <p class="mb-0" id="detailScheduledAt" style="font-size:0.85rem;"></p>
                                        </div>
                                        <div class="col-6 col-md-4">
                                            <p class="text-muted text-uppercase mb-1"
                                                style="font-size:0.68rem; letter-spacing:0.05em;">Sent At
                                            </p>
                                            <p class="mb-0" id="detailSentAt" style="font-size:0.85rem;"></p>
                                        </div>
                                    </div>

                                    {{-- Customの場合のみ表示 --}}
                                    <div id="detailCustomUsersWrap" style="display:none;">
                                        <p class="text-muted text-uppercase mb-2"
                                            style="font-size:0.68rem; letter-spacing:0.05em;">
                                            Target Users (<span id="detailCustomUsersCount">0</span>)
                                        </p>
                                        <div id="detailCustomUsersList" class="d-flex flex-wrap gap-1 mb-2"></div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" id="detailEditBtn">Edit
                                        Notification</button>
                                </div>
                            </div>
                        </div>
                    </div>



                </div>
            </div>
        </div>

        {{-- ============ TAB 2: CREATE / EDIT ============ --}}
        <div class="tab-pane fade {{ $activeTab === 'create' ? 'show active' : '' }}" id="tab-create"
            role="tabpanel">
            @php
                $isEditing = isset($editingNotification);
                $formAction = $isEditing
                    ? route('admin.notifications.update', $editingNotification->id)
                    : route('admin.notifications.store');
            @endphp

            <form id="notificationCreateForm" method="POST" action="{{ $formAction }}">
                @csrf
                @if ($isEditing)
                    @method('PUT')
                @endif
                <input type="hidden" name="action" id="formActionInput" value="schedule">

                <div class="row g-3">
                    <div class="col-12 col-lg-7">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body p-4">
                                <p class="text-muted text-uppercase mb-3"
                                    style="font-size:0.7rem; letter-spacing:0.05em;">
                                    {{ $isEditing ? 'Edit Notification' : 'Basic Information' }}
                                </p>

                                @unless ($isEditing)
                                    <div class="mb-3">
                                        <label class="form-label" style="font-size:0.8rem;">Use Template
                                            (optional)</label>
                                        <select class="form-select" id="createUseTemplate" name="template_id">
                                            <option value="">-- Start from scratch --</option>
                                            @foreach ($templates as $tpl)
                                                <option value="{{ $tpl->id }}" data-category="{{ $tpl->category }}"
                                                    data-title="{{ $tpl->title }}" data-body="{{ $tpl->body }}"
                                                    {{ old('template_id') == $tpl->id ? 'selected' : '' }}>
                                                    {{ $tpl->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endunless

                                <div class="mb-3">
                                    <label class="form-label fw-bold" style="font-size:0.8rem;">Notification
                                        Title</label>
                                    <input type="text" class="form-control" id="createTitleInput" name="title"
                                        value="{{ old('title', $isEditing ? $editingNotification->title : '') }}"
                                        placeholder="e.g. Summer Festival 2026 announcement">
                                    @error('title')
                                        <p class="text-danger mb-0 mt-1" style="font-size:0.75rem;">{{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold" style="font-size:0.8rem;">Category</label>
                                    @php $currentCategory = old('category', $isEditing ? $editingNotification->category : ''); @endphp
                                    <select class="form-select" id="createTypeSelect" name="category">
                                        <option value="">-- Select --</option>
                                        <option value="system" {{ $currentCategory == 'system' ? 'selected' : '' }}>
                                            System</option>
                                        <option value="comment" {{ $currentCategory == 'comment' ? 'selected' : '' }}>
                                            Comment</option>
                                        <option value="reply" {{ $currentCategory == 'reply' ? 'selected' : '' }}>
                                            Reply</option>
                                        <option value="like" {{ $currentCategory == 'like' ? 'selected' : '' }}>Like
                                        </option>
                                        <option value="event" {{ $currentCategory == 'event' ? 'selected' : '' }}>
                                            Event</option>
                                        <option value="item_alert"
                                            {{ $currentCategory == 'item_alert' ? 'selected' : '' }}>Item Alert
                                        </option>
                                        <option value="digest" {{ $currentCategory == 'digest' ? 'selected' : '' }}>
                                            Digest</option>
                                    </select>
                                    @error('category')
                                        <p class="text-danger mb-0 mt-1" style="font-size:0.75rem;">{{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold" style="font-size:0.8rem;">Body</label>
                                    <textarea class="form-control" id="createBodyInput" name="body" rows="4"
                                        placeholder="Enter the notification body.">{{ old('body', $isEditing ? $editingNotification->body : '') }}</textarea>
                                    @error('body')
                                        <p class="text-danger mb-0 mt-1" style="font-size:0.75rem;">{{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div class="mb-0">
                                    <label class="form-label" style="font-size:0.8rem;">Link URL (optional)</label>
                                    <input type="text" class="form-control" name="link_url"
                                        value="{{ old('link_url', $isEditing ? $editingNotification->data['link_url'] ?? '' : '') }}"
                                        placeholder="https://...">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-5">
                        <div class="card border-0 shadow-sm mb-3">
                            <div class="card-body p-4">
                                <p class="text-muted text-uppercase mb-3"
                                    style="font-size:0.7rem; letter-spacing:0.05em;">Delivery Settings</p>

                                <div class="mb-3">
                                    <label class="form-label fw-bold" style="font-size:0.8rem;">Target
                                        Audience</label>
                                    @php $currentTarget = old('target_type', $isEditing ? $editingNotification->target_type : 'all'); @endphp
                                    <select class="form-select" id="createTargetSelect" name="target_type">
                                        <option value="all" {{ $currentTarget == 'all' ? 'selected' : '' }}>All
                                            Users</option>
                                        <option value="subscriber"
                                            {{ $currentTarget == 'subscriber' ? 'selected' : '' }}>Subsc-member
                                            (Premium)</option>
                                        <option value="custom" {{ $currentTarget == 'custom' ? 'selected' : '' }}>
                                            Custom</option>
                                    </select>
                                    @error('target_type')
                                        <p class="text-danger mb-0 mt-1" style="font-size:0.75rem;">{{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div class="mb-3" id="customUserSearchWrap" style="display:none;">
                                    <label class="form-label" style="font-size:0.8rem;">Search Users</label>
                                    <div id="customUserTags" class="d-flex flex-wrap gap-1 mb-2"></div>
                                    <div class="position-relative">
                                        <input type="text" class="form-control" id="customUserSearchInput"
                                            placeholder="Type a name or email..." autocomplete="off">
                                        <div id="customUserSuggestions"
                                            class="list-group position-absolute w-100 shadow-sm"
                                            style="z-index:1000; max-height:220px; overflow-y:auto; display:none;">
                                        </div>
                                    </div>
                                    <div id="customUserHiddenInputs"></div>
                                    @error('user_ids')
                                        <p class="text-danger mb-0 mt-1" style="font-size:0.75rem;">{{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold" style="font-size:0.8rem;">Delivery
                                        Date/Time</label>
                                    @php
                                        $currentScheduledAt = old(
                                            'scheduled_at',
                                            $isEditing && $editingNotification->scheduled_at
                                                ? $editingNotification->scheduled_at->format('Y-m-d\TH:i')
                                                : '',
                                        );
                                    @endphp
                                    <input type="datetime-local" class="form-control" name="scheduled_at"
                                        value="{{ $currentScheduledAt }}">
                                    @error('scheduled_at')
                                        <p class="text-danger mb-0 mt-1" style="font-size:0.75rem;">{{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                @php
                                    $currentSendPush = old(
                                        'send_push',
                                        $isEditing ? $editingNotification->data['send_push'] ?? false : true,
                                    );
                                    $currentSendEmail = old(
                                        'send_email',
                                        $isEditing ? $editingNotification->data['send_email'] ?? false : false,
                                    );
                                @endphp
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" role="switch" id="pushToggle"
                                        name="send_push" value="1" {{ $currentSendPush ? 'checked' : '' }}>
                                    <label class="form-check-label" for="pushToggle" style="font-size:0.85rem;">Send
                                        push notification</label>
                                </div>
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input" type="checkbox" role="switch" id="emailToggle"
                                        name="send_email" value="1" {{ $currentSendEmail ? 'checked' : '' }}>
                                    <label class="form-check-label" for="emailToggle" style="font-size:0.85rem;">Also
                                        send email</label>
                                </div>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm mb-3">
                            <div class="card-body p-4">
                                <p class="text-muted text-uppercase mb-2"
                                    style="font-size:0.7rem; letter-spacing:0.05em;">Link to Event (optional)</p>
                                <select class="form-select mb-2">
                                    <option>No link</option>
                                    <option>Summer Festival 2026 (6/14–7/20)</option>
                                    <option>July Workshop (7/5)</option>
                                </select>
                                <p class="text-muted mb-0" style="font-size:0.75rem;">Linking will also display this
                                    on the calendar</p>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-outline-secondary flex-fill"
                                onclick="document.getElementById('formActionInput').value='draft';">Save Draft</button>
                            <button type="submit" class="btn btn-primary flex-fill"
                                onclick="document.getElementById('formActionInput').value='schedule';">
                                {{ $isEditing ? 'Update Notification' : 'Schedule Delivery' }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        {{-- ============ TAB 3: CALENDAR ============ --}}
        <div class="tab-pane fade {{ $activeTab === 'calendar' ? 'show active' : '' }}" id="tab-calendar"
            role="tabpanel">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary" id="calPrevMonth"><i
                                    class="fa-solid fa-chevron-left"></i></button>
                            <span class="fw-semibold" id="calMonthLabel">June 2026</span>
                            <button type="button" class="btn btn-sm btn-outline-secondary" id="calNextMonth"><i
                                    class="fa-solid fa-chevron-right"></i></button>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-outline-secondary active">Month</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary">Week</button>
                        </div>
                    </div>

                    <div class="notif-calendar-grid mb-3" id="notifCalendarGrid">
                        {{-- Day-of-week headers --}}
                        @foreach (['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $dow)
                            <div class="notif-cal-head">{{ $dow }}</div>
                        @endforeach

                        @php
                            // Dummy calendar cells for June 2026 (replace with real date logic in controller)
                            $calendarCells = [
                                ['day' => 25, 'other' => true, 'events' => []],
                                ['day' => 26, 'other' => true, 'events' => []],
                                ['day' => 27, 'other' => true, 'events' => []],
                                ['day' => 28, 'other' => true, 'events' => []],
                                ['day' => 29, 'other' => true, 'events' => []],
                                ['day' => 30, 'other' => true, 'events' => []],
                                ['day' => 31, 'other' => true, 'events' => []],
                                ['day' => 1, 'events' => []],
                                ['day' => 2, 'events' => []],
                                ['day' => 3, 'events' => []],
                                ['day' => 4, 'events' => []],
                                ['day' => 5, 'events' => [['label' => 'New Feature Release', 'type' => 'system']]],
                                ['day' => 6, 'events' => []],
                                ['day' => 7, 'events' => []],
                                ['day' => 8, 'events' => []],
                                ['day' => 9, 'today' => true, 'events' => []],
                                ['day' => 10, 'events' => [['label' => 'Summer Fest notice', 'type' => 'event']]],
                                ['day' => 11, 'events' => []],
                                ['day' => 12, 'events' => []],
                                ['day' => 13, 'events' => []],
                                ['day' => 14, 'events' => [['label' => '▶ Summer Festival', 'type' => 'event']]],
                                [
                                    'day' => 15,
                                    'events' => [
                                        ['label' => 'Maintenance notice', 'type' => 'system'],
                                        ['label' => 'Summer Fest period', 'type' => 'event'],
                                    ],
                                ],
                                ['day' => 16, 'events' => [['label' => 'Summer Fest period', 'type' => 'event']]],
                                ['day' => 17, 'events' => [['label' => 'Summer Fest period', 'type' => 'event']]],
                                ['day' => 18, 'events' => [['label' => 'Summer Fest period', 'type' => 'event']]],
                                ['day' => 19, 'events' => [['label' => 'Summer Fest period', 'type' => 'event']]],
                                ['day' => 20, 'events' => [['label' => 'Summer Fest period', 'type' => 'event']]],
                                ['day' => 21, 'events' => [['label' => 'Summer Fest period', 'type' => 'event']]],
                                ['day' => 22, 'events' => []],
                                ['day' => 23, 'events' => []],
                                ['day' => 24, 'events' => []],
                                ['day' => 25, 'events' => []],
                                ['day' => 26, 'events' => []],
                                ['day' => 27, 'events' => []],
                                ['day' => 28, 'events' => []],
                                ['day' => 29, 'events' => []],
                                ['day' => 30, 'events' => []],
                                ['day' => 1, 'other' => true, 'events' => []],
                                ['day' => 2, 'other' => true, 'events' => []],
                                ['day' => 3, 'other' => true, 'events' => []],
                                ['day' => 4, 'other' => true, 'events' => []],
                            ];
                        @endphp

                        @foreach ($calendarCells as $cell)
                            <div class="notif-cal-day {{ $cell['other'] ?? false ? 'other' : '' }}">
                                @if ($cell['today'] ?? false)
                                    <div class="notif-cal-day-num today">{{ $cell['day'] }}</div>
                                @else
                                    <div class="notif-cal-day-num">{{ $cell['day'] }}</div>
                                @endif
                                @foreach ($cell['events'] as $event)
                                    <div class="notif-cal-event notif-ev-{{ $event['type'] }}">
                                        {{ $event['label'] }}
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>

                    <div class="d-flex gap-3">
                        <div class="d-flex align-items-center gap-2" style="font-size:0.8rem;">
                            <span class="notif-cal-dot"
                                style="background-color:#E6F1FB; border:1px solid #B5D4F4;"></span> System
                            Notification
                        </div>
                        <div class="d-flex align-items-center gap-2" style="font-size:0.8rem;">
                            <span class="notif-cal-dot"
                                style="background-color:#EAF3DE; border:1px solid #C0DD97;"></span> Event /
                            Notification
                        </div>
                        <div class="d-flex align-items-center gap-2" style="font-size:0.8rem;">
                            <span class="notif-cal-dot"
                                style="background-color:#EEEDFE; border:1px solid #CECBF6;"></span> Auto-Notify
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- ============ TAB 4: TEMPLATES ============ --}}
        <div class="tab-pane fade {{ $activeTab === 'templates' ? 'show active' : '' }}" id="tab-templates"
            role="tabpanel">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <p class="text-muted text-uppercase mb-0" style="font-size:0.7rem; letter-spacing:0.05em;">
                    Auto-Notify
                    Template Management</p>
                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                    data-bs-target="#templateFormModal" id="addTemplateBtn">
                    <i class="fa-solid fa-plus me-1"></i> Add Template
                </button>
            </div>

            @forelse ($templates as $tpl)
                <div class="card border-0 shadow-sm mb-3 notif-template-card" role="button"
                    data-id="{{ $tpl->id }}" data-category="{{ $tpl->category }}"
                    data-type="{{ $tpl->type }}" data-title="{{ $tpl->title }}"
                    data-body="{{ $tpl->body }}" data-target-type="{{ $tpl->target_type }}"
                    data-meta="Target: {{ $tpl->target_type }}">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="d-flex align-items-center gap-2">

                                @php
                                    $categoryBadgeMap = [
                                        'system' => [
                                            'bg' => '#E6F1FB',
                                            'color' => '#0C447C',
                                            'icon' => 'fa-gear',
                                            'label' => 'System',
                                        ],
                                        'comment' => [
                                            'bg' => '#EAF3DE',
                                            'color' => '#3B6D11',
                                            'icon' => 'fa-comment',
                                            'label' => 'Comment',
                                        ],
                                        'reply' => [
                                            'bg' => '#EAF3DE',
                                            'color' => '#3B6D11',
                                            'icon' => 'fa-reply',
                                            'label' => 'Reply',
                                        ],
                                        'like' => [
                                            'bg' => '#FDEEF1',
                                            'color' => '#A3275B',
                                            'icon' => 'fa-heart',
                                            'label' => 'Like',
                                        ],
                                        'event' => [
                                            'bg' => '#FFF4E0',
                                            'color' => '#9A6700',
                                            'icon' => 'fa-calendar-day',
                                            'label' => 'Event',
                                        ],
                                        'item_alert' => [
                                            'bg' => '#EEEDFE',
                                            'color' => '#534AB7',
                                            'icon' => 'fa-shop',
                                            'label' => 'Item Alert',
                                        ],
                                        'digest' => [
                                            'bg' => '#E6F1FB',
                                            'color' => '#0C447C',
                                            'icon' => 'fa-cubes',
                                            'label' => 'Digest',
                                        ],
                                    ];
                                    $badge = $categoryBadgeMap[$tpl->category] ?? [
                                        'bg' => '#F1F1F1',
                                        'color' => '#555',
                                        'icon' => 'fa-tag',
                                        'label' => $tpl->category,
                                    ];
                                @endphp

                                <span class="badge rounded-pill"
                                    style="background-color:{{ $badge['bg'] }}; color:{{ $badge['color'] }}; font-weight:500;">
                                    <i class="fa-solid {{ $badge['icon'] }} me-1"></i> {{ $badge['label'] }}
                                </span>
                                <span class="fw-semibold" style="font-size:0.9rem;">{{ $tpl->title }}</span>
                            </div>

                            <div class="d-flex align-items-center gap-2 notif-card-actions">
                                <form method="POST"
                                    action="{{ route('admin.notification-templates.destroy', $tpl->id) }}"
                                    class="notif-delete-form mb-0"
                                    onsubmit="return confirm('Are you sure to delete this template?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm notif-delete-btn"
                                        data-title="{{ $tpl->title }}"
                                        onclick="event.stopPropagation();">Delete</button>
                                </form>
                            </div>
                        </div>
                        <p class="text-muted mb-2 text-truncate" style="font-size:0.8rem;">{{ $tpl->body }}
                        </p>
                        <p class="text-muted mb-0" style="font-size:0.7rem;">Target: {{ $tpl->target_type }}</p>
                    </div>
                </div>
            @empty
                <div class="text-center text-muted py-5">
                    <i class="fa-solid fa-file-circle-plus fa-2x mb-2"></i>
                    <p class="mb-0">No templates yet. Click "Add Template" to create one.</p>
                </div>
            @endforelse

            {{-- Template Preview Modal (共通1つをJSで内容書き換え) --}}
            <div class="modal fade" id="templatePreviewModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="d-flex align-items-center gap-2">
                                <span id="modalTplBadge" class="badge rounded-pill"></span>
                                <h6 class="modal-title mb-0" id="modalTplTitle"></h6>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p class="text-muted text-uppercase mb-1"
                                style="font-size:0.7rem; letter-spacing:0.05em;">
                                Message Preview</p>
                            <p class="mb-3" id="modalTplPreview" style="font-size:0.9rem;"></p>

                            <p class="text-muted text-uppercase mb-1"
                                style="font-size:0.7rem; letter-spacing:0.05em;">
                                Target</p>
                            <p class="text-muted mb-0" id="modalTplMeta" style="font-size:0.8rem;"></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary"
                                data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="modalTplEditBtn">Edit
                                Template</button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Template Form Modal (Add / Edit 共通) --}}
            <div class="modal fade" id="templateFormModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <form id="templateForm" method="POST"
                            action="{{ route('admin.notification-templates.store') }}">
                            @csrf
                            <input type="hidden" name="_method" id="templateFormMethod" value="POST">

                            <div class="modal-header">
                                <h6 class="modal-title mb-0" id="templateFormTitle">Add Template</h6>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                <div class="row g-3">
                                    <div class="col-12 col-md-6">
                                        <label class="form-label" style="font-size:0.8rem;">Category</label>
                                        <select class="form-select" name="category" required>
                                            <option value="">-- Select --</option>
                                            <option value="system">System</option>
                                            <option value="comment">Comment</option>
                                            <option value="reply">Reply</option>
                                            <option value="like">Like</option>
                                            <option value="event">Event</option>
                                            <option value="item_alert">Item Alert</option>
                                            <option value="digest">Digest</option>
                                        </select>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label class="form-label" style="font-size:0.8rem;">Title</label>
                                        <input type="text" class="form-control" name="title" required
                                            placeholder="e.g. Comment Notification">
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label" style="font-size:0.8rem;">Body</label>
                                        <textarea class="form-control" name="body" rows="3" required></textarea>
                                        <p class="text-muted mb-0 mt-1" style="font-size:0.72rem;">
                                            Write down necessary content.
                                        </p>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label class="form-label" style="font-size:0.8rem;">Target</label>
                                        <select class="form-select" name="target_type" required>
                                            <option value="all">All Users</option>
                                            <option value="post_author">Post Author</option>
                                            <option value="comment_author">Comment Author</option>
                                            <option value="subscriber">Subscriber</option>
                                            <option value="custom">Custom</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary"
                                    data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Save Template</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>

        {{-- 共通レイアウトエリア --}}
        {{-- Delete確認モーダル (共通1つをJSで内容書き換え) --}}
        <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold text-danger">
                            <i class="fa-solid fa-triangle-exclamation me-2"></i>Confirm Delete
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-0">
                            Delete "<strong id="deleteConfirmTitle"></strong>"? This cannot be undone.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary"
                            data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" id="deleteConfirmBtn">Delete</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
@php
    $templatesForJs = $templates
        ->map(function ($t) {
            return [
                'id' => $t->id,
                'category' => $t->category,
                'type' => $t->type,
                'title' => $t->title,
                'body' => $t->body,
            ];
        })
        ->values();

    $allUsersForJs = $users->map(fn($u) => ['id' => $u->id, 'name' => $u->name, 'email' => $u->email])->values();

@endphp

<script>
    const allUsersData = @json($allUsersForJs);
    const allTemplates = @json($templatesForJs);
    let selectedCustomUserIds = @json(old('user_ids', $isEditing ? $editingNotification->data['user_ids'] ?? [] : []));

    // 
    document.addEventListener('DOMContentLoaded', function() {
        const targetSelect = document.getElementById('createTargetSelect');
        const customWrap = document.getElementById('customUserSearchWrap');
        const searchInput = document.getElementById('customUserSearchInput');
        const suggestionsBox = document.getElementById('customUserSuggestions');
        const tagsBox = document.getElementById('customUserTags');
        const hiddenInputsBox = document.getElementById('customUserHiddenInputs');

        function toggleCustomWrap() {
            customWrap.style.display = (targetSelect.value === 'custom') ? '' : 'none';
        }
        targetSelect?.addEventListener('change', toggleCustomWrap);
        toggleCustomWrap(); // 初期表示 (old()復元時にもcustomなら開く)

        function renderTags() {
            tagsBox.innerHTML = '';
            hiddenInputsBox.innerHTML = '';

            selectedCustomUserIds.forEach(function(id) {
                const user = allUsersData.find(u => String(u.id) === String(id));
                if (!user) return;

                const tag = document.createElement('span');
                tag.className =
                    'badge bg-light text-dark border d-inline-flex align-items-center gap-1';
                tag.style.fontSize = '0.78rem';
                tag.innerHTML =
                    `${user.name} <button type="button" class="btn-close btn-close-sm" style="font-size:0.6rem;" data-id="${user.id}"></button>`;
                tagsBox.appendChild(tag);

                const hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.name = 'user_ids[]';
                hidden.value = user.id;
                hiddenInputsBox.appendChild(hidden);
            });

            tagsBox.querySelectorAll('button[data-id]').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const id = btn.getAttribute('data-id');
                    selectedCustomUserIds = selectedCustomUserIds.filter(uid => String(uid) !==
                        String(id));
                    renderTags();
                });
            });
        }

        function renderSuggestions(query) {
            const q = query.trim().toLowerCase();
            if (!q) {
                suggestionsBox.style.display = 'none';
                suggestionsBox.innerHTML = '';
                return;
            }

            const matches = allUsersData.filter(function(u) {
                if (selectedCustomUserIds.some(id => String(id) === String(u.id))) return false;
                return u.name.toLowerCase().includes(q) || (u.email && u.email.toLowerCase().includes(
                    q));
            }).slice(0, 8);

            if (matches.length === 0) {
                suggestionsBox.style.display = 'none';
                suggestionsBox.innerHTML = '';
                return;
            }

            suggestionsBox.innerHTML = matches.map(function(u) {
                return `<button type="button" class="list-group-item list-group-item-action py-1" style="font-size:0.82rem;" data-id="${u.id}">${u.name} <span class="text-muted">(${u.email})</span></button>`;
            }).join('');
            suggestionsBox.style.display = '';

            suggestionsBox.querySelectorAll('button[data-id]').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const id = btn.getAttribute('data-id');
                    if (!selectedCustomUserIds.some(uid => String(uid) === String(id))) {
                        selectedCustomUserIds.push(id);
                    }
                    searchInput.value = '';
                    suggestionsBox.style.display = 'none';
                    renderTags();
                });
            });
        }

        searchInput?.addEventListener('input', function(e) {
            renderSuggestions(e.target.value);
        });

        searchInput?.addEventListener('blur', function() {
            setTimeout(() => {
                suggestionsBox.style.display = 'none';
            }, 150);
        });

        renderTags(); // old()復元用
    });


    // List 表示
    document.addEventListener('DOMContentLoaded', function() {
        const statusBtnStyleMap = {
            draft: 'btn-outline-secondary',
            scheduled: 'btn-outline-warning',
            pending: 'btn-outline-warning',
            sent: 'btn-outline-success',
            failed: 'btn-outline-danger',
        };

        const statusBadgeStyleMap = {
            draft: 'bg-secondary',
            scheduled: 'bg-warning',
            pending: 'bg-warning',
            sent: 'bg-success',
            failed: 'bg-danger',
        };

        // 多重クリック防止
        const inFlightNotificationIds = new Set();

        document.querySelectorAll('.notif-status-option').forEach(function(item) {
            item.addEventListener('click', function(e) {
                e.preventDefault();

                const notificationId = this.dataset.notificationId;
                const newStatus = this.dataset.status;
                const btn = document.getElementById(`currentStatusBtn_${notificationId}`);
                const badge = document.getElementById(`statusBadge_${notificationId}`);

                // 多重クリック防止
                if (inFlightNotificationIds.has(notificationId)) return;
                inFlightNotificationIds.add(notificationId);

                fetch(`/admin/notifications/${notificationId}/status`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector(
                                'meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            status: newStatus
                        }),
                    })
                    .then(function(res) {
                        if (!res.ok) throw new Error('Network response was not ok');
                        return res.json();
                    })
                    .then(function(data) {
                        if (data.success) {
                            const label = data.status.charAt(0).toUpperCase() + data.status
                                .slice(1);

                            // Actionsボタン側
                            btn.textContent = label;
                            Object.values(statusBtnStyleMap).forEach(function(cls) {
                                btn.classList.remove(cls);
                            });
                            btn.classList.add(statusBtnStyleMap[data.status] ||
                                'btn-outline-secondary');

                            // Status列(表示専用バッジ)側
                            if (badge) {
                                badge.textContent = label;
                                Object.values(statusBadgeStyleMap).forEach(function(cls) {
                                    badge.classList.remove(cls);
                                });
                                badge.classList.add(statusBadgeStyleMap[data.status] ||
                                    'bg-light');
                            }
                        }
                    })
                    .catch(function(err) {
                        console.error('Status update failed:', err);
                        alert('Statusの更新に失敗しました。もう一度お試しください。');
                    })
                    .finally(function() {
                        inFlightNotificationIds.delete(notificationId);
                    });
            });
        });
    });

    //  List: Filter (Category / Status / Search) =====================
    document.addEventListener('DOMContentLoaded', function() {
        const categorySelect = document.getElementById('filterCategory');
        const statusSelect = document.getElementById('filterStatus');
        const searchInput = document.getElementById('filterSearch');
        const rows = document.querySelectorAll('.notif-row');

        function applyFilters() {
            const categoryValue = categorySelect?.value || '';
            const statusValue = statusSelect?.value || '';
            const searchValue = (searchInput?.value || '').trim().toLowerCase();

            let visibleCount = 0;

            rows.forEach(function(row) {
                const rowCategory = row.dataset.category || '';
                const rowStatus = row.dataset.status || '';
                const rowTitleEl = row.querySelector('.fw-semibold');
                const rowTitle = rowTitleEl ? rowTitleEl.textContent.trim().toLowerCase() : '';

                const matchesCategory = !categoryValue || rowCategory === categoryValue;
                const matchesStatus = !statusValue || rowStatus === statusValue;
                const matchesSearch = !searchValue || rowTitle.includes(searchValue);

                const isVisible = matchesCategory && matchesStatus && matchesSearch;
                row.style.display = isVisible ? '' : 'none';

                if (isVisible) visibleCount++;
            });

            // 絞り込み結果が0件の場合のメッセージ表示
            let noResultRow = document.getElementById('notifNoResultRow');
            if (visibleCount === 0) {
                if (!noResultRow) {
                    noResultRow = document.createElement('tr');
                    noResultRow.id = 'notifNoResultRow';
                    noResultRow.innerHTML = `
                    <td colspan="7" class="text-center text-muted py-4">
                        No notifications match the current filters.
                    </td>
                `;
                    document.querySelector('table tbody')?.appendChild(noResultRow);
                }
            } else if (noResultRow) {
                noResultRow.remove();
            }
        }

        categorySelect?.addEventListener('change', applyFilters);
        statusSelect?.addEventListener('change', applyFilters);
        searchInput?.addEventListener('input', applyFilters);
    });

    // Notification: Detail Modal =====================

    document.addEventListener('DOMContentLoaded', function() {
        const notifDetailModalEl = document.getElementById('notifDetailModal');
        let currentDetailData = null;

        if (notifDetailModalEl) {
            notifDetailModalEl.addEventListener('show.bs.modal', function(event) {
                const btn = event.relatedTarget;
                if (!btn) return;

                currentDetailData = {
                    id: btn.getAttribute('data-id'),
                    ntfId: btn.getAttribute('data-ntf-id'),
                    category: btn.getAttribute('data-category'),
                    categoryLabel: btn.getAttribute('data-category-label'),
                    categoryBg: btn.getAttribute('data-category-bg'),
                    categoryColor: btn.getAttribute('data-category-color'),
                    categoryIcon: btn.getAttribute('data-category-icon'),
                    title: btn.getAttribute('data-title'),
                    body: btn.getAttribute('data-body'),
                    targetType: btn.getAttribute('data-target-type'),
                    status: btn.getAttribute('data-status'),
                    linkUrl: btn.getAttribute('data-link-url'),
                    sendPush: btn.getAttribute('data-send-push') === '1',
                    sendEmail: btn.getAttribute('data-send-email') === '1',
                    userIds: JSON.parse(btn.getAttribute('data-user-ids') || '[]'),
                    createdAt: btn.getAttribute('data-created-at'),
                    scheduledAt: btn.getAttribute('data-scheduled-at'),
                    sentAt: btn.getAttribute('data-sent-at'),
                };

                // Header: Category badge + Notification ID
                const catBadge = document.getElementById('detailCategoryBadge');
                catBadge.style.backgroundColor = currentDetailData.categoryBg;
                catBadge.style.color = currentDetailData.categoryColor;
                catBadge.innerHTML =
                    `<i class="fa-solid ${currentDetailData.categoryIcon} me-1"></i> ${currentDetailData.categoryLabel}`;
                document.getElementById('detailNtfId').textContent = currentDetailData.ntfId;

                // Title / Body
                document.getElementById('detailTitle').textContent = currentDetailData.title;
                document.getElementById('detailBody').textContent = currentDetailData.body;

                // Status badge
                const statusBadgeStyleMap = {
                    draft: 'bg-secondary',
                    scheduled: 'bg-warning',
                    pending: 'bg-warning',
                    sent: 'bg-success',
                    failed: 'bg-danger',
                };
                const statusBadge = document.getElementById('detailStatusBadge');
                statusBadge.textContent = currentDetailData.status.charAt(0).toUpperCase() +
                    currentDetailData
                    .status.slice(1);
                statusBadge.className =
                    `badge rounded-pill px-2 py-1 ${statusBadgeStyleMap[currentDetailData.status] || 'bg-light text-dark'}`;

                // Target
                const targetLabelMap = {
                    all: 'All Users',
                    subscriber: 'Subscribers',
                    custom: 'Custom'
                };
                document.getElementById('detailTargetType').textContent = targetLabelMap[
                    currentDetailData
                    .targetType] || currentDetailData.targetType;

                // Delivery method
                let deliveryLabel = '-';
                if (currentDetailData.sendPush && currentDetailData.sendEmail) deliveryLabel =
                    'Push + Email';
                else if (currentDetailData.sendPush) deliveryLabel = 'Push';
                else if (currentDetailData.sendEmail) deliveryLabel = 'Email';
                document.getElementById('detailDeliveryMethod').textContent = deliveryLabel;

                // Link URL
                document.getElementById('detailLinkUrl').textContent = currentDetailData.linkUrl || '-';

                // Dates
                document.getElementById('detailCreatedAt').textContent = currentDetailData.createdAt ||
                    '-';
                document.getElementById('detailScheduledAt').textContent = currentDetailData
                    .scheduledAt || '-';
                document.getElementById('detailSentAt').textContent = currentDetailData.sentAt || '-';

                // Custom target users
                const customWrap = document.getElementById('detailCustomUsersWrap');
                const customList = document.getElementById('detailCustomUsersList');
                const customCount = document.getElementById('detailCustomUsersCount');

                if (currentDetailData.targetType === 'custom' && currentDetailData.userIds.length > 0) {
                    customWrap.style.display = '';
                    customCount.textContent = currentDetailData.userIds.length;
                    customList.innerHTML = currentDetailData.userIds.map(function(id) {
                        const user = allUsersData.find(u => String(u.id) === String(id));
                        const name = user ? user.name : `User #${id}`;
                        return `<span class="badge bg-light text-dark border" style="font-size:0.78rem;">${name}</span>`;
                    }).join('');
                } else {
                    customWrap.style.display = 'none';
                }
            });
        }

        // Detail->Edit
        document.getElementById('detailEditBtn')?.addEventListener('click', function() {
            if (!currentDetailData) return;
            window.location.href = `/admin/notifications/${currentDetailData.id}/edit`;
        });
    });

    // calender
    document.addEventListener('DOMContentLoaded', function() {

        //  Calendar =====================
        const monthLabel = document.getElementById('calMonthLabel');
        const prevBtn = document.getElementById('calPrevMonth');
        const nextBtn = document.getElementById('calNextMonth');

        const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September',
            'October', 'November', 'December'
        ];
        let currentMonthIndex = 5; // June
        let currentYear = 2026;

        function renderMonthLabel() {
            monthLabel.textContent = months[currentMonthIndex] + ' ' + currentYear;
        }

        prevBtn?.addEventListener('click', function() {
            currentMonthIndex--;
            if (currentMonthIndex < 0) {
                currentMonthIndex = 11;
                currentYear--;
            }
            renderMonthLabel();
            // TODO: re-fetch / re-render calendar cells for the new month
        });

        nextBtn?.addEventListener('click', function() {
            currentMonthIndex++;
            if (currentMonthIndex > 11) {
                currentMonthIndex = 0;
                currentYear++;
            }
            renderMonthLabel();
            // TODO: re-fetch / re-render calendar cells for the new month
        });
    });

    //  共通: Delete確認モーダル =====================
    document.addEventListener('DOMContentLoaded', function() {
        // ボタンクリック時にカードへの伝播を止める(Templates card等の親クリックトリガーとの衝突防止)
        document.querySelectorAll('.notif-delete-btn').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        });

        const deleteConfirmModalEl = document.getElementById('deleteConfirmModal');
        const deleteConfirmModal = deleteConfirmModalEl ? new bootstrap.Modal(deleteConfirmModalEl) : null;
        let formPendingDelete = null;

        document.querySelectorAll('.notif-delete-form').forEach(function(form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault(); //常にいったん止める

                const title = form.querySelector('.notif-delete-btn').getAttribute(
                    'data-title');
                document.getElementById('deleteConfirmTitle').textContent = title;

                formPendingDelete = form;
                deleteConfirmModal.show();
            });
        });

        document.getElementById('deleteConfirmBtn')?.addEventListener('click', function() {
            if (formPendingDelete) {
                formPendingDelete.submit();
            }
            deleteConfirmModal.hide();
        });
    });

    document.getElementById('deleteConfirmBtn')?.addEventListener('click', function() {
        if (formPendingDelete) {
            formPendingDelete.submit(); // モーダルの「Delete」を押したら実際に送信
        }
        deleteConfirmModal.hide();
    });

    //  Templates: Preview Modal =====================
    document.addEventListener('DOMContentLoaded', function() {
        const templateModalEl = document.getElementById('templatePreviewModal');
        const templatePreviewModal = templateModalEl ? new bootstrap.Modal(templateModalEl) : null;
        let currentPreviewData = null;

        function openPreviewModal(card) {
            currentPreviewData = {
                id: card.getAttribute('data-id'),
                category: card.getAttribute('data-category'),
                type: card.getAttribute('data-type'),
                title: card.getAttribute('data-title'),
                body: card.getAttribute('data-body'),
                targetType: card.getAttribute('data-target-type'),
                meta: card.getAttribute('data-meta'),
            };

            const typeLabelMap = {
                auto: 'Auto-Notify',
                scheduled: 'Scheduled',
                manual: 'System'
            };

            const badge = document.getElementById('modalTplBadge');
            badge.innerHTML =
                `<i class="fa-solid fa-circle me-1"></i> ${typeLabelMap[currentPreviewData.type] || currentPreviewData.type}`;

            document.getElementById('modalTplTitle').textContent = currentPreviewData.title;
            document.getElementById('modalTplPreview').textContent = currentPreviewData.body;
            document.getElementById('modalTplMeta').textContent = currentPreviewData.meta;

            templatePreviewModal.show();
        }

        document.querySelectorAll('.notif-template-card').forEach(function(card) {
            card.addEventListener('click', function(e) {
                // Deleteボタン(フォーム)がクリックされた場合はモーダルを開かない
                if (e.target.closest('.notif-delete-form')) {
                    return;
                }
                openPreviewModal(card);
            });
        });

        document.getElementById('modalTplEditBtn')?.addEventListener('click', function() {
            if (!currentPreviewData) return;
            templatePreviewModal.hide();
            openTemplateFormForEdit(currentPreviewData);
        });

        function openTemplateFormForEdit(data) {
            const form = document.getElementById('templateForm');

            form.action = `/admin/notification-templates/${data.id}`;
            document.getElementById('templateFormMethod').value = 'PUT';
            document.getElementById('templateFormTitle').textContent = 'Edit Template';

            form.querySelector('[name="category"]').value = data.category || '';
            form.querySelector('[name="title"]').value = data.title || '';
            form.querySelector('[name="body"]').value = data.body || '';
            form.querySelector('[name="target_type"]').value = data.targetType || 'custom';

            const formModal = new bootstrap.Modal(document.getElementById('templateFormModal'));
            formModal.show();
        }

        document.getElementById('addTemplateBtn')?.addEventListener('click', function() {
            const form = document.getElementById('templateForm');
            form.reset();
            form.action = '{{ route('admin.notification-templates.store') }}';
            document.getElementById('templateFormMethod').value = 'POST';
            document.getElementById('templateFormTitle').textContent = 'Add Template';
        });

        document.getElementById('createUseTemplate')?.addEventListener('change', function(e) {
            const selectedId = e.target.value;
            if (selectedId === '') return;

            const tpl = allTemplates.find(t => String(t.id) === String(selectedId));
            if (!tpl) return;

            document.getElementById('createTitleInput').value = tpl.title;
            document.getElementById('createBodyInput').value = tpl.body;

            const typeSelect = document.getElementById('createTypeSelect');
            if (typeSelect) {
                typeSelect.value = tpl.category || '';
            }

            document.getElementById('tab-create').dataset.sourceTemplateId = tpl.id;
        });
    });

    //  Templates: Add =====================
    document.getElementById('addTemplateBtn')?.addEventListener('click', function() {
        const form = document.getElementById('templateForm');
        form.reset();
        form.action = '{{ route('admin.notification-templates.store') }}';
        document.getElementById('templateFormMethod').value = 'POST';
        document.getElementById('templateFormTitle').textContent = 'Add Template';
    });

    //  Create tab: Use Template =====================
    document.getElementById('createUseTemplate')?.addEventListener('change', function(e) {
        const selectedId = e.target.value;
        if (selectedId === '') return;

        const tpl = allTemplates.find(t => String(t.id) === String(selectedId));
        if (!tpl) return;

        document.getElementById('createTitleInput').value = tpl.title;
        document.getElementById('createBodyInput').value = tpl.body;

        const typeSelect = document.getElementById('createTypeSelect');
        if (typeSelect) {
            // notif_templates.category は notifications.category と同じ値なので、そのまま反映できる
            typeSelect.value = tpl.category || '';
        }

        // どのテンプレートから来たかを記録 (送信時に template_id として使う)
        document.getElementById('tab-create').dataset.sourceTemplateId = tpl.id;
    });
</script>
@endpush
