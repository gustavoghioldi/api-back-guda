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
        $url = $link->redirect()->getTargetUrl();
        return response()->json(["data"=>$url], 200)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function getUser()
    {
        $user = Socialite::driver('linkedin')->user();
        dd($user);

        // $user->token;
    }
}
