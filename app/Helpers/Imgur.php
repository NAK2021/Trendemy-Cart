<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;

class Imgur
{
    public static function upload($file)
    {
        try {
            $file_path = $file->getPathName();
            $response = Http::withHeaders([
                'authorization' => 'Client-ID ' . env('IMGUR_CLIENT_ID'),
                'content-type' => 'application/x-www-form-urlencoded',
            ])->send('POST', 'https://api.imgur.com/3/image', [
                'form_params' => [
                    'image' => base64_encode(file_get_contents($file->path($file_path)))
                ],
            ]);
            return data_get(response()->json(json_decode(($response->getBody()->getContents())))->getData(), 'data.link');
        } catch (RequestException $e) {
            $message = 'Error uploading image to Imgur: ' . $e->getMessage();
            Log::error($message, ['exception' => $e]);
            throw new \Exception($message);
        }
    }
}
