<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ExampleTest extends TestCase
{
    // public function setUp()
    // {
    //     dd(env('APP_ENV'), env('DB_HOST'));
    //     parent::setUp();
    // }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGet()
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        $response->assertViewIs('article.index');
    }

    public function testAuth()
    {
        $user = factory(User::class)->create(['role' => 2]);

        $response = $this->actingAs($user)
                         ->withSession(['foo' => 'bar'])
                         ->get('/project');
    }

    public function testPost()
    {
        $response = $this->post('/create', ['title' => 'test_title', 'body' => 'test_body']);

        $response
            ->assertStatus(200);
    }

    public function testAvatarUpload()
    {
        $user = factory(User::class)->create(['role' => 2]);

        Storage::fake('public');

        $file = UploadedFile::fake()->image('avatar.jpg', 100, 100)->size(100);

        $response = $this->actingAs($user)
                         ->json('POST','/photos', [
                            'fileName' => $file,
        ]);

        // ファイルが保存されたことをアサートする
        //Storage::disk('public')->assertExists($file->hashName());

        // ファイルが存在しないことをアサートする
        //Storage::disk('public')->assertMissing('missing.jpg');
    }

    /**
     * コンソールコマンドのテスト
     *
     * @return void
     */
    public function test_console_command()
    {
        $this->artisan('question')
             ->expectsQuestion('What is your name?', 'Taylor Otwell')
             ->expectsQuestion('Which language do you program in?', 'PHP')
             ->expectsOutput('Your name is Taylor Otwell and you program in PHP.')
             ->assertExitCode(0);
    }
}
