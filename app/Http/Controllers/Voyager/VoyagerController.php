<?php

namespace App\Http\Controllers\Voyager;

use TCG\Voyager\Http\Controllers\VoyagerController as BaseVoyagerController;
use Illuminate\Support\Facades\Auth;
class VoyagerController extends BaseVoyagerController
{
    //
    public function logout()
    {
        Auth::logout();

        return redirect()->route('home');
    }
}
