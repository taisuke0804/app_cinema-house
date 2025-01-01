<?php

namespace App\Enums;

enum Genre: int
{
    case Action = 1;
    case Comedy = 2;
    case Drama = 3;
    case Horror = 4;
    case Romance = 5;
    case Other = 99;

    /**
     * 映画ジャンルのラベルを取得
     */
    public function getLabel(): string
    {
        return match ($this) {
            self::Action => 'アクション',
            self::Comedy => 'コメディ',
            self::Drama => 'ドラマ',
            self::Horror => 'ホラー',
            self::Romance => 'ロマンス',
            self::Other => 'その他',
        };
    }

    /**
     * 全ての値を配列で取得
     */
    public static function values(): array
    {
        return array_map(fn(self $genre) => $genre->value, self::cases());
    }
}