<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class PruebaController extends Controller
{

public function index(){
$manager = new \MongoDB\Driver\Manager("mongodb://localhost:27017");
$collection = new \MongoDB\Collection($manager, "phplib_demo", "write");


    }
}
