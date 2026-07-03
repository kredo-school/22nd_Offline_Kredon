<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\StoreBlockRequest;
use App\Http\Requests\Settings\StoreKeywordMuteRequest;
use App\Http\Requests\Settings\StoreUserNgWordRequest;
use App\Http\Requests\Settings\UpdateCommentRequest;
use App\Models\User;
use App\Models\UserBlock;
use App\Models\UserKeywordMute;
use App\Models\UserNgWord;
use App\Services\UserSettingsService;

class CommentController extends Controller
{
    public function __construct(protected UserSettingsService $settingsService) {}

    public function comment()
    {
        $user = auth()->user();

        return view('settings._comment', [
            'user'    => $this->settingsService->accountViewData($user),
            'comment' => $this->settingsService->commentSettings($user),
        ]);
    }

    public function updateComment(UpdateCommentRequest $request)
    {
        $user     = auth()->user();
        $settings = $this->settingsService->ensureSettings($user);
        $input    = $request->validated();

        $settings->update([
            'allow_comments'   => ! empty($input['allow_comments']),
            'pre_approval'     => ! empty($input['pre_approval']),
            'ng_word_filter'   => ! empty($input['ng_word_filter']),
            'ng_word_strength' => $input['ng_word_strength'],
            'spam_detection'   => ! empty($input['spam_detection']),
            'ai_moderation'    => ! empty($input['ai_moderation']),
        ]);

        return back()->with('success', 'コメント・安全設定を保存しました');
    }

    public function storeBlock(StoreBlockRequest $request)
    {
        $blockedUser = User::query()->where('username', $request->validated('username'))->firstOrFail();

        UserBlock::query()->firstOrCreate([
            'user_id'         => auth()->id(),
            'blocked_user_id' => $blockedUser->id,
        ]);

        return back()->with('success', '@' . $blockedUser->username . ' をブロックしました');
    }

    public function destroyBlock(UserBlock $block)
    {
        abort_unless($block->user_id === auth()->id(), 403);

        $block->delete();

        return back()->with('success', 'ブロックを解除しました');
    }

    public function storeKeywordMute(StoreKeywordMuteRequest $request)
    {
        UserKeywordMute::query()->create([
            'user_id' => auth()->id(),
            'keyword' => $request->validated('keyword'),
        ]);

        return back()->with('success', 'キーワードをミュートしました');
    }

    public function destroyKeywordMute(UserKeywordMute $keywordMute)
    {
        abort_unless($keywordMute->user_id === auth()->id(), 403);

        $keywordMute->delete();

        return back()->with('success', 'キーワードミュートを解除しました');
    }

    public function storeNgWord(StoreUserNgWordRequest $request)
    {
        UserNgWord::query()->create([
            'user_id' => auth()->id(),
            'word'    => $request->validated('word'),
        ]);

        return back()->with('success', 'カスタムNGワードを追加しました');
    }

    public function destroyNgWord(UserNgWord $ngWord)
    {
        abort_unless($ngWord->user_id === auth()->id(), 403);

        $ngWord->delete();

        return back()->with('success', 'カスタムNGワードを削除しました');
    }
}
