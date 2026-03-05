<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\DiscountCode;
use App\Models\Event;
use App\Models\Merchandise;
use App\Models\Order;
use App\Models\Performer;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class FullDemoSeeder extends Seeder
{
    /**
     * Seeds all tables with realistic dummy data for a music festival app.
     */
    public function run(): void
    {
        // ─────────────────────────────────────────
        // 1. USERS
        // ─────────────────────────────────────────
        $users = [
            ['name' => 'Admin User',   'email' => 'admin@festival.com',  'password' => Hash::make('password'), 'role' => 'admin'],
            ['name' => 'Vipul Tikhe',  'email' => 'vipul@festival.com',  'password' => Hash::make('password')],
            ['name' => 'Sarah Connor', 'email' => 'sarah@example.com',   'password' => Hash::make('password')],
            ['name' => 'Raj Patel',    'email' => 'raj@example.com',     'password' => Hash::make('password')],
            ['name' => 'Priya Sharma', 'email' => 'priya@example.com',   'password' => Hash::make('password')],
        ];

        $createdUsers = [];
        foreach ($users as $u) {
            $createdUsers[] = User::updateOrCreate(['email' => $u['email']], $u);
        }

        // ─────────────────────────────────────────
        // 2. CATEGORIES
        // ─────────────────────────────────────────
        $categories = [
            ['name' => 'Music Festival', 'slug' => 'music-festival',   'description' => 'Multi-genre live music events'],
            ['name' => 'Rock',           'slug' => 'rock',             'description' => 'High-energy rock performances'],
            ['name' => 'Pop',            'slug' => 'pop',              'description' => 'Chart-topping pop artists'],
            ['name' => 'Electronic',     'slug' => 'electronic',       'description' => 'EDM, house and techno nights'],
            ['name' => 'Jazz & Blues',   'slug' => 'jazz-blues',       'description' => 'Soulful jazz and blues evenings'],
            ['name' => 'Bollywood',      'slug' => 'bollywood',        'description' => 'Bollywood live stage shows'],
        ];

        $createdCategories = [];
        foreach ($categories as $cat) {
            $createdCategories[] = Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }

        [$catFestival, $catRock, $catPop, $catElectronic, $catJazz, $catBollywood] = $createdCategories;

        // ─────────────────────────────────────────
        // 3. PERFORMERS
        // ─────────────────────────────────────────
        $performers = [
            [
                'name'        => 'Arijit Singh',
                'bio'         => 'One of India\'s most beloved playback singers, known for soulful romantic ballads.',
                'spotify_id'  => '4NiJW4q9ichVqL1aUsgGAN',
                'category_id' => $catBollywood->id,
                'image'       => null,
            ],
            [
                'name'        => 'Adele',
                'bio'         => 'Grammy Award-winning British singer-songwriter known for powerful vocal performances.',
                'spotify_id'  => '4dpARuHxo51G3z768sgnrY',
                'category_id' => $catPop->id,
                'image'       => null,
            ],
            [
                'name'        => 'Coldplay',
                'bio'         => 'British rock band famous for anthemic live performances and colourful stage shows.',
                'spotify_id'  => '4gzpq5Yv3Ls2S5NWotHJuN',
                'category_id' => $catRock->id,
                'image'       => null,
            ],
            [
                'name'        => 'Martin Garrix',
                'bio'         => 'Dutch DJ and record producer, one of the world\'s top electronic artists.',
                'spotify_id'  => '60d24wfXkVzDSfLS6hyCjZ',
                'category_id' => $catElectronic->id,
                'image'       => null,
            ],
            [
                'name'        => 'Norah Jones',
                'bio'         => 'Jazz-pop singer, pianist, and composer known for her warm, intimate sound.',
                'spotify_id'  => '6dVIqQ8qmQ5GBnJ9shOYGE',
                'category_id' => $catJazz->id,
                'image'       => null,
            ],
            [
                'name'        => 'The Weeknd',
                'bio'         => 'Canadian R&B singer known for blending pop, electronic, and dark R&B.',
                'spotify_id'  => '1Xyo4u8uXC1ZmMpatF05PJ',
                'category_id' => $catPop->id,
                'image'       => null,
            ],
        ];

        $createdPerformers = [];
        foreach ($performers as $p) {
            $createdPerformers[] = Performer::updateOrCreate(['name' => $p['name']], $p);
        }

        [$pArijit, $pAdele, $pColdplay, $pGarrix, $pNorah, $pWeeknd] = $createdPerformers;

        // ─────────────────────────────────────────
        // 4. EVENTS
        // ─────────────────────────────────────────
        $events = [
            [
                'title'        => 'Bollywood Night 2026',
                'description'  => 'An unforgettable evening of Bollywood hits performed live by Arijit Singh. Experience the magic of your favourite songs in a grand outdoor setting.',
                'date'         => now()->addDays(15)->toDateString(),
                'time'         => '19:00:00',
                'venue'        => 'MMRDA Grounds, Mumbai',
                'ticket_price' => 999,
                'performer_id' => $pArijit->id,
                'category_id'  => $catBollywood->id,
            ],
            [
                'title'        => 'Adele — Live in Concert',
                'description'  => 'The global superstar Adele brings her iconic voice to India for one special night only.',
                'date'         => now()->addDays(25)->toDateString(),
                'time'         => '20:00:00',
                'venue'        => 'Jawaharlal Nehru Stadium, Delhi',
                'ticket_price' => 2999,
                'performer_id' => $pAdele->id,
                'category_id'  => $catPop->id,
            ],
            [
                'title'        => 'Coldplay Music of the Spheres Tour',
                'description'  => 'Coldplay returns with their eco-friendly, spectacular live music experience. Expect stunning visuals, wristbands, and confetti cannons!',
                'date'         => now()->addDays(35)->toDateString(),
                'time'         => '18:30:00',
                'venue'        => 'DY Patil Stadium, Navi Mumbai',
                'ticket_price' => 1999,
                'performer_id' => $pColdplay->id,
                'category_id'  => $catRock->id,
            ],
            [
                'title'        => 'EDC India — Electronic Night',
                'description'  => 'India\'s biggest electronic dance music festival featuring Martin Garrix headlining a night of world-class beats.',
                'date'         => now()->addDays(50)->toDateString(),
                'time'         => '22:00:00',
                'venue'        => 'Expo Mart, Greater Noida',
                'ticket_price' => 1499,
                'performer_id' => $pGarrix->id,
                'category_id'  => $catElectronic->id,
            ],
            [
                'title'        => 'Jazz Under the Stars',
                'description'  => 'A soulful evening of jazz and blues with the legendary Norah Jones. Grab a drink, sit back, and let the music move you.',
                'date'         => now()->addDays(60)->toDateString(),
                'time'         => '19:30:00',
                'venue'        => 'The Grand Hyatt Lawns, Mumbai',
                'ticket_price' => 1799,
                'performer_id' => $pNorah->id,
                'category_id'  => $catJazz->id,
            ],
            [
                'title'        => 'The Weeknd After Hours Tour',
                'description'  => 'The Weeknd\'s cinematic, theatrical stage show comes to India with a full band and immersive lighting experiences.',
                'date'         => now()->addDays(75)->toDateString(),
                'time'         => '21:00:00',
                'venue'        => 'Kanteerava Stadium, Bangalore',
                'ticket_price' => 2499,
                'performer_id' => $pWeeknd->id,
                'category_id'  => $catPop->id,
            ],
            [
                'title'        => 'Summer Music Festival 2026',
                'description'  => 'A 2-day mega festival featuring Coldplay and Arijit Singh on the same stage. Once-in-a-lifetime!',
                'date'         => now()->addDays(90)->toDateString(),
                'time'         => '16:00:00',
                'venue'        => 'MMRDA Grounds, Mumbai',
                'ticket_price' => 3999,
                'performer_id' => $pColdplay->id,
                'category_id'  => $catFestival->id,
                'capacity'     => 500,
            ],
        ];

        $createdEvents = [];
        foreach ($events as $e) {
            $createdEvents[] = Event::updateOrCreate(
                ['title' => $e['title']],
                $e
            );
        }

        // ─────────────────────────────────────────
        // 5. EVENT-PERFORMER PIVOT (many-to-many)
        // ─────────────────────────────────────────
        // Link primary performers and co-performers
        $createdEvents[0]->performers()->syncWithoutDetaching([$pArijit->id]);
        $createdEvents[1]->performers()->syncWithoutDetaching([$pAdele->id]);
        $createdEvents[2]->performers()->syncWithoutDetaching([$pColdplay->id]);
        $createdEvents[3]->performers()->syncWithoutDetaching([$pGarrix->id]);
        $createdEvents[4]->performers()->syncWithoutDetaching([$pNorah->id]);
        $createdEvents[5]->performers()->syncWithoutDetaching([$pWeeknd->id]);
        // Summer Festival: Coldplay + Arijit as co-headliners
        $createdEvents[6]->performers()->syncWithoutDetaching([$pColdplay->id, $pArijit->id]);

        // ─────────────────────────────────────────
        // 6. MERCHANDISE
        // ─────────────────────────────────────────
        $merchandise = [
            ['name' => 'Festival T-Shirt 2026',        'description' => 'Official festival tee with all artists printed on the back. Available in S, M, L, XL.',   'price' => 599,  'stock' => 200],
            ['name' => 'Music Festival Hoodie',         'description' => 'Cozy hoodie with the festival logo embossed. Perfect for cool nights.',                    'price' => 1299, 'stock' => 100],
            ['name' => 'Limited Edition Poster',        'description' => 'A3 glossy poster featuring all headline artists. Only 500 printed!',                       'price' => 299,  'stock' => 500],
            ['name' => 'Festival Wristband Pack',       'description' => 'Pack of 3 fabric wristbands — gold, silver, and black. Commemorative editions.',           'price' => 149,  'stock' => 1000],
            ['name' => 'Canvas Tote Bag',               'description' => 'Eco-friendly canvas bag with festival artwork. Great for carrying your merchandise!',       'price' => 349,  'stock' => 300],
            ['name' => 'Collector\'s Enamel Pin Set',  'description' => 'Set of 5 enamel pins featuring each artist\'s logo. Perfect for denim jackets.',           'price' => 499,  'stock' => 400],
            ['name' => 'Festival Cap',                  'description' => 'Snapback cap with embroidered festival logo. One size fits all.',                           'price' => 699,  'stock' => 250],
            ['name' => 'Glow LED Wristband',            'description' => 'RGB LED wristband that syncs to music. Used during the show, keep it as a souvenir!',     'price' => 199,  'stock' => 2000],
        ];

        foreach ($merchandise as $item) {
            Merchandise::updateOrCreate(['name' => $item['name']], $item);
        }

        // ─────────────────────────────────────────
        // 7. DISCOUNT CODES
        // ─────────────────────────────────────────
        $discounts = [
            ['code' => 'FESTIVAL10',  'percentage' => 10, 'expires_at' => now()->addMonths(3)->toDateString(), 'single_use' => false],
            ['code' => 'WELCOME25',   'percentage' => 25, 'expires_at' => now()->addMonth()->toDateString(),   'single_use' => true],
            ['code' => 'SUMMER20',    'percentage' => 20, 'expires_at' => now()->addMonths(2)->toDateString(), 'single_use' => false],
            ['code' => 'EARLYBIRD',   'percentage' => 15, 'expires_at' => now()->addWeeks(2)->toDateString(),  'single_use' => false],
            ['code' => 'VIP50',       'percentage' => 50, 'expires_at' => now()->addWeek()->toDateString(),    'single_use' => true],
            ['code' => 'COLDPLAYFAN', 'percentage' => 12, 'expires_at' => now()->addMonths(4)->toDateString(), 'single_use' => false],
            ['code' => 'MERCH15',     'percentage' => 15, 'expires_at' => now()->addMonths(2)->toDateString(), 'single_use' => false],
        ];

        foreach ($discounts as $d) {
            DiscountCode::updateOrCreate(['code' => $d['code']], $d);
        }

        // ─────────────────────────────────────────
        // 8. ORDERS (dummy completed + pending)
        // ─────────────────────────────────────────
        $allMerch = Merchandise::all();

        $orders = [
            // Ticket orders
            [
                'user_id'          => $createdUsers[1]->id,
                'event_id'         => $createdEvents[0]->id,
                'merchandise_id'   => null,
                'total_amount'     => 999.00,
                'status'           => 'paid',
                'quantity'         => 1,
                'stripe_session_id'=> 'cs_test_demo_001',
                'discount_code'    => null,
            ],
            [
                'user_id'          => $createdUsers[2]->id,
                'event_id'         => $createdEvents[2]->id,
                'merchandise_id'   => null,
                'total_amount'     => 3598.20,
                'status'           => 'paid',
                'quantity'         => 2,
                'stripe_session_id'=> 'cs_test_demo_002',
                'discount_code'    => 'FESTIVAL10',
            ],
            [
                'user_id'          => $createdUsers[3]->id,
                'event_id'         => $createdEvents[1]->id,
                'merchandise_id'   => null,
                'total_amount'     => 2999.00,
                'status'           => 'pending',
                'quantity'         => 1,
                'stripe_session_id'=> null,
                'discount_code'    => null,
            ],
            [
                'user_id'          => $createdUsers[4]->id,
                'event_id'         => $createdEvents[4]->id,
                'merchandise_id'   => null,
                'total_amount'     => 1529.70,
                'status'           => 'paid',
                'quantity'         => 1,
                'stripe_session_id'=> 'cs_test_demo_003',
                'discount_code'    => 'EARLYBIRD',
            ],
            // Merchandise orders
            [
                'user_id'          => $createdUsers[1]->id,
                'event_id'         => null,
                'merchandise_id'   => $allMerch->firstWhere('name', 'Festival T-Shirt 2026')?->id,
                'total_amount'     => 599.00,
                'status'           => 'paid',
                'quantity'         => 1,
                'stripe_session_id'=> 'cs_test_demo_004',
                'discount_code'    => null,
            ],
            [
                'user_id'          => $createdUsers[2]->id,
                'event_id'         => null,
                'merchandise_id'   => $allMerch->firstWhere('name', 'Music Festival Hoodie')?->id,
                'total_amount'     => 2337.00,
                'status'           => 'paid',
                'quantity'         => 2,
                'stripe_session_id'=> 'cs_test_demo_005',
                'discount_code'    => 'MERCH15',
            ],
            [
                'user_id'          => $createdUsers[3]->id,
                'event_id'         => null,
                'merchandise_id'   => $allMerch->firstWhere('name', 'Festival Cap')?->id,
                'total_amount'     => 699.00,
                'status'           => 'failed',
                'quantity'         => 1,
                'stripe_session_id'=> 'cs_test_demo_006',
                'discount_code'    => null,
            ],
        ];

        foreach ($orders as $order) {
            Order::create($order);
        }

        $this->command->info('✅ Full demo data seeded successfully!');
        $this->command->table(
            ['Table', 'Records'],
            [
                ['users',          count($users)],
                ['categories',     count($categories)],
                ['performers',     count($performers)],
                ['events',         count($events)],
                ['event_performer','pivot entries created'],
                ['merchandises',   count($merchandise)],
                ['discount_codes', count($discounts)],
                ['orders',         count($orders)],
            ]
        );
    }
}
