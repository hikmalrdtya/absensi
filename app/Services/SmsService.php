<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\SmsLog;

class SmsService
{
  public static function send($phone, $message, $siswa_id = null)
  {
    if (empty($phone)) {
      Log::warning('SmsService: phone number empty, message skipped', ['message' => $message]);
      return ['success' => false, 'error' => 'empty_phone'];
    }

    // Normalize Indonesian numbers: 0895... -> 62895..., 895... -> 62895...
    $normalizedPhone = self::normalizePhone($phone);

    try {
      $params = [
        'userkey' => env('ZENZIVA_USERKEY'),
        'passkey' => env('ZENZIVA_PASSKEY'),
        'nohp' => $normalizedPhone,
        'pesan' => $message,
      ];

      Log::info('SmsService: sending request', ['url' => env('ZENZIVA_URL'), 'params' => $params]);

      $response = Http::get(env('ZENZIVA_URL'), $params);

      $body = $response->body();

      // Try to detect real delivery status by parsing provider response (XML/JSON/plain)
      $isDelivered = false;
      $parsedInfo = null;

      // If XML, parse and inspect
      if (stripos(trim($body), '<?xml') === 0) {
        try {
          $xml = @simplexml_load_string($body);
          $parsedInfo = json_encode($xml);

          // Search common success indicators
          $lower = strtolower($body);
          if (str_contains($lower, 'sukses') || str_contains($lower, 'success') || str_contains($lower, '<status>0') || str_contains($lower, '<rc>0')) {
            $isDelivered = true;
          } else {
            // Check specific nodes if present
            if ($xml !== false) {
              foreach ($xml->children() as $child) {
                $text = strtolower((string) $child);
                if (str_contains($text, 'sukses') || str_contains($text, 'success') || trim($text) === '0') {
                  $isDelivered = true;
                  break;
                }
              }
            }
          }
        } catch (\Throwable $e) {
          Log::warning('SmsService: failed parsing XML response', ['error' => $e->getMessage()]);
        }
      } else {
        // Plain text or JSON
        $lower = strtolower($body ?? '');
        if (str_contains($lower, 'sukses') || str_contains($lower, 'success') || str_contains($lower, 'ok')) {
          $isDelivered = true;
        }
      }

      if ($isDelivered) {
        $res = ['success' => true, 'body' => $body, 'parsed' => $parsedInfo];
        SmsLog::create([
          'siswa_id' => $siswa_id,
          'phone' => $normalizedPhone,
          'message' => $message,
          'status' => 'sent',
          'response' => $body,
        ]);
        return $res;
      }

      Log::error('SmsService: non-success response', ['phone' => $normalizedPhone, 'status' => $response->status(), 'body' => $body]);
      SmsLog::create([
        'siswa_id' => $siswa_id,
        'phone' => $normalizedPhone,
        'message' => $message,
        'status' => 'failed',
        'response' => $body,
      ]);
      return ['success' => false, 'status' => $response->status(), 'body' => $body];
    } catch (\Throwable $e) {
      Log::error('SmsService exception: ' . $e->getMessage(), ['phone' => $phone]);
      SmsLog::create([
        'siswa_id' => $siswa_id,
        'phone' => $normalizedPhone,
        'message' => $message,
        'status' => 'error',
        'error' => $e->getMessage(),
      ]);
      return ['success' => false, 'error' => $e->getMessage()];
    }
  }

  private static function normalizePhone($phone)
  {
    $p = trim($phone);
    $p = preg_replace('/[^0-9\+]/', '', $p);
    // remove leading +
    if (str_starts_with($p, '+')) {
      $p = substr($p, 1);
    }

    // if starts with 0 -> replace with 62
    if (str_starts_with($p, '0')) {
      $p = '62' . substr($p, 1);
    }

    // if starts with 8 (e.g., 895...) -> prefix 62
    if (str_starts_with($p, '8')) {
      $p = '62' . $p;
    }

    return $p;
  }
}
