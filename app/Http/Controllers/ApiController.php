<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    //all response functions are in app\Traits\ApiResponser.php
    use ApiResponser;
}
