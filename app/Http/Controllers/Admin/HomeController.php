<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index () {
        // Qui la pagina per gli utenti appena loggati
        return view('admin.home');
    }
}
