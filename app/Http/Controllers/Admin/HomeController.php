<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// HomeController privato, reinderizza solo alla pagina di log in effettuato
class HomeController extends Controller
{
    public function index () {
        // Qui la pagina per gli utenti appena loggati, admin.home
        return view('admin.home');
    }
}
