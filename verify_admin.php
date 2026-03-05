<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

$user = User::where('email', 'admin@festival.com')->first();
if ($user) {
    $user->update(['role' => 'admin']);
    echo "VERIFIED: admin@festival.com is now " . User::where('email', 'admin@festival.com')->first()->role . "\n";
} else {
    echo "NOT FOUND: admin@festival.com\n";
}
