<?php

namespace App\Http\Controllers;

use LastFmFacade;
use View;

class HomePageController extends Controller
{
    public function index()
    {
        dd(LastFmFacade::getLatestTrack());
        return View::make('index');
    }
}