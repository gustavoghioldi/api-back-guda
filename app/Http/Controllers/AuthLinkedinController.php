<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Socialite;
use App\Http\Requests;

class AuthLinkedinController extends Controller
{
      /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function getLoginUrl()
    {
        $link =  Socialite::with('linkedin');
        return $link->redirect()->getTargetUrl();
        
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function getUser()
    {
        $$user = Socialite::driver('linkedin')->user();
        dd($user);

        // $user->token;
    }
}
