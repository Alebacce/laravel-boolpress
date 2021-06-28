<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewContactUserAutoreplay;

// L'HomeController pubblico, ritorna la home pubblica
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('guest.home');
    }

    public function contacts() 
    {
        return view('guest.contacts');
    }

    // La funzione che legge i dati scritti nel form di contatto
    public function handleNewContact(Request $request) 
    {   
        $form_data = $request->all();

        Mail::to($form_data['email'])->send(new NewContactUserAutoreplay());
        return redirect()->route('contacts-thankyou');
    }

    public function contactsThankYou()
    {
        return view('guest.contacts-thankyou');
    }
}
