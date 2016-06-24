<?php

namespace App\View\Composers;

use Illuminate\View\View;
use Atuh;

class AddAdminUser
{

    public function compose(View $view)
    {
        $view->with('admin', Auth::user());
    }
}
