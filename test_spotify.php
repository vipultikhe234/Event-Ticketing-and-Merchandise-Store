<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Services\SpotifyService;

$spotify = app(SpotifyService::class);
// Test artist ID (Coldplay)
$artistId = '4gzpq5Yv3Ls2S5NWotHJuN';
try {
    $tracks = $spotify->getTopTracksByArtist($artistId);
    echo "Tracks for Coldplay:\n";
    print_r($tracks);
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
