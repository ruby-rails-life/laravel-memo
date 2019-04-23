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
    use RefreshDatabase;

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

    public function testDatabase()
    {
        // アプリケーションを呼び出す…
        $this->assertDatabaseHas('users', [
            'email' => 'xxxx@yyy.com'
        ]);

        //$project = factory(App\Project::class, 3)->make();
        $project = factory(\App\Project::class, 3)->create();
    }

    public function testProjectCreated()
    {
        Event::fake();

        $project = factory(\App\Project::class)->create();

        // Event::assertDispatched(ProjectCreated::class, function ($e) use ($project) {
        //     return $e->project->id === $public->id;
        // });

        // イベントが２回ディスパッチされることをアサート
        //Event::assertDispatched(ProjectCreated::class, 2);

        // イベントがディスパッチされないことをアサート
        Event::assertNotDispatched(ProjectCreated::class);
    }

    public function testProjectCreatedLimit()
    {
        $project = Event::fakeFor(function () {
            $project = factory(Project::class)->create();

            //Event::assertDispatched(ProjectCreated::class);
            Event::assertNotDispatched(ProjectCreated::class);

            return $project;
        });

        // イベントは通常通りにディスパッチされ、オブザーバが実行される
        //$project->update([...]);
    }

    public function testProjectCreatedMail()
    {
        Mail::fake();

        // Assert that no mailables were sent...
        Mail::assertNothingSent();

        $project = factory(\App\Project::class)->create();

        // Mail::assertSent(ProjectCreatedMail::class, function ($mail) use ($project) {
        //     return $mail->project->id === $project->id;
        // });

        // // メッセージが指定したユーザーに届いたことをアサート
        // Mail::assertSent(ProjectCreatedMail::class, function ($mail) use ($project) {
        //     return $mail->hasTo('...') &&
        //            $mail->hasCc('...') &&
        //            $mail->hasBcc('...');
        // });

        // // mailableが２回送信されたことをアサート
        // Mail::assertSent(ProjectCreatedMail::class, 2);

        // mailableが送られなかったことをアサート
        //Mail::assertNotSent(AnotherMailable::class);

        //Mail::assertNotSent(ProjectCreatedMail::class);
    }
}
