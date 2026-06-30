<?php

namespace App\Traits; // دقت کن که این خط حتماً همین باشه


use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

trait Sms
{
    public function sendSmsCode($mobile, $pattern, $otpCode)
    {
        $url = "https://edge.ippanel.com/v1/api/send";
        $apiKey = "YTFiMGE5MDAtMjIzZi00MzY1LWFiNDgtODUzZjMzYmM5MDI3OTQwZmFhOWYwMzUxOGY2YTZlZTU5YTQ0Y2M5NzQxNzE=";
        $correctPattern = "zy4vs7xn7yfjdcr"; 

        try {
            $response = Http::asMultipart()
                ->withHeaders([
                    'Authorization' => $apiKey,
                    'Accept' => 'application/json',
                ])
                ->post($url, [
                    [
                        'name'     => 'sending_type',
                        'contents' => 'pattern'
                    ],
                    [
                        'name'     => 'from_number',
                        'contents' => '+983000505'
                    ],
                    [
                        // تغییر به ساختار آرایه برای گیرندگان
                        'name'     => 'recipients[0]', 
                        'contents' => (string)$mobile
                    ],
                    [
                        'name'     => 'code', 
                        'contents' => $correctPattern
                    ],
                    [
                        // تغییر از values به params طبق ارور خروجی شما
                        'name'     => 'params[code]',
                        'contents' => (string)$otpCode
                    ],
                ]);

            // دیباگ نهایی
            dd([
                'توضیح' => 'تست با recipients[0] و params[code]',
                'status' => $response->status(),
                'body' => $response->json(),
            ]);

            return $response->successful() ? $response->json() : false;

        } catch (\Exception $e) {
            Log::error("SMS Edge Error: " . $e->getMessage());
            return false;
        }
    }
}
