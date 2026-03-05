<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Merchandise;
use App\Models\Event;
use App\Models\Performer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategoryAndMerchandiseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1. Create Categories
        $categories = [
            ['name' => 'Music Festival', 'slug' => 'music-festival'],
            ['name' => 'Rock', 'slug' => 'rock'],
            ['name' => 'Pop', 'slug' => 'pop'],
            ['name' => 'Electronic', 'slug' => 'electronic'],
            ['name' => 'Jazz', 'slug' => 'jazz'],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }

        $festivalCat = Category::where('slug', 'music-festival')->first();

        // 2. Update existing events and performers with a category
        Event::whereNull('category_id')->update(['category_id' => $festivalCat->id]);
        Performer::whereNull('category_id')->update(['category_id' => $festivalCat->id]);

        // Link existing events to their primary performer in the pivot table
        foreach (Event::all() as $event) {
            if ($event->performer_id) {
                $event->performers()->syncWithoutDetaching([$event->performer_id]);
            }
        }

        // 3. Create Merchandise
        $merch = [
            [
                'name' => 'Festival T-Shirt 2026',
                'description' => 'Official festival t-shirt with all performers listed on the back.',
                'price' => 25.00,
                'stock' => 100,
            ],
            [
                'name' => 'Music Festival Hoodie',
                'description' => 'Keep warm during the long nights of the festival.',
                'price' => 45.00,
                'stock' => 50,
            ],
            [
                'name' => 'Poster - Limited Edition',
                'description' => 'A beautifully designed poster of the festival.',
                'price' => 15.00,
                'stock' => 200,
            ],
            [
                'name' => 'Festival Wristband',
                'description' => 'Memory of the best time of your life.',
                'price' => 5.00,
                'stock' => 500,
            ],
        ];

        foreach ($merch as $item) {
            Merchandise::updateOrCreate(['name' => $item['name']], $item);
        }
    }
}
