<?php

namespace Database\Seeders;

use App\Models\DiscountCode;
use App\Models\Event;
use App\Models\Performer;
use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $performers = [
            [
                'name' => 'Arjit Singh',
                'bio' => 'Legendary electronic music producer and DJ.',
                'image' => 'uploads/performer/performer_68e022638c45e.jpg',
                'spotify_id' => '0hCNtLu0JehylgoiP8L4Gh'
            ],
            [
                'name' => 'Adele',
                'bio' => 'Award-winning British singer and songwriter.',
                'image' => 'uploads/performer/performer_68e022638c45e.jpg',
                'spotify_id' => '4dpARuHxo51G3z768sgnrY'
            ],
        ];

        foreach ($performers as $performer) {
            Performer::create($performer);
        }

        $events = [
            [
                'title' => 'Sunset Music Fest',
                'description' => 'An amazing electronic music festival by DJ Shadow.',
                'date' => now()->addDays(10)->toDateString(),
                'time' => '18:00:00',
                'venue' => 'Open Air Stadium',
                'ticket_price' => 500,
                'performer_id' => 1,
            ],
            [
                'title' => 'Adele Live Concert',
                'description' => 'Experience the magic of Adele live in concert.',
                'date' => now()->addDays(20)->toDateString(),
                'time' => '20:00:00',
                'venue' => 'Grand Arena',
                'ticket_price' => 1500,
                'performer_id' => 2,
            ],
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
        $discounts = [
            [
                'code' => 'SUMMER25',
                'percentage' => 20,
                'expires_at' => now()->addMonth()->toDateString(),
                'single_use' => false,
            ],
            [
                'code' => 'WELCOME25',
                'percentage' => 10,
                'expires_at' => now()->addMonth()->toDateString(),
                'single_use' => true,
            ],
        ];

        foreach ($discounts as $discount) {
            DiscountCode::create($discount);
        }
    }
}
