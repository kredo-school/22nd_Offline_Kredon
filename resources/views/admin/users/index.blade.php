@extends('layouts.admin')

@section('title', 'User Management')

@section('content')
    <div class="p-4" style="overflow-y: auto; height: 100%;">

        {{-- ── Header ── --}}
        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <h4 class="fw-bold mb-1">User Management</h4>
                <p class="text-muted mb-0" style="font-size:0.85rem;">Control and manage all registered users</p>
            </div>
        </div>

        {{-- ── Metric Cards ── --}}
        <div class="row g-3 mb-4">
            <div class="col-12 col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <p class="text-muted mb-1" style="font-size:0.8rem;">Total Users</p>
                        <h3 class="fw-bold mb-0">{{ number_format($totalUsers) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <p class="text-muted mb-1" style="font-size:0.8rem;">New Users (Last 7 Days)</p>
                        <h3 class="fw-bold mb-0">
                            {{ $newUsers7d }} <span class="text-success" style="font-size:1rem;">↑</span>
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <p class="text-muted mb-1" style="font-size:0.8rem;">Banned / Deactivated Users</p>
                        <h3 class="fw-bold mb-0">{{ $bannedOrDeactivated }}</h3>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Table Card ── --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body p-3">

                {{-- ── Filters ── --}}
                <div class="d-flex flex-wrap gap-2 justify-content-end mb-3">
                    <form method="GET" action="{{ route('admin.users.index') }}"
                        class="d-flex flex-wrap gap-2 justify-content-end mb-3">
                        <select name="status" class="form-select form-select-sm" style="width:auto;"
                            onchange="this.form.submit()">
                            <option value="">Status</option>
                            <option value="Active" @selected(request('status') === 'Active')>Active</option>
                            <option value="Inactive" @selected(request('status') === 'Inactive')>Inactive</option>
                            <option value="Banned" @selected(request('status') === 'Banned')>Banned</option>
                        </select>
                        <select name="role" class="form-select form-select-sm" style="width:auto;"
                            onchange="this.form.submit()">
                            <option value="">Role</option>
                            <option value="Member" @selected(request('role') === 'Member')>Member</option>
                            <option value="Premium-Member" @selected(request('role') === 'Premium-Member')>Premium-Member</option>
                            <option value="Admin" @selected(request('role') === 'Admin')>Admin</option>
                        </select>
                    </form>

                    <div class="input-group input-group-sm" style="width:auto;">
                        <span class="input-group-text bg-white border-end-0">Date Range</span>
                        <input type="text" class="form-control border-start-0" placeholder="Last 70 Days"
                            style="width:120px;">
                        <span class="input-group-text bg-white">
                            <i class="fa-regular fa-calendar"></i>
                        </span>
                    </div>
                </div>

                {{-- ── Table ── --}}
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="font-size:0.85rem;">
                        <thead class="table-light">
                            <tr>
                                {{-- <th><input type="checkbox" id="check-all"></th> --}}
                                <th>Avatar / Name</th>
                                <th>User ID / Account</th>
                                <th>Role</th>
                                <th>Join Date</th>
                                <th>Status</th>
                                <th>Activity</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($all_users as $user)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <span
                                                style="display:inline-flex;align-items:center;justify-content:center;
                            width:34px;height:34px;border-radius:50%;background:#dee2e6;
                            font-size:0.75rem;font-weight:bold;color:#495057;">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </span>
                                            <span class="fw-medium">{{ $user->name }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div>{{ $user->id }}</div>
                                        <div class="text-muted" style="font-size:0.75rem;">{{ $user->email }}</div>
                                    </td>

                                    <td>
                                        @php
                                            $roleColor = match ($user->role_name) {
                                                'Admin' => 'danger',
                                                'Premium-Member' => 'info',
                                                default => 'primary', // Member
                                            };
                                        @endphp
                                        <span id="roleBadge_{{ $user->id }}"
                                            class="badge bg-{{ $roleColor }}">{{ $user->role_name }}</span>
                                    </td>

                                    <td class="text-nowrap">{{ $user->created_at?->format('Y-m-d h:i A') }}</td>

                                    <td>
                                        @php
                                            $statusColor = match ($user->status) {
                                                'Active' => 'success',
                                                'Inactive' => 'secondary',
                                                'Banned' => 'danger',
                                                default => 'secondary',
                                            };
                                        @endphp
                                        <span id="statusBadge_{{ $user->id }}"
                                            class="badge bg-{{ $statusColor }}">{{ $user->status }}</span>
                                    </td>

                                    <td>
                                        <div style="font-size:0.78rem;">
                                            @if ($user->last_login_at)
                                                Last login: {{ $user->last_login_at->diffForHumans() }}
                                            @else
                                                No login yet
                                            @endif
                                        </div>
                                        <div class="text-muted" style="font-size:0.75rem;">
                                            Login Count: {{ $user->login_count }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1 flex-wrap">

                                            {{-- ── Roleドロップダウン ── --}}
                                            <div class="btn-group">
                                                <button id="currentRoleBtn_{{ $user->id }}" type="button"
                                                    class="btn
                                                        @if ($user->role_name == 'Admin') btn-outline-danger
                                                        @elseif($user->role_name == 'Premium-Member') btn-outline-info
                                                        @else btn-outline-primary @endif btn-sm py-0 px-2 dropdown-toggle"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    {{ $user->role_name }}
                                                </button>
                                                <ul class="dropdown-menu" id="roleDropdownMenu_{{ $user->id }}"></ul>
                                            </div>

                                            <script>
                                                (() => {
                                                    const userId = "{{ $user->id }}";
                                                    const initialRole = "{{ $user->role_name }}";

                                                    const roleConfig = {
                                                        'Admin': {
                                                            color: 'btn-outline-danger',
                                                            value: 1
                                                        },
                                                        'Member': {
                                                            color: 'btn-outline-primary',
                                                            value: 2
                                                        },
                                                        'Premium-Member': {
                                                            color: 'btn-outline-info',
                                                            value: 3
                                                        },
                                                    };
                                                    const badgeConfig = {
                                                        'Admin': {
                                                            color: 'bg-danger'
                                                        },
                                                        'Member': {
                                                            color: 'bg-primary'
                                                        },
                                                        'Premium-Member': {
                                                            color: 'bg-info'
                                                        },
                                                    };

                                                    const currentBtn = document.getElementById(`currentRoleBtn_${userId}`);
                                                    const dropdownMenu = document.getElementById(`roleDropdownMenu_${userId}`);
                                                    const roleBadge = document.getElementById(`roleBadge_${userId}`);

                                                    function updateDropdownMenu(currentRole) {
                                                        dropdownMenu.innerHTML = '';
                                                        Object.keys(roleConfig).forEach(role => {
                                                            if (role !== currentRole) {
                                                                const li = document.createElement('li');
                                                                li.innerHTML = `<button class="dropdown-item" type="button">${role}</button>`;
                                                                li.querySelector('button').addEventListener('click', () => changeRole(role));
                                                                dropdownMenu.appendChild(li);
                                                            }
                                                        });
                                                    }

                                                    function changeRole(newRole) {
                                                        const oldRole = currentBtn.textContent.trim();

                                                        fetch(`/admin/users/${userId}/role`, {
                                                                method: 'PATCH',
                                                                headers: {
                                                                    'Content-Type': 'application/json',
                                                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                                                },
                                                                body: JSON.stringify({
                                                                    role: roleConfig[newRole].value
                                                                }),
                                                            })
                                                            .then(res => res.json())
                                                            .then(data => {
                                                                if (!data.success) return;

                                                                currentBtn.classList.remove(roleConfig[oldRole].color);
                                                                currentBtn.classList.add(roleConfig[newRole].color);
                                                                currentBtn.textContent = newRole;

                                                                if (roleBadge) {
                                                                    roleBadge.classList.remove(badgeConfig[oldRole].color);
                                                                    roleBadge.classList.add(badgeConfig[newRole].color);
                                                                    roleBadge.textContent = newRole;
                                                                }
                                                                updateDropdownMenu(newRole);
                                                            })
                                                            .catch(err => console.error('ロール更新に失敗しました', err));
                                                    }

                                                    updateDropdownMenu(initialRole);
                                                })
                                                ();
                                            </script>

                                            {{-- ── Statusドロップダウン ── --}}
                                            <div class="btn-group">
                                                <button id="currentStatusBtn_{{ $user->id }}" type="button"
                                                    class="btn
                                                                    @if ($user->status == 'Active') btn-outline-success
                                                                    @elseif($user->status == 'Inactive') btn-outline-secondary
                                                                    @else btn-outline-danger @endif btn-sm py-0 px-2 dropdown-toggle"
                                                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                    {{ $user->status }}
                                                </button>
                                                <ul class="dropdown-menu" id="statusDropdownMenu_{{ $user->id }}"></ul>
                                            </div>

                                            <script>
                                                (() => {
                                                    const userId = "{{ $user->id }}";
                                                    const initialStatus = "{{ $user->status }}";

                                                    const statusConfig = {
                                                        'Active': {
                                                            color: 'btn-outline-success'
                                                        },
                                                        'Inactive': {
                                                            color: 'btn-outline-secondary'
                                                        },
                                                        'Banned': {
                                                            color: 'btn-outline-danger'
                                                        },
                                                    };
                                                    const badgeConfig = {
                                                        'Active': {
                                                            color: 'bg-success'
                                                        },
                                                        'Inactive': {
                                                            color: 'bg-secondary'
                                                        },
                                                        'Banned': {
                                                            color: 'bg-danger'
                                                        },
                                                    };

                                                    const currentBtn = document.getElementById(`currentStatusBtn_${userId}`);
                                                    const dropdownMenu = document.getElementById(`statusDropdownMenu_${userId}`);
                                                    const statusBadge = document.getElementById(`statusBadge_${userId}`);

                                                    function updateDropdownMenu(currentStatus) {
                                                        dropdownMenu.innerHTML = '';
                                                        Object.keys(statusConfig).forEach(status => {
                                                            if (status !== currentStatus) {
                                                                const li = document.createElement('li');
                                                                li.innerHTML = `<button class="dropdown-item" type="button">${status}</button>`;
                                                                li.querySelector('button').addEventListener('click', () => changeStatus(status));
                                                                dropdownMenu.appendChild(li);
                                                            }
                                                        });
                                                    }

                                                    function changeStatus(newStatus) {
                                                        const oldStatus = currentBtn.textContent.trim();

                                                        fetch(`/admin/users/${userId}/status`, {
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

                                                                currentBtn.classList.remove(statusConfig[oldStatus].color);
                                                                currentBtn.classList.add(statusConfig[newStatus].color);
                                                                currentBtn.textContent = newStatus;

                                                                if (statusBadge) {
                                                                    statusBadge.classList.remove(badgeConfig[oldStatus].color);
                                                                    statusBadge.classList.add(badgeConfig[newStatus].color);
                                                                    statusBadge.textContent = newStatus;
                                                                }
                                                                updateDropdownMenu(newStatus);
                                                            })
                                                            .catch(err => console.error('ステータス更新に失敗しました', err));
                                                    }

                                                    updateDropdownMenu(initialStatus);
                                                })();
                                            </script>

                                            <button class="btn btn-outline-secondary btn-sm py-0 px-2">Detail</button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                    {{-- JS --}}
                    {{-- <script>
                        // 親のチェックボックスを取得
                        const checkAll = document.getElementById('check-all');
                        // 子のチェックボックス一覧を取得
                        const targetCheckboxes = document.querySelectorAll('.target-checkbox');

                        // 親がクリックされたときのイベント
                        checkAll.addEventListener('change', function() {
                            targetCheckboxes.forEach(checkbox => {
                                // 親のチェック状態（true/false）を、子すべてに代入
                                checkbox.checked = this.checked;
                            });
                        });
                    </script> --}}

                </div>

                {{-- ── Pagination ── --}}
                <div class="d-flex justify-content-end mt-3">
                    {{ $all_users->links('pagination::bootstrap-5') }}
                </div>

            </div>
        </div>
    </div>
@endsection
