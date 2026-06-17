@extends('layouts.admin')

@section('title', 'Notification')

@section('content')
    <div class="p-4" style="overflow-y: auto; height: 100%;">
        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <h4 class="fw-bold mb-1">Notification Management</h4>
                <p class="text-muted mb-0" style="font-size:0.85rem;">Manage system, event, and auto-generated notifications
                </p>
            </div>
            {{-- <button type="button" class="btn btn-primary" data-bs-toggle="tab" data-bs-target="#tab-create"
                onclick="document.querySelector('[data-bs-target=&quot;#tab-create&quot;]').click()">
                <i class="fa-solid fa-plus me-1"></i> New Notification
            </button> --}}
        </div>

        {{-- Metric cards --}}
        <div class="row g-3 mb-4">
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card h-100 border-0 shadow-sm p-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <small class="text-muted d-block mb-1" style="font-size: 0.75rem;">Total Notifications</style>
                            </small>
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
                <button class="nav-link active" id="tab-list-btn" data-bs-toggle="tab" data-bs-target="#tab-list"
                    type="button" role="tab">
                    <i class="fa-solid fa-list me-1"></i> Notification List
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab-create-btn" data-bs-toggle="tab" data-bs-target="#tab-create"
                    type="button" role="tab">
                    <i class="fa-solid fa-plus me-1"></i> Create / Edit
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab-calendar-btn" data-bs-toggle="tab" data-bs-target="#tab-calendar"
                    type="button" role="tab">
                    <i class="fa-solid fa-calendar-days me-1"></i> Calendar
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab-templates-btn" data-bs-toggle="tab" data-bs-target="#tab-templates"
                    type="button" role="tab">
                    <i class="fa-solid fa-file-lines me-1"></i> Templates
                </button>
            </li>
        </ul>

        <div class="tab-content" id="notificationTabsContent">

            {{-- ============ TAB 1: LIST ============ --}}
            <div class="tab-pane fade show active" id="tab-list" role="tabpanel">
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
                                                            class="fa-solid fa-calendar-day me-1 text-secondary"></i> Event
                                                        Alert</span>
                                                </td>
                                                <td>
                                                    <div class="fw-semibold">[Reminder] 『Kredon Beach Clean』申込締切あと1日</div>
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
                                                    <div class="text-dark"><strong>User@MikeB</strong> commented on UserA's
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
            <div class="tab-pane fade" id="tab-create" role="tabpanel">
                <div class="row g-3">
                    <div class="col-12 col-lg-7">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body p-4">
                                <p class="text-muted text-uppercase mb-3"
                                    style="font-size:0.7rem; letter-spacing:0.05em;">Basic Information</p>

                                <div class="mb-3">
                                    <label class="form-label" style="font-size:0.8rem;">Notification Title</label>
                                    <input type="text" class="form-control"
                                        placeholder="e.g. Summer Festival 2026 announcement">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" style="font-size:0.8rem;">Type</label>
                                    <select class="form-select">
                                        <option>System Notification</option>
                                        <option>Event Notification</option>
                                        <option>Auto-Notify (Comment / Review)</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" style="font-size:0.8rem;">Body</label>
                                    <textarea class="form-control" rows="4"
                                        placeholder="Enter the notification body. Variables like you can be used."></textarea>
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
                                    <label class="form-label" style="font-size:0.8rem;">Target Audience</label>
                                    <select class="form-select">
                                        <option>All Users</option>
                                        <option>Specific Segment</option>
                                        <option>On Event Trigger (Auto)</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" style="font-size:0.8rem;">Delivery Date/Time</label>
                                    <input type="datetime-local" class="form-control">
                                </div>

                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" role="switch" id="pushToggle"
                                        checked>
                                    <label class="form-check-label" for="pushToggle" style="font-size:0.85rem;">Send push
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
            <div class="tab-pane fade" id="tab-calendar" role="tabpanel">
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
                                        <div class="notif-cal-event notif-ev-{{ $event['type'] }}">{{ $event['label'] }}
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>

                        <div class="d-flex gap-3">
                            <div class="d-flex align-items-center gap-2" style="font-size:0.8rem;">
                                <span class="notif-cal-dot"
                                    style="background-color:#E6F1FB; border:1px solid #B5D4F4;"></span> System Notification
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
            <div class="tab-pane fade" id="tab-templates" role="tabpanel">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <p class="text-muted text-uppercase mb-0" style="font-size:0.7rem; letter-spacing:0.05em;">Auto-Notify
                        Template Management</p>
                    <button type="button" class="btn btn-sm btn-primary"><i class="fa-solid fa-plus me-1"></i> Add
                        Template</button>
                </div>

                @php
                    $dummyTemplates = [
                        [
                            'type' => 'auto',
                            'icon' => 'fa-comment',
                            'title' => 'Comment Notification',
                            'preview' => 'said: "{{ commenter_name }} commented on your post {{ post_title }}."',
                            'meta' => 'Trigger: comment created / Target: post author',
                            'enabled' => true,
                        ],
                        [
                            'type' => 'auto',
                            'icon' => 'fa-star',
                            'title' => 'Review Notification',
                            'preview' =>
                                'said: "{{ reviewer_name }} left a {{ rating }}-star review on {{ post_title }}."',
                            'meta' => 'Trigger: review created / Target: post author',
                            'enabled' => true,
                        ],
                        [
                            'type' => 'system',
                            'icon' => 'fa-gear',
                            'title' => 'Maintenance Notification',
                            'preview' =>
                                'said: "Maintenance will occur on {{ date }} {{ time }}, duration approx. {{ duration }}."',
                            'meta' => 'Trigger: manual / Target: all users',
                            'enabled' => true,
                        ],
                    ];
                @endphp

                @foreach ($dummyTemplates as $tpl)
                    <div class="card border-0 shadow-sm mb-3">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="d-flex align-items-center gap-2">
                                    @if ($tpl['type'] === 'auto')
                                        <span class="badge rounded-pill"
                                            style="background-color:#EEEDFE; color:#3C3489; font-weight:500;">
                                            <i class="fa-solid {{ $tpl['icon'] }} me-1"></i> Auto-Notify
                                        </span>
                                    @else
                                        <span class="badge rounded-pill"
                                            style="background-color:#E6F1FB; color:#0C447C; font-weight:500;">
                                            <i class="fa-solid {{ $tpl['icon'] }} me-1"></i> System
                                        </span>
                                    @endif
                                    <span class="fw-semibold" style="font-size:0.9rem;">{{ $tpl['title'] }}</span>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>
                                    <div class="form-check form-switch mb-0">
                                        <input class="form-check-input" type="checkbox" role="switch"
                                            {{ $tpl['enabled'] ? 'checked' : '' }}>
                                    </div>
                                </div>
                            </div>
                            <p class="text-muted mb-2" style="font-size:0.8rem;">{{ $tpl['preview'] }}</p>
                            <p class="text-muted mb-0" style="font-size:0.7rem;">{{ $tpl['meta'] }}</p>
                        </div>
                    </div>
                @endforeach

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
    </style>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Calendar month navigation (placeholder logic — wire up to controller-driven dates later)
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
    </script>
@endsection
