<?php

namespace App\Http\Controllers;

use App\Mail\MessageReceived;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MessageController extends Controller
{
    //Método para guardar la información por medio del store
    public function store(Request $request)
    {

        // Validamos los datos del fórmulario
        $message =  $request->validate([
            'name' => 'required',
            'email' => ['required', 'email'],
            'subjet' => 'required',
            'content' => 'required|min:3'
        ], [
            'name.required' => 'Necesito tu nombre',
            'email.required' => 'Necesito tu email',
            'subject.required' => 'Por favor agregue un asunto.',
            'content.required' => 'El contenido debe tener por lo menos 3 caracteres.',
        ]);


        // Enviamos el Email
        Mail::to('programasjhonfa@gmail.com')->queue(new MessageReceived($message));

        // return new MessageReceived($message);



        // return "Mensaje Enviado";
        return redirect()->route('contact')->with('status','Recibimos tu mensaje, te responderemos en menos de 24 horas.');
    }
}
