<?php

namespace App\Http\Composers;


use App\User;
use Illuminate\View\View;

class UserSelectComposer
{
    /**
     * @var Business
     */
    private $user;

    public function __construct(User $user)
    {

        $this->user = $user;
    }

    public function compose(View $view)
    {
        $view->with('users', $this->user->where('active', 1)->where('id', '!=', auth()->user()->id)->orderBy('name')->get());
    }
}