<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\NotificationTemplate;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class NotificationsController extends Controller
{
    public function index(Request $request)
    {
        $templates = NotificationTemplate::orderByDesc('created_at')->get();

        // どのタブを開いた状態で表示するか (Template作成後のリダイレクト先指定用)
        $activeTab = $request->query('tab', 'list');

        return view('admin.notifications.index', compact('templates', 'activeTab'));
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
            ->route('admin.notifications.index', ['tab' => 'create'])
            ->with('success', $message);
    }
}
