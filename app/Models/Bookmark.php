<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bookmark extends Model
{
    // テーブル名を明示的に指定（他のメンバーがテーブルを作るため）
    protected $table = 'bookmarks';

    // どのカラムを操作可能にするか定義（セキュリティのため）
    protected $fillable = [
        'user_id',
        'bookmarkable_id',
        'bookmarkable_type',
    ];

    // 「誰のブックマークか」を取得するためのリレーション
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // 「ブックマーク対象（病院など）」を動的に取得する（ポリモーフィック）
    public function bookmarkable()
    {
        return $this->morphTo();
    }
}
