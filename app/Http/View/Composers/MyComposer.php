<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Clover;
//use App\Repositories\UserRepository;

class MyComposer
{
    /**
     * userリポジトリの実装
     *
     * @var UserRepository
     */
    //protected $users;

    /**
     * 新しいプロフィールコンポーザの生成
     *
     * @param  UserRepository  $users
     * @return void
     */
    //public function __construct(UserRepository $users)
    public function __construct()
    {
        // 依存はサービスコンテナにより自動的に解決される
        //$this->users = $users;
    }

    /**
     * データをビューと結合
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        //$view->with('count', $this->users->count());
        $view->with('count', Clover::count());
    }
}