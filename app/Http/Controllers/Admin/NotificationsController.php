<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\NotificationTemplate;
use App\Models\NotificationRead;


use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    public function index(Request $request)
    {
        $notifications = Notification::with(['template', 'recipient'])
            ->orderByDesc('created_at')
            ->get();

        $templates = NotificationTemplate::orderByDesc('created_at')->get();
        $users = \App\Models\User::select('id', 'name', 'email')->orderBy('name')->get();

        $activeTab = $request->query('tab', 'list');

        return view('admin.notifications.index', compact('notifications', 'templates', 'activeTab', 'users'));
        // editingNotification は index() では渡さない(null扱いになる)
    }

    private function rules(): array
    {
        return [
            'template_id'   => ['nullable', 'exists:notif_templates,id'],
            'category'      => ['required', Rule::in(['system', 'comment', 'reply', 'like', 'event', 'item_alert', 'digest'])],
            'title'         => ['required', 'string', 'max:255'],
            'body'          => ['required', 'string'],
            'target_type'   => ['required', Rule::in(['all', 'subscriber', 'custom'])],
            'scheduled_at'  => ['nullable', 'date'],
            'send_push'     => ['nullable', 'boolean'],
            'send_email'    => ['nullable', 'boolean'],
            'link_url'      => ['nullable', 'string', 'max:2048'],
            'user_ids'      => ['nullable', 'array'],
            'user_ids.*'    => ['integer', 'exists:users,id'],
            'custom_user_ids_json' => ['nullable', 'string'], // hidden入力用 (JSON文字列で受け取る場合)
        ];
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        // これでSave Draftか 配信か判別
        $isDraft = $request->input('action') === 'draft';

        $scheduledAt = $validated['scheduled_at'] ?? null;

        if ($isDraft) {
            $status = 'draft';
        } elseif ($scheduledAt && now()->lt($scheduledAt)) {
            $status = 'scheduled';
        } else {
            $status = 'pending'; // 即時配信待ち
        }

        // custom選択時のみ user_ids を data に格納
        $userIds = [];
        if ($validated['target_type'] === 'custom') {
            $userIds = $validated['user_ids'] ?? [];
        }

        Notification::create([
            'template_id'  => $validated['template_id'] ?? null,
            'recipient_id' => null, // all / subscriber / custom はrecipient未確定の配信設定行
            'target_type'  => $validated['target_type'],
            'category'     => $validated['category'],
            'title'        => $validated['title'],
            'body'         => $validated['body'],
            'data'         => [
                'link_url'   => $validated['link_url'] ?? null,
                'send_push'  => $request->boolean('send_push'),
                'send_email' => $request->boolean('send_email'),
                'user_ids'   => $userIds,
            ],
            'scheduled_at' => $scheduledAt,
            'status'       => $status,
        ]);

        $message = $isDraft ? 'Notification saved as draft.' : 'Notification scheduled successfully.';

        return redirect()
            ->route('admin.notifications.index', ['tab' => 'list'])   // ← create から list に変更
            ->with('success', $message);
    }

    public function updateStatus(Request $request, Notification $notification)
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['draft', 'scheduled', 'pending', 'sent', 'failed'])],
        ]);

        $newStatus = $validated['status'];

        $updateData = ['status' => $newStatus];

        // sentに変更したタイミングでsent_atも記録(まだ未送信の場合のみ)
        if ($newStatus === 'sent' && !$notification->sent_at) {
            $updateData['sent_at'] = now();
        }

        $notification->update($updateData);

        // イベント通知がsentになったら、紐づくイベントを公開する
        if ($newStatus === 'sent' && $notification->category === 'event') {
            $eventId = $notification->data['event_id'] ?? null;
            if ($eventId) {
                \App\Models\Event::where('id', $eventId)
                    ->update(['is_published' => true]);
            }
        }

        return response()->json([
            'success' => true,
            'status'  => $notification->status,
        ]);
    }

    public function destroy(Notification $notification)
    {
        $notification->delete(); // SoftDeletesにより論理削除(deleted_atがセットされる)

        return redirect()
            ->route('admin.notifications.index', ['tab' => 'list'])
            ->with('success', 'Notification deleted.');
    }

    public function edit(Notification $notification)
    {
        // 配信済み(sent)の通知は編集不可
        if ($notification->status === 'sent') {
            return redirect()
                ->route('admin.notifications.index', ['tab' => 'list'])
                ->with('error', 'Sent notifications cannot be edited.');
        }

        $notifications = Notification::with(['template', 'recipient'])
            ->orderByDesc('created_at')
            ->get();

        $templates = NotificationTemplate::orderByDesc('created_at')->get();
        $users = \App\Models\User::select('id', 'name', 'email')->orderBy('name')->get();

        return view('admin.notifications.index', [
            'notifications' => $notifications,
            'templates' => $templates,
            'users' => $users,
            'activeTab' => 'create',
            'editingNotification' => $notification, // ← Createタブに渡す編集対象データ
        ]);
    }

    // ListのDetailから編集できる
    public function update(Request $request, Notification $notification)
    {
        if ($notification->status === 'sent') {
            return redirect()
                ->route('admin.notifications.index', ['tab' => 'list'])
                ->with('error', 'Sent notifications cannot be edited.');
        }

        $validated = $request->validate($this->rules());

        $isDraft = $request->input('action') === 'draft';
        $scheduledAt = $validated['scheduled_at'] ?? null;

        if ($isDraft) {
            $status = 'draft';
        } elseif ($scheduledAt && now()->lt($scheduledAt)) {
            $status = 'scheduled';
        } else {
            $status = 'pending';
        }

        $userIds = [];
        if ($validated['target_type'] === 'custom') {
            $userIds = $validated['user_ids'] ?? [];
        }

        $notification->update([
            'template_id'  => $validated['template_id'] ?? null,
            'target_type'  => $validated['target_type'],
            'category'     => $validated['category'],
            'title'        => $validated['title'],
            'body'         => $validated['body'],
            'data'         => [
                'link_url'   => $validated['link_url'] ?? null,
                'send_push'  => $request->boolean('send_push'),
                'send_email' => $request->boolean('send_email'),
                'user_ids'   => $userIds,
            ],
            'scheduled_at' => $scheduledAt,
            'status'       => $status,
        ]);

        $message = $isDraft ? 'Notification saved as draft.' : 'Notification updated successfully.';

        return redirect()
            ->route('admin.notifications.index', ['tab' => 'list'])
            ->with('success', $message);
    }

    // 通知の既読機能
    public function markAllRead(Request $request)
    {
        $userId = Auth::id();

        $sentNotificationIds = Notification::where('status', 'sent')->pluck('id');

        foreach ($sentNotificationIds as $notifId) {
            NotificationRead::firstOrCreate(
                ['notification_id' => $notifId, 'user_id' => $userId],
                ['read_at' => now()]
            );
        }

        return response()->json(['success' => true]);
    }
}
