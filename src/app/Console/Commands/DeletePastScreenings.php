<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Screening;
use Carbon\Carbon;

class DeletePastScreenings extends Command
{
    /**
     * コンソールコマンドの名前と使い方
     *
     * @var string
     */
    protected $signature = 'screenings:delete-past';

    /**
     * コンソールコマンドの説明
     *
     * @var string
     */
    protected $description = '過去の上映スケジュールを削除する';

    /**
     * consoleコマンドの実行
     */
    public function handle()
    {
        $oneWeekAgo = Carbon::now()->subWeek();
        $count = Screening::where('end_time', '<', $oneWeekAgo)->delete();

        // コンソールに出力
        $this->info("{$count} 件の上映スケジュール（1週間以上前）を削除しました。");

        return Command::SUCCESS; // 終了ステータスコードを返す
    }
}
