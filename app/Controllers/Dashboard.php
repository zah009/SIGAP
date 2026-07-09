<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        return "Halo " . esc(session()->get('username')) . ", role kamu: " . esc(session()->get('role'));
    }
}