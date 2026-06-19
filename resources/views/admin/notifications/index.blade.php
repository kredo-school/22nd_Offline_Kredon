@extends('layouts.admin')

@section('title', 'Notification')

@section('content')
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
                <p class="text-muted mb-0" style="font-size:0.85rem;">Manage system, event, and auto-generated notifications
                </p>
            </div>
        </div>

        {{-- Metric cards --}}
        <div class="row g-3 mb-4">
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card h-100 border-0 shadow-sm p-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <small class="text-muted d-block mb-1" style="font-size: 0.75rem;">Total Notifications</small>
                            <h3 class="mb-0 fw-bold" style="font-size: 1.5rem;">14,560</h3>
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
                            <small class="text-muted d-block mb-1" style="font-size: 0.75rem;">Scheduled Digests
                                (Today)</small>
                            <h3 class="mb-0 fw-bold text-primary" style="font-size: 1.5rem;">5 <span
                                    style="font-size: 0.85rem;" class="fw-normal text-muted">/ 20:00 Send</span></h3>
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
                            <small class="text-muted d-block mb-1" style="font-size: 0.75rem;">Active Urgent Alerts</small>
                            <h3 class="mb-0 fw-bold text-danger" style="font-size: 1.5rem;">1</h3>
                        </div>
                        <div class="bg-danger-subtle rounded p-2 text-danger">
                            <i class="fa-solid fa-bullhorn fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card h-100 border-0 shadow-sm p-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <small class="text-muted d-block mb-1" style="font-size: 0.75rem;">Reported / Banned
                                Comments</small>
                            <h3 class="mb-0 fw-bold text-warning" style="font-size: 1.5rem;">12 <span
                                    style="font-size: 0.75rem;"
                                    class="badge bg-danger rounded-pill align-middle ms-1">Pending</span></h3>
                        </div>
                        <div class="bg-warning-subtle rounded p-2 text-warning">
                            <i class="fa-solid fa-comment-slash fa-lg"></i>
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
                            <select class="form-select form-select-sm" style="width:auto;">
                                <option>All Types</option>
                                <option>System</option>
                                <option>Event</option>
                                <option>Auto-Notify</option>
                            </select>
                            <select class="form-select form-select-sm" style="width:auto;">
                                <option>All Status</option>
                                <option>Active</option>
                                <option>Scheduled</option>
                                <option>Draft</option>
                            </select>
                            <input type="text" class="form-control form-control-sm flex-grow-1"
                                placeholder="Search by title..." style="min-width:200px;">
                        </div>

                        {{-- Table --}}
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0" style="font-size:0.82rem;">
                                        <thead class="table-light">
                                            <tr>
                                                <th style="width:120px;">Notification ID</th>
                                                <th style="width:140px;">Type (Trigger)</th>
                                                <th>Content / Message</th>
                                                <th style="width:130px;" class="text-center">Delivery Method</th>
                                                <th style="width:120px;" class="text-center">Status</th>
                                                <th style="width:140px;">Send Date/Time</th>
                                                <th style="width:100px;" class="text-start">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-muted fw-mono">NTF-00125</td>
                                                <td>
                                                    <span class="badge bg-light text-dark border"><i
                                                            class="fa-solid fa-shop me-1 text-secondary"></i> Market
                                                        Item</span>
                                                </td>
                                                <td>
                                                    <div class="fw-semibold">[Digest] 本日の新着アイテム（ガジェットカテゴリ5件）</div>
                                                    <div class="text-muted" style="font-size:0.72rem;">Target: Users
                                                        interested in Gadgets</div>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge bg-info-subtle text-info px-2 py-1"><i
                                                            class="fa-solid fa-cubes me-1"></i> Digest</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge rounded-pill bg-warning px-2 py-1"
                                                        style="font-size:0.72rem;">Scheduled</span>
                                                </td>
                                                <td class="text-muted">2026-06-17 20:00 PM</td>
                                                <td>
                                                    <div class="d-flex gap-1">
                                                        <a href="#"
                                                            class="btn btn-outline-secondary btn-sm py-0 px-2"
                                                            style="font-size:0.72rem;">Detail</a>
                                                        <button class="btn btn-outline-secondary btn-sm py-0 px-2"
                                                            style="font-size:0.72rem;">Edit</button>
                                                        <button class="btn btn-outline-danger btn-sm py-0 px-2"
                                                            style="font-size:0.72rem;">Delete</button>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="text-muted fw-mono">NTF-00124</td>
                                                <td>
                                                    <span class="badge bg-light text-dark border"><i
                                                            class="fa-solid fa-calendar-day me-1 text-secondary"></i>
                                                        Event
                                                        Alert</span>
                                                </td>
                                                <td>
                                                    <div class="fw-semibold">[Reminder] 『Kredon Beach Clean』申込締切あと1日
                                                    </div>
                                                    <div class="text-muted" style="font-size:0.72rem;">Target: Event
                                                        Participants</div>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge bg-info-subtle text-info px-2 py-1"><i
                                                            class="fa-solid fa-cubes me-1"></i> Digest</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge rounded-pill bg-success px-2 py-1"
                                                        style="font-size:0.72rem;">Sent</span>
                                                </td>
                                                <td class="text-muted">2026-06-17 09:00 AM</td>
                                                <td>
                                                    <div class="d-flex gap-1">
                                                        <a href="#"
                                                            class="btn btn-outline-secondary btn-sm py-0 px-2"
                                                            style="font-size:0.72rem;">Detail</a>
                                                        <button class="btn btn-outline-secondary btn-sm py-0 px-2"
                                                            style="font-size:0.72rem;">Edit</button>
                                                        <button class="btn btn-outline-danger btn-sm py-0 px-2"
                                                            style="font-size:0.72rem;">Delete</button>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="text-muted fw-mono">NTF-00123</td>
                                                <td>
                                                    <span class="badge bg-light text-dark border"><i
                                                            class="fa-solid fa-comment me-1 text-secondary"></i> New
                                                        Comment</span>
                                                </td>
                                                <td>
                                                    <div class="text-dark"><strong>User@MikeB</strong> commented on
                                                        UserA's
                                                        post.</div>
                                                    <div class="text-muted text-truncate"
                                                        style="font-size:0.72rem; max-width: 350px;">
                                                        「これすごく良いですね！まだ在庫はありますか？」</div>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge bg-light text-dark border px-2 py-1"><i
                                                            class="fa-solid fa-bolt text-warning me-1"></i> Instant</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge rounded-pill bg-success px-2 py-1"
                                                        style="font-size:0.72rem;">Sent</span>
                                                </td>
                                                <td class="text-muted">2026-06-17 14:30 PM</td>
                                                <td>
                                                    <div class="d-flex gap-1">
                                                        <a href="#"
                                                            class="btn btn-outline-secondary btn-sm py-0 px-2"
                                                            style="font-size:0.72rem;">Detail</a>
                                                        <button class="btn btn-outline-secondary btn-sm py-0 px-2"
                                                            style="font-size:0.72rem;">Edit</button>
                                                        <button class="btn btn-outline-danger btn-sm py-0 px-2"
                                                            style="font-size:0.72rem;">Delete</button>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="text-muted fw-mono">NTF-00122</td>
                                                <td>
                                                    <span class="badge bg-light text-dark border"><i
                                                            class="fa-solid fa-reply me-1 text-secondary"></i> Reply
                                                        Sent</span>
                                                </td>
                                                <td>
                                                    <div class="text-dark"><strong>User@User</strong> replied to MikeB's
                                                        comment.</div>
                                                    <div class="text-muted text-truncate"
                                                        style="font-size:0.72rem; max-width: 350px;">
                                                        「横から失礼します。私もそのイベント参加予定です！」</div>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge bg-light text-dark border px-2 py-1"><i
                                                            class="fa-solid fa-bolt text-warning me-1"></i> Instant</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge rounded-pill bg-success px-2 py-1"
                                                        style="font-size:0.72rem;">Sent</span>
                                                </td>
                                                <td class="text-muted">2026-06-17 14:15 PM</td>
                                                <td>
                                                    <div class="d-flex gap-1">
                                                        <a href="#"
                                                            class="btn btn-outline-secondary btn-sm py-0 px-2"
                                                            style="font-size:0.72rem;">Detail</a>
                                                        <button class="btn btn-outline-secondary btn-sm py-0 px-2"
                                                            style="font-size:0.72rem;">Edit</button>
                                                        <button class="btn btn-outline-danger btn-sm py-0 px-2"
                                                            style="font-size:0.72rem;">Delete</button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- ============ TAB 2: CREATE / EDIT ============ --}}
            <div class="tab-pane fade {{ $activeTab === 'create' ? 'show active' : '' }}" id="tab-create"
                role="tabpanel">
                <div class="row g-3">
                    <div class="col-12 col-lg-7">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body p-4">
                                <p class="text-muted text-uppercase mb-3"
                                    style="font-size:0.7rem; letter-spacing:0.05em;">Basic Information</p>

                                {{-- Use Template: テンプレートの一覧から選ぶだけのシンプルな select --}}
                                <div class="mb-3">
                                    <label class="form-label" style="font-size:0.8rem;">Use Template (optional)</label>
                                    <select class="form-select" id="createUseTemplate">
                                        <option value="">-- Start from scratch --</option>
                                        @foreach ($templates as $tpl)
                                            <option value="{{ $tpl->id }}" data-category="{{ $tpl->category }}"
                                                data-type="{{ $tpl->type }}" data-title="{{ $tpl->title }}"
                                                data-body="{{ $tpl->body }}">
                                                {{ $tpl->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold" style="font-size:0.8rem;">Notification
                                        Title</label>
                                    <input type="text" class="form-control" id="createTitleInput"
                                        placeholder="e.g. Summer Festival 2026 announcement">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold" style="font-size:0.8rem;">Type</label>
                                    <select class="form-select" id="createTypeSelect">
                                        <option value="system">System Notification</option>
                                        <option value="event">Event Notification</option>
                                        <option value="auto">Auto-Notify (Comment / Review)</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold" style="font-size:0.8rem;">Body</label>
                                    <textarea class="form-control" id="createBodyInput" rows="4" placeholder="Enter the notification body."></textarea>
                                </div>

                                <div class="mb-0">
                                    <label class="form-label" style="font-size:0.8rem;">Link URL (optional)</label>
                                    <input type="text" class="form-control" placeholder="https://...">
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
                                    <label class="form-label fw-bold" style="font-size:0.8rem;">Target Audience</label>
                                    <select class="form-select" id="createTargetSelect">
                                        <option value="all">All Users</option>
                                        <option value="custom">Specific Segment</option>
                                        <option value="auto">On Event Trigger (Auto)</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold" style="font-size:0.8rem;">Delivery
                                        Date/Time</label>
                                    <input type="datetime-local" class="form-control">
                                </div>

                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" role="switch" id="pushToggle"
                                        checked>
                                    <label class="form-check-label" for="pushToggle" style="font-size:0.85rem;">Send
                                        push
                                        notification</label>
                                </div>
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input" type="checkbox" role="switch" id="emailToggle">
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
                                <p class="text-muted mb-0" style="font-size:0.75rem;">Linking will also display this on
                                    the calendar</p>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-outline-secondary flex-fill">Save Draft</button>
                            <button type="button" class="btn btn-primary flex-fill">Schedule Delivery</button>
                        </div>
                    </div>
                </div>
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
                    <div class="card border-0 shadow-sm mb-3 notif-template-card" role="button" data-bs-toggle="modal"
                        data-bs-target="#templatePreviewModal" data-id="{{ $tpl->id }}"
                        data-category="{{ $tpl->category }}" data-type="{{ $tpl->type }}"
                        data-title="{{ $tpl->title }}" data-body="{{ $tpl->body }}"
                        data-trigger-event="{{ $tpl->trigger_event }}" data-schedule-cron="{{ $tpl->schedule_cron }}"
                        data-target-type="{{ $tpl->target_type }}"
                        data-meta="Trigger: {{ $tpl->trigger_event ?? 'manual' }} / Target: {{ $tpl->target_type }}">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="d-flex align-items-center gap-2">
                                    @if ($tpl->type === 'auto')
                                        <span class="badge rounded-pill"
                                            style="background-color:#EEEDFE; color:#3C3489; font-weight:500;">
                                            <i class="fa-solid fa-bolt me-1"></i> Auto-Notify
                                        </span>
                                    @elseif ($tpl->type === 'scheduled')
                                        <span class="badge rounded-pill"
                                            style="background-color:#EAF3DE; color:#3B6D11; font-weight:500;">
                                            <i class="fa-solid fa-clock me-1"></i> Scheduled
                                        </span>
                                    @else
                                        <span class="badge rounded-pill"
                                            style="background-color:#E6F1FB; color:#0C447C; font-weight:500;">
                                            <i class="fa-solid fa-gear me-1"></i> System
                                        </span>
                                    @endif
                                    <span class="fw-semibold" style="font-size:0.9rem;">{{ $tpl->title }}</span>
                                </div>
                                <div class="d-flex align-items-center gap-2 notif-card-actions">
                                    <form method="POST"
                                        action="{{ route('admin.notification-templates.destroy', $tpl->id) }}"
                                        class="notif-delete-form mb-0" onclick="event.stopPropagation();">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm notif-delete-btn"
                                            data-title="{{ $tpl->title }}">Delete</button>
                                    </form>
                                </div>
                            </div>
                            <p class="text-muted mb-2 text-truncate" style="font-size:0.8rem;">{{ $tpl->body }}</p>
                            <p class="text-muted mb-0" style="font-size:0.7rem;">Trigger:
                                {{ $tpl->trigger_event ?? 'manual' }} / Target: {{ $tpl->target_type }}</p>
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
                                    Trigger / Target</p>
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
                                            <label class="form-label" style="font-size:0.8rem;">Type</label>
                                            <select class="form-select" name="type" id="templateFormType" required>
                                                <option value="manual">Manual</option>
                                                <option value="auto">Auto</option>
                                                <option value="scheduled">Scheduled</option>
                                            </select>
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label" style="font-size:0.8rem;">Title</label>
                                            <input type="text" class="form-control" name="title" required
                                                placeholder="e.g. Comment Notification">
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label" style="font-size:0.8rem;">Body</label>
                                            <textarea class="form-control" name="body" rows="3" required></textarea>
                                            <p class="text-muted mb-0 mt-1" style="font-size:0.72rem;">
                                                You can use variables like <code>@{{ commenter_name }}</code>,
                                                <code>@{{ post_title }}</code>, etc.
                                            </p>
                                        </div>

                                        <div class="col-12 col-md-6" id="templateFormTriggerWrap">
                                            <label class="form-label" style="font-size:0.8rem;">Trigger Event</label>
                                            <input type="text" class="form-control" name="trigger_event"
                                                placeholder="e.g. comment.created">
                                        </div>

                                        <div class="col-12 col-md-6" id="templateFormCronWrap" style="display:none;">
                                            <label class="form-label" style="font-size:0.8rem;">Schedule (cron)</label>
                                            <input type="text" class="form-control" name="schedule_cron"
                                                placeholder="e.g. 0 20 * * *">
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

                                        <div class="col-12 col-md-6 d-flex align-items-end">
                                            <div class="form-check form-switch mb-0">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    name="is_active" value="1" id="templateFormActive" checked>
                                                <label class="form-check-label" for="templateFormActive"
                                                    style="font-size:0.85rem;">Active</label>
                                            </div>
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

        </div>
    </div>
@endsection

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
    @endphp
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // ===================== Calendar =====================
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

            // ===================== Templates: Delete =====================
            // Delete はフォーム送信。送信前に確認ダイアログを挟むだけ。
            document.querySelectorAll('.notif-delete-form').forEach(function(form) {
                form.addEventListener('submit', function(e) {
                    const title = form.querySelector('.notif-delete-btn').getAttribute(
                        'data-title');
                    if (!confirm(`Delete template "${title}"? This cannot be undone.`)) {
                        e.preventDefault();
                    }
                });
            });

            // ===================== Templates: Preview Modal =====================
            const templateModalEl = document.getElementById('templatePreviewModal');
            let currentPreviewData = null;

            if (templateModalEl) {
                templateModalEl.addEventListener('show.bs.modal', function(event) {
                    const card = event.relatedTarget;
                    if (!card) return;

                    currentPreviewData = {
                        id: card.getAttribute('data-id'),
                        category: card.getAttribute('data-category'),
                        type: card.getAttribute('data-type'),
                        title: card.getAttribute('data-title'),
                        body: card.getAttribute('data-body'),
                        triggerEvent: card.getAttribute('data-trigger-event'),
                        scheduleCron: card.getAttribute('data-schedule-cron'),
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
                });
            }

            // Preview modal 内の Edit ボタン → Form modal を編集モードで開く
            document.getElementById('modalTplEditBtn')?.addEventListener('click', function() {
                if (!currentPreviewData) return;

                const previewModalInstance = bootstrap.Modal.getInstance(templateModalEl);
                previewModalInstance.hide();

                openTemplateFormForEdit(currentPreviewData);
            });

            function openTemplateFormForEdit(data) {
                const form = document.getElementById('templateForm');

                form.action = `/admin/notification-templates/${data.id}`;
                document.getElementById('templateFormMethod').value = 'PUT';
                document.getElementById('templateFormTitle').textContent = 'Edit Template';

                form.querySelector('[name="category"]').value = data.category || '';
                form.querySelector('[name="type"]').value = data.type || 'manual';
                form.querySelector('[name="title"]').value = data.title || '';
                form.querySelector('[name="body"]').value = data.body || '';
                form.querySelector('[name="trigger_event"]').value = data.triggerEvent || '';
                form.querySelector('[name="schedule_cron"]').value = data.scheduleCron || '';
                form.querySelector('[name="target_type"]').value = data.targetType || 'custom';

                toggleTriggerCronFields();

                const formModal = new bootstrap.Modal(document.getElementById('templateFormModal'));
                formModal.show();
            }

            // ===================== Templates: Add =====================
            document.getElementById('addTemplateBtn')?.addEventListener('click', function() {
                const form = document.getElementById('templateForm');
                form.reset();
                form.action = '{{ route('admin.notification-templates.store') }}';
                document.getElementById('templateFormMethod').value = 'POST';
                document.getElementById('templateFormTitle').textContent = 'Add Template';
                toggleTriggerCronFields();
            });

            // Type変更で Trigger Event / Schedule(cron) の表示を切り替え
            function toggleTriggerCronFields() {
                const type = document.getElementById('templateFormType').value;
                document.getElementById('templateFormTriggerWrap').style.display = (type === 'auto') ? '' :
                    'none';
                document.getElementById('templateFormCronWrap').style.display = (type === 'scheduled') ? '' :
                    'none';
            }
            document.getElementById('templateFormType')?.addEventListener('change', toggleTriggerCronFields);

            // ===================== Create/Edit tab: Use Template =====================
            document.getElementById('createUseTemplate')?.addEventListener('change', function(e) {
                const selectedOption = e.target.options[e.target.selectedIndex];
                if (!selectedOption || !selectedOption.value) return;

                const title = selectedOption.getAttribute('data-title');
                const body = selectedOption.getAttribute('data-body');
                const type = selectedOption.getAttribute('data-type');

                document.getElementById('createTitleInput').value = title || '';
                document.getElementById('createBodyInput').value = body || '';

                const typeSelect = document.getElementById('createTypeSelect');
                if (typeSelect) {
                    // notif_templates.type ('manual','auto','scheduled') -> Create tab の type
                    const typeMap = {
                        manual: 'system',
                        auto: 'auto',
                        scheduled: 'event',
                    };
                    typeSelect.value = typeMap[type] || 'system';
                }

                // どのテンプレートから来たかを記録 (送信時に template_id として使う)
                document.getElementById('tab-create').dataset.sourceTemplateId = selectedOption.value;
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
                    // notif_templates.type ('manual','auto','scheduled') -> Create tab の type
                    const typeMap = {
                        manual: 'system',
                        auto: 'auto',
                        scheduled: 'event',
                    };
                    typeSelect.value = typeMap[tpl.type] || 'system';
                }

                // どのテンプレートから来たかを記録 (送信時に template_id として使う)
                document.getElementById('tab-create').dataset.sourceTemplateId = tpl.id;
            });

        });
    </script>
@endpush
