<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\SmsLog;
use Carbon\Carbon;

class SmsService
{
  public static function send($phone, $message, $options = [])
  {
    $url = env('SMS_GATEWAY_URL');
    $user = env('SMS_GATEWAY_USER');
    $pass = env('SMS_GATEWAY_PASS');

    $siswaId = $options['siswa_id'] ?? null;
    $doLog = array_key_exists('log', $options) ? (bool)$options['log'] : true;

    $phone = self::formatPhone($phone);

    try {
      $response = Http::withBasicAuth($user, $pass)
        ->post(rtrim($url, '/') . '/messages', [
          'message' => $message,
          'phoneNumbers' => [$phone]
        ]);

      $status = $response->successful() ? 'sent' : 'failed';
      $responseBody = $response->body();

      if ($doLog) {
        try {
          // avoid duplicate logs within short interval
          $recentExists = SmsLog::where('phone', $phone)
            ->where('message', $message)
            ->where('created_at', '>=', Carbon::now()->subSeconds(60))
            ->exists();

          if (! $recentExists) {
            SmsLog::create([
              'siswa_id' => $siswaId,
              'phone' => $phone,
              'message' => $message,
              'status' => $status,
              'response' => $responseBody,
              'error' => $status === 'sent' ? null : $responseBody,
            ]);
          }
        } catch (\Throwable $e) {
          Log::warning('SmsService: failed to persist SmsLog', ['error' => $e->getMessage()]);
        }
      }

      // try to return parsed json when possible
      $json = null;
      try {
        $json = $response->json();
      } catch (\Throwable $e) {
        $json = $responseBody;
      }

      return $json;
    } catch (\Throwable $e) {
      // on error, optionally persist log and return structured failure
      if ($doLog) {
        try {
          SmsLog::create([
            'siswa_id' => $siswaId,
            'phone' => $phone,
            'message' => $message,
            'status' => 'failed',
            'response' => null,
            'error' => $e->getMessage(),
          ]);
        } catch (\Throwable $e2) {
          Log::warning('SmsService: failed to persist SmsLog after exception', ['error' => $e2->getMessage()]);
        }
      }

      Log::warning('SmsService send error', ['error' => $e->getMessage()]);

      return ['success' => false, 'error' => $e->getMessage()];
    }
  }

  private static function formatPhone($phone)
  {
    $phone = preg_replace('/[^0-9]/', '', $phone);

    if (substr($phone, 0, 1) == '0') {
      return '+62' . substr($phone, 1);
    }

    return $phone;
  }
}
