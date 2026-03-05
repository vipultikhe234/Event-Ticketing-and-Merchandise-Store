<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\User;
use App\Models\Performer;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_view_the_dashboard_with_events()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $category = Category::create(['name' => 'Music', 'slug' => 'music']);
        $performer = Performer::create(['name' => 'Artist One']);
        
        Event::create([
            'title' => 'Concert One',
            'date' => now()->addDays(5)->toDateString(),
            'time' => '20:00:00',
            'venue' => 'Grand Stadium',
            'ticket_price' => 50,
            'performer_id' => $performer->id,
            'category_id' => $category->id
        ]);

        $response = $this->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Concert One');
    }

    /** @test */
    public function events_can_be_retrieved_via_api()
    {
        $category = Category::create(['name' => 'Music', 'slug' => 'music']);
        $performer = Performer::create(['name' => 'Artist One']);
        
        Event::create([
            'title' => 'API Event',
            'date' => now()->addDays(5)->toDateString(),
            'time' => '20:00:00',
            'venue' => 'API Venue',
            'ticket_price' => 30,
            'performer_id' => $performer->id,
            'category_id' => $category->id
        ]);

        $response = $this->getJson('/api/api-events');

        $response->assertStatus(200);
        $response->assertJsonFragment(['title' => 'API Event']);
    }
}
