<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SpotifyService
{
    protected $clientId;
    protected $clientSecret;

    public function __construct()
    {
        $this->clientId = config('services.spotify.client_id');
        $this->clientSecret = config('services.spotify.client_secret');
    }

    protected function getAccessToken()
    {
        return Cache::remember('spotify_access_token', 3300, function () {
            $response = Http::asForm()
                ->withOptions(['verify' => false])
                ->withBasicAuth($this->clientId, $this->clientSecret)
                ->post('https://accounts.spotify.com/api/token', [
                    'grant_type' => 'client_credentials'
                ]);

            if ($response->ok()) {
                return $response->json()['access_token'] ?? null;
            }

            Log::error('Spotify Token Request Failed: ' . $response->body());
            return null;
        });
    }

    public function getTopTracksByArtist($artistSpotifyId, $country = 'US')
    {
        $cacheKey = "spotify_top_tracks_{$artistSpotifyId}_{$country}";

        return Cache::remember($cacheKey, 3600, function () use ($artistSpotifyId, $country) {
            $token = $this->getAccessToken();
            if (!$token) return [];

            $res = Http::withOptions(['verify' => false])
                ->withToken($token)
                ->get("https://api.spotify.com/v1/artists/{$artistSpotifyId}/top-tracks", [
                    'market' => $country
                ]);

            if ($res->ok()) {
                return $res->json()['tracks'] ?? [];
            }
            return [];
        });
    }
}
