<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use Carbon\Carbon;
use App\Models\Screening;

class StoreScreeningRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'movie_id' => ['required', 'integer', 'exists:movies,id'],
            'date' => ['required', 'date', 'after_or_equal:tomorrow'],
            'start_hour' => ['required', 'integer', 'between:9,21'],
            'start_minute' => ['required', 'integer', 'between:0,59'],
            'end_hour' => ['required', 'integer', 'between:10,22'],
            'end_minute' => ['required', 'integer', 'between:0,59'],
        ];
    }

    public function attributes(): array
    {
        return [
            'date' => '上映日',
            'start_hour' => '上映開始・時',
            'start_minute' => '上映開始・分',
            'end_hour' => '上映終了・時',
            'end_minute' => '上映終了・分',
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {

            // バリデーションエラーがある場合は処理を中断
            if ($validator->stopOnFirstFailure()->failed()) {
                return;
            }
            $startDateTime = $this->getStartDateTime();
            $endDateTime = $this->getEndDateTime();

            // 上映終了時刻が上映開始時刻よりも後になっているかチェック
            if ($startDateTime->gte($endDateTime)) {
                $validator->errors()->add('end_hour', '上映終了時刻は上映開始時刻よりも後にしてください。');
                return;
            }

            // 選択した日付と映画IDに紐づく上映スケジュールが存在するかチェック
            if ($this->sameDayAndMovieExists()) {
                $validator->errors()->add('date', '選択した日付には同じ映画の上映スケジュールが既に存在します。');
                return;
            }

            // 上映スケジュールが重複していないかチェック
            if ($this->isOverlapping($startDateTime, $endDateTime)) {
                $validator->errors()->add('date', '上映時間が他の作品と重複しています。');
                return;
            }

            $this->merge([
                'start_time' => $startDateTime,
                'end_time' => $endDateTime,
            ]);

        });
    }

    private function getStartDateTime(): Carbon
    {
        return Carbon::createFromFormat(
            'Y-m-d H:i',
            $this->date . ' ' . sprintf('%02d:%02d', $this->start_hour, $this->start_minute)
        );
    }

    private function getEndDateTime(): Carbon
    {
        return Carbon::createFromFormat(
            'Y-m-d H:i',
            $this->date . ' ' . sprintf('%02d:%02d', $this->end_hour, $this->end_minute)
        );
    }

    /**
     * 選択した日付と映画IDに紐づく上映スケジュールが存在するかチェック
     */
    private function sameDayAndMovieExists(): bool
    {
        return Screening::whereDate('start_time', $this->date)
        ->where('movie_id', $this->movie_id)
        ->exists();
    }

    private function isOverlapping(Carbon $start, Carbon $end): bool
    {
        return Screening::where('start_time', '<', $end)
            ->where('end_time', '>', $start)
            ->exists();
    }
}
