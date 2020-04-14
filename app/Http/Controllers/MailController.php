<?php

namespace App\Http\Controllers;

use DB;
use Mail;
use \App\Mail\ContactMail;
use Illuminate\Http\Request;

class MailController extends Controller
{
    public function send(Request $request){
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);

        $data = array(
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
        );

        Mail::to(env('MAIL_CONTACT_FORM'))->send(new ContactMail($data));
        return back()->with('success','Grazie per averci contattato!');
    }
}
