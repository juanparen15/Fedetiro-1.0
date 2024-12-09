<?php

namespace App\Http\Controllers;

use TCG\Voyager\Http\Controllers\VoyagerUserController;
use Illuminate\Http\Request;
use App\Models\User;

class CustomVoyagerUserController extends VoyagerUserController
{
    // public function toggleActive(Request $request)
    // {
    //     $request->validate([
    //         'id' => 'required|exists:users,id',
    //         'isActive' => 'required|boolean',
    //     ]);

    //     try {
    //         $user = User::findOrFail($request->id);
    //         $user->isActive = $request->isActive;
    //         $user->save();

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'El estado del usuario se actualizó correctamente.',
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'No se pudo actualizar el estado del usuario.',
    //         ]);
    //     }
    // }
    
}
