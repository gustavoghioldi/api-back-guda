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
        //$link->redirectUrl("http://localhost:8888");
        $url = $link->stateless()->redirect()->getTargetUrl();
        return response()->json(["data"=>$url], 200);

    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function getUser()
    {

        $connector = Socialite::driver('linkedin')->stateless();
        //$connector->redirectUrl("http://localhost:8000");
        $user = $connector->user();
        $mc = $this->getMonogoConnector("users");
        
        
        $mongoUser =$mc->findOne(["id"=>$user->id]);
        
        if ($mongoUser==null){
            $mc->insertOne($user->user);
        }

        $mcs = $this->getMonogoConnector("session");
        $mongoSession = $mcs->findOne(["userId"=>$user->id]);
        
        if ($mongoSession==null){
            $mcs->insertOne(["userId"=>$user->id,"token"=>$user->token, "register"=>date("ymdhis")]);
        }else {
            $mcs->updateOne(["userId"=>$user->id], ['$set'=>["token"=>$user->token,"register"=>date("ymdhis")]]);
        }
        

        return response()->json($user, 200);

        
    }

    private function getMonogoConnector($collectionName){
        $manager = new \MongoDB\Driver\Manager("mongodb://localhost:27017");
        return  new \MongoDB\Collection($manager, "phplib_demo", $collectionName);
    }
}
