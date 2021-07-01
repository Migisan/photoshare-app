<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Photo;
use App\User;

class LikeApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp():void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();

        factory(Photo::class)->create();
        $this->photo = Photo::first();
    }

    /**
     * @test
     */
    public function should_addLike()
    {
        $response = $this->actingAs($this->user)
            ->json('PUT', route('photo.like', [
                'id' => $this->photo->id,
            ]));

        $response->assertStatus(200)
            ->assertJsonFragment([
                'photo_id' => $this->photo->id,
            ]);

        $this->assertEquals(1, $this->photo->likes()->count());
    }

    /**
     * @test
     */
    public function should_notTwoLikes()
    {
        $param = ['id' => $this->photo->id];
        $this->actingAd($this->user)->json('PUT', route('photo.like', $param));
        $this->actingAd($this->user)->json('PUT', route('photo.like', $param));

        $this->assertEquals(1, $this->photo->likes()->count());
    }

    /**
     * @test
     */
    public function should_removeLike()
    {
        $this->photo->likes()->attacht($this->user->id);

        $response = $this->actingAs($this->user)
            ->json('DELETE', route('photo.like', [
                'id' => $this->photo->id,
            ]));

        $response->assertStatus(200)
            ->assertJsonFragment([
                'photo_id' => $this->photo->id,
            ]);

        $this->assertEquals(0, $this->photo->likes()->count());
    }
}
