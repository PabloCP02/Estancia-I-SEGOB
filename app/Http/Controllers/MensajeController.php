<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mensaje;
use Illuminate\Support\Facades\Auth;

class MensajeController extends Controller
{
    public function enviarMensaje(Request $request)
    {
        $request->validate([
            'mensaje' => 'required|string|max:500',
            'receiver_id' => 'required|integer',
        ]);

        Mensaje::create([
            'user_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'mensaje' => $request->mensaje,
        ]);

        return redirect()->back()->with('success', 'Mensaje enviado correctamente');
    }

    public function verConversacion($user_id)
    {
        $mensajes = Mensaje::where(function ($query) use ($user_id) {
            $query->where('user_id', Auth::id())
                  ->where('receiver_id', $user_id);
        })->orWhere(function ($query) use ($user_id) {
            $query->where('user_id', $user_id)
                  ->where('receiver_id', Auth::id());
        })->orderBy('created_at', 'asc')->get();

        return view('mensajes.conversacion', compact('mensajes', 'user_id'));
    }
}
