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
            <a href="#" class="btn btn-dark px-4">
                <i class="fa-solid fa-plus me-1"></i> Add New User
            </a>
        </div>

        {{-- ── Metric Cards ── --}}
        <div class="row g-3 mb-4">
            <div class="col-12 col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <p class="text-muted mb-1" style="font-size:0.8rem;">Total Users</p>
                        <h3 class="fw-bold mb-0">45,210</h3>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <p class="text-muted mb-1" style="font-size:0.8rem;">New Users (Last 7 Days)</p>
                        <h3 class="fw-bold mb-0">
                            235 <span class="text-success" style="font-size:1rem;">↑</span>
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <p class="text-muted mb-1" style="font-size:0.8rem;">Banned / Deactivated Users</p>
                        <h3 class="fw-bold mb-0">78</h3>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Table Card ── --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body p-3">

                {{-- ── Filters ── --}}
                <div class="d-flex flex-wrap gap-2 justify-content-end mb-3">
                    <select class="form-select form-select-sm" style="width:auto;">
                        <option>Status</option>
                        <option>Active</option>
                        <option>Inactive</option>
                        <option>Banned</option>
                    </select>
                    <select class="form-select form-select-sm" style="width:auto;">
                        <option>Role</option>
                        <option>Member</option>
                        <option>Moderator</option>
                        <option>Admin</option>
                    </select>
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
                            {{-- ダミーデータ（実際はforeachに差し替え） --}}
                            @php
                                $users = [
                                    [
                                        'name' => 'User @MikeB',
                                        'id' => '1203001',
                                        'email' => 'user.@Mike7@gmail.com',
                                        'role' => 'Member',
                                        'joined' => '2023-05-23 17:43 PM',
                                        'status' => 'Active',
                                        'login' => 14,
                                    ],
                                    [
                                        'name' => 'User @MikeB',
                                        'id' => '1203002',
                                        'email' => 'usermaskre7@gmail.com',
                                        'role' => 'Moderator',
                                        'joined' => '2023-05-23 11:43 PM',
                                        'status' => 'Inactive',
                                        'login' => 5,
                                    ],
                                    [
                                        'name' => 'User @MikeB',
                                        'id' => '1203003',
                                        'email' => 'adminirator@gmail.com',
                                        'role' => 'Admin',
                                        'joined' => '2023-05-23 13:33 PM',
                                        'status' => 'Banned',
                                        'login' => 1,
                                    ],
                                    [
                                        'name' => 'User @User',
                                        'id' => '1203006',
                                        'email' => 'usermank1@gmail.com',
                                        'role' => 'Member',
                                        'joined' => '2023-07-23 10:33 PM',
                                        'status' => 'Banned',
                                        'login' => 7,
                                    ],
                                    [
                                        'name' => 'User @MikeB',
                                        'id' => '1203107',
                                        'email' => 'usermarle1@gmail.com',
                                        'role' => 'Member',
                                        'joined' => '2023-07-28 11:38 PM',
                                        'status' => 'Active',
                                        'login' => 1,
                                    ],
                                    [
                                        'name' => 'User @User',
                                        'id' => '1203008',
                                        'email' => 'usermoke1@gmail.com',
                                        'role' => 'Member',
                                        'joined' => '2023-07-28 12:34 PM',
                                        'status' => 'Suspend',
                                        'login' => 1,
                                    ],
                                    [
                                        'name' => 'User @User',
                                        'id' => '1203009',
                                        'email' => 'user.sarahk1@gmail.com',
                                        'role' => 'Moderator',
                                        'joined' => '2023-07-25 14:20 PM',
                                        'status' => 'Inactive',
                                        'login' => 0,
                                    ],
                                    [
                                        'name' => 'User @MikeB',
                                        'id' => '1203001',
                                        'email' => 'user.markj@gmail.com',
                                        'role' => 'Admin',
                                        'joined' => '2023-07-24 12:20 PM',
                                        'status' => 'Banned',
                                        'login' => 1,
                                    ],
                                ];
                            @endphp

                            @foreach ($users as $user)
                                <tr>
                                    {{-- <td><input type="checkbox" class="target-checkbox"></td> --}}
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <span
                                                style="display:inline-flex;align-items:center;justify-content:center;
                                                        width:34px;height:34px;border-radius:50%;background:#dee2e6;
                                                        font-size:0.75rem;font-weight:bold;color:#495057;">
                                                {{ strtoupper(substr($user['name'], 0, 1)) }}
                                            </span>
                                            <span class="fw-medium">{{ $user['name'] }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div>{{ $user['id'] }}</div>
                                        <div class="text-muted" style="font-size:0.75rem;">{{ $user['email'] }}</div>
                                    </td>

                                    {{-- ── 左側のRole列（id を付与してJSから連動可能に） ── --}}
                                    <td>
                                        @php
                                            $roleColor = match ($user['role']) {
                                                'Admin' => 'danger',
                                                'Moderator' => 'success',
                                                default => 'primary',
                                            };
                                        @endphp
                                        <span id="roleBadge_{{ $user['id'] }}"
                                            class="badge bg-{{ $roleColor }}">{{ $user['role'] }}</span>
                                    </td>

                                    <td class="text-nowrap">{{ $user['joined'] }}</td>

                                    {{-- ── 左側のStatus列 ── --}}
                                    <td>
                                        @php
                                            $statusColor = match ($user['status']) {
                                                'Active' => 'success',
                                                'Inactive' => 'secondary',
                                                'Suspend' => 'warning',
                                                'Banned' => 'danger',
                                                default => 'secondary',
                                            };
                                        @endphp
                                        <span id="statusBadge_{{ $user['id'] }}"
                                            class="badge bg-{{ $statusColor }}">{{ $user['status'] }}</span>
                                    </td>

                                    <td>
                                        <div style="font-size:0.78rem;">Recent Post</div>
                                        <div class="text-muted" style="font-size:0.75rem;">Login Count:
                                            {{ $user['login'] }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1 flex-wrap">
                                            <button class="btn btn-outline-secondary btn-sm py-0 px-2">Edit</button>

                                            {{-- ── 右側のRoleドロップダウン ── --}}
                                            <div class="btn-group">
                                                <button id="currentRoleBtn_{{ $user['id'] }}" type="button"
                                                    class="btn 
                                                                @if ($user['role'] == 'Admin') btn-outline-danger 
                                                                @elseif($user['role'] == 'Moderator') btn-outline-success 
                                                                @else btn-outline-primary @endif btn-sm py-0 px-2 dropdown-toggle"
                                                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    {{ $user['role'] }}
                                                </button>

                                                <ul class="dropdown-menu" id="roleDropdownMenu_{{ $user['id'] }}">
                                                </ul>
                                            </div>

                                            {{-- JavaScriptの連動処理 Role用 --}}
                                            <script>
                                                (() => {
                                                    const userId = "{{ $user['id'] }}";
                                                    const initialRole = "{{ $user['role'] }}";

                                                    const roleConfig = {
                                                        'Admin': {
                                                            color: 'btn-outline-danger'
                                                        },
                                                        'Moderator': {
                                                            color: 'btn-outline-success'
                                                        },
                                                        'Member': {
                                                            color: 'btn-outline-primary'
                                                        }
                                                    };

                                                    const badgeConfig = {
                                                        'Admin': {
                                                            color: 'bg-danger'
                                                        },
                                                        'Moderator': {
                                                            color: 'bg-success'
                                                        },
                                                        'Member': {
                                                            color: 'bg-primary'
                                                        }
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

                                                                li.querySelector('button').addEventListener('click', function() {
                                                                    changeRole(role);
                                                                });

                                                                dropdownMenu.appendChild(li);
                                                            }
                                                        });
                                                    }

                                                    function changeRole(newRole) {
                                                        const oldRole = currentBtn.textContent.trim();

                                                        currentBtn.classList.remove(roleConfig[oldRole].color);
                                                        currentBtn.classList.add(roleConfig[newRole].color);
                                                        currentBtn.textContent = newRole;

                                                        if (roleBadge) {
                                                            roleBadge.classList.remove(badgeConfig[oldRole].color);
                                                            roleBadge.classList.add(badgeConfig[newRole].color);
                                                            roleBadge.textContent = newRole;
                                                        }

                                                        updateDropdownMenu(newRole);
                                                        console.log(`User ID ${userId} のロールを ${newRole} に更新しました。`);
                                                    }

                                                    updateDropdownMenu(initialRole);
                                                })
                                                ();
                                            </script>

                                            {{-- ── 右側のStatusドロップダウン ── --}}
                                            <div class="btn-group">
                                                <button id="currentStatusBtn_{{ $user['id'] }}" type="button"
                                                    class="btn 
                                                                @if ($user['status'] == 'Active') btn-outline-success 
                                                                @elseif($user['status'] == 'Inactive') btn-outline-secondary 
                                                                @elseif($user['status'] == 'Banned') btn-outline-danger 
                                                                @else btn-outline-warning @endif btn-sm py-0 px-2 dropdown-toggle"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    {{ $user['status'] }}
                                                </button>

                                                <ul class="dropdown-menu" id="statusDropdownMenu_{{ $user['id'] }}">
                                                </ul>
                                            </div>

                                            {{-- JavaScriptの連動処理 Status用 --}}
                                            <script>
                                                (() => {
                                                    const userId = "{{ $user['id'] }}";
                                                    const initialStatus = "{{ $user['status'] }}";

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
                                                        'Suspend': {
                                                            color: 'btn-outline-warning'
                                                        }
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
                                                        'Suspend': {
                                                            color: 'bg-warning'
                                                        }
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

                                                                li.querySelector('button').addEventListener('click', function() {
                                                                    changeStatus(status);
                                                                });

                                                                dropdownMenu.appendChild(li);
                                                            }
                                                        });
                                                    }

                                                    function changeStatus(newStatus) {
                                                        const oldStatus = currentBtn.textContent.trim();

                                                        currentBtn.classList.remove(statusConfig[oldStatus].color);
                                                        currentBtn.classList.add(statusConfig[newStatus].color);
                                                        currentBtn.textContent = newStatus;

                                                        if (statusBadge) {
                                                            statusBadge.classList.remove(badgeConfig[oldStatus].color);
                                                            statusBadge.classList.add(badgeConfig[newStatus].color);
                                                            statusBadge.textContent = newStatus;
                                                        }

                                                        updateDropdownMenu(newStatus);
                                                        console.log(`User ID ${userId} のステータスを ${newStatus} に更新しました。`);
                                                    }

                                                    updateDropdownMenu(initialStatus);
                                                })();
                                            </script>

                                            <button class="btn btn-outline-secondary btn-sm py-0 px-2">View</button>
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
                    <nav>
                        <ul class="pagination pagination-sm mb-0">
                            <li class="page-item disabled"><a class="page-link">‹</a></li>
                            <li class="page-item active"><a class="page-link">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item disabled"><a class="page-link">...</a></li>
                            <li class="page-item"><a class="page-link" href="#">10</a></li>
                            <li class="page-item"><a class="page-link" href="#">›</a></li>
                        </ul>
                    </nav>
                </div>

            </div>
        </div>
    </div>
@endsection
