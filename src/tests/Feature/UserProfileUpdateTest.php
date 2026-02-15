<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class UserProfileUpdateTest extends TestCase
{
    use RefreshDatabase;

    /** プロフィール編集画面に初期値が表示される */
    public function test_profile_edit_page_shows_initial_values()
    {
        $user = User::factory()->create([
            'name' => '既存ユーザー',
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区1-1-1',
        ]);

        $response = $this->actingAs($user)->get('/mypage/profile');

        $response->assertSee('既存ユーザー');
        $response->assertSee('123-4567');
        $response->assertSee('東京都渋谷区1-1-1');
    }
}
