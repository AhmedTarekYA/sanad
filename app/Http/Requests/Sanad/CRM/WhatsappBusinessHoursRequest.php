<?php

namespace App\Http\Requests\Sanad\CRM;

use App\Http\Requests\MainRequest;
use Illuminate\Validation\Validator;

class WhatsappBusinessHoursRequest extends MainRequest
{
    /** @var array<int, string> */
    protected array $days = ['sat', 'sun', 'mon', 'tue', 'wed', 'thu', 'fri'];

    protected function prepareForValidation(): void
    {
        $hours = $this->input('hours');

        if (is_string($hours)) {
            $decoded = json_decode($hours, true);

            if (is_array($decoded)) {
                $this->merge(['hours' => $decoded]);
            }
        }
    }

    /** @return array<string, array<int, mixed>|string> */
    public function rules(): array
    {
        $rules = [
            'timezone' => ['nullable', 'string', 'max:60'],
            'business_hours_enabled' => ['nullable', 'boolean'],
            'away_message_enabled' => ['nullable', 'boolean'],
            'away_message' => ['nullable', 'string', 'max:5000'],
            'hours' => ['nullable', 'array'],
        ];

        foreach ($this->days as $day) {
            $rules["hours.{$day}"] = ['nullable', 'array'];
            $rules["hours.{$day}.enabled"] = ['nullable', 'boolean'];
            $rules["hours.{$day}.from"] = ['nullable', 'date_format:H:i'];
            $rules["hours.{$day}.to"] = ['nullable', 'date_format:H:i'];
        }

        return $rules;
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            $hours = $this->input('hours');

            if (! is_array($hours)) {
                return;
            }

            foreach ($this->days as $day) {
                $row = $hours[$day] ?? null;

                if (! is_array($row) || ! (bool) ($row['enabled'] ?? false)) {
                    continue;
                }

                $from = trim((string) ($row['from'] ?? ''));
                $to = trim((string) ($row['to'] ?? ''));
                $label = __("whatsapp_day_{$this->dayName($day)}");

                if ($from === '' || $to === '') {
                    $validator->errors()->add("hours.{$day}.from", __('whatsapp_hours_invalid_time', ['day' => $label]));

                    continue;
                }

                if ($from >= $to) {
                    $validator->errors()->add("hours.{$day}.to", __('whatsapp_hours_invalid_range', ['day' => $label]));
                }
            }
        });
    }

    protected function dayName(string $day): string
    {
        return match ($day) {
            'sat' => 'saturday',
            'sun' => 'sunday',
            'mon' => 'monday',
            'tue' => 'tuesday',
            'wed' => 'wednesday',
            'thu' => 'thursday',
            'fri' => 'friday',
            default => $day,
        };
    }
}
