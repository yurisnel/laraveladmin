<?php

namespace App\Rules;

use App\Models\Logs\LogError;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

class ValidHCaptcha implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //$value = '10000000-aaaa-bbbb-cccc-000000000001';
        $data = array(
            'secret' => env('H_CAPTCHA_SECRET'),
            'response' => $value
        );
        $captchaUrlApi = env("H_CAPTCHA_API_URL", "https://api.hcaptcha.com/siteverify");

        /*$verify = curl_init();
        curl_setopt($verify, CURLOPT_URL,  $captchaUrlApi);
        curl_setopt($verify, CURLOPT_POST, true);
        curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);

        $responseCurl = curl_exec($verify);
        $responseData = json_decode($responseCurl);

        if (!$responseData->success) {
            $fail('Invalid CAPTCHA. You need to prove you are human');
        }*/

        $response = Http::withOptions(['verify' => env('APP_ENV') === 'production'])
            ->asForm()
            ->post($captchaUrlApi, $data);


        if ($response->successful()) {
            $result = json_decode($response->body(), false);
            if ($result->success) {
                return;
            } else if (isset($result->{'error-codes'})) {
                $codes = $result->{'error-codes'};
                if (in_array('invalid-input-response', $codes)) {
                    $fail(__('validation.captcha_error_client'));
                    $invalidInputResponse = true;
                }
            }
        }
        if (!isset($invalidInputResponse)) {
            $fail(__('validation.captcha_error_server'));
            LogError::create([
                'message' => 'Error en servidor  CAPTCHA',
                'request' => 'POST ' . $captchaUrlApi,
                //'params' => json_encode($data),
                'body' => $response->body(),
                'status' => $response->status(),
            ]);
        }
    }
}
