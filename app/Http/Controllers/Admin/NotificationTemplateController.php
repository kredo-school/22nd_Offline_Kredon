<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NotificationTemplate;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class NotificationTemplateController extends Controller
{
    private function rules(): array
    {
        return [
            'category'      => ['required', Rule::in(['system', 'comment', 'reply', 'like', 'event', 'item_alert', 'digest'])],
            // 'type'          => ['required', Rule::in(['manual', 'auto', 'scheduled'])],
            'title'         => ['required', 'string', 'max:255'],
            'body'          => ['required', 'string'],
            // 'trigger_event' => ['nullable', 'string', 'max:255', 'required_if:type,auto'],
            // 'schedule_cron' => ['nullable', 'string', 'max:255', 'required_if:type,scheduled'],
            'target_type'   => ['required', Rule::in(['all', 'post_author', 'comment_author', 'subscriber', 'custom'])],
            'is_active'     => ['nullable', 'boolean'],
        ];
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());
        $validated['is_active'] = $request->boolean('is_active');
        $validated['created_by'] = Auth::id();

        NotificationTemplate::create($validated);

        return redirect()
            ->route('admin.notifications.index')
            ->with('success', 'Template created successfully.');
    }

    public function update(Request $request, NotificationTemplate $notificationTemplate)
    {
        $validated = $request->validate($this->rules());
        $validated['is_active'] = $request->boolean('is_active');

        $notificationTemplate->update($validated);

        return redirect()
            ->route('admin.notifications.index')
            ->with('success', 'Template updated successfully.');
    }

    public function destroy(NotificationTemplate $notificationTemplate)
    {
        $notificationTemplate->delete();

        return redirect()
            ->route('admin.notifications.index')
            ->with('success', 'Template deleted successfully.');
    }
}