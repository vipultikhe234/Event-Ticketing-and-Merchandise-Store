<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

$user = User::where('email', 'admin@festival.com')->first();
if ($user) {
    $user->role = 'admin';
    $user->save();
    echo "SUCCESS: admin@festival.com is now an admin.\n";
} else {
    echo "ERROR: User admin@festival.com not found.\n";
}
