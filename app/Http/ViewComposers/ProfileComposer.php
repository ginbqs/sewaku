<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Panel\Config;

class ProfileComposer
{
    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */
    protected $users;

    /**
     * Create a new profile composer.
     *
     * @param  UserRepository  $users
     * @return void
     */
    // public function __construct(UserRepository $users)
    // {
    //     // Dependencies automatically resolved by service container...
    //     $this->users = $users;
    // }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
    	$config = [];
        $dtConfig = Config::all();
        foreach ($dtConfig as $key) {
            $config[$key->id] = $key->value;
        }
        $view->with(compact('config'));
    }
}