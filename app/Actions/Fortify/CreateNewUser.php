<?php

namespace App\Actions\Fortify;

use App\Mail\nuevo_usuario;
use App\Models\ArmorumappInfodeportistum;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'tipo_documento' => ['required', 'integer', 'exists:tipo_documentos,id'],
            'username' => ['required', 'regex:/^[0-9]+$/', 'string', 'max:255', 'min:4', 'unique:users'],
            'verify_username' => ['required', 'same:username'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ], [
            'username.unique' => 'El número de identificación ya está en uso.',
            'username.regex' => 'El número de identificación solo puede contener números.',
            'verify_username.required' => 'Debe confirmar el número de identificación.',
            'verify_username.same' => 'El número de identificación no coincide.',
            'email.unique' => 'El correo electrónico ya está en uso.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
        ])->validate();

        $user = User::create([
            'tipo_documento' => $input['tipo_documento'],
            'username' => $input['username'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

        // $info_deportista = new ArmorumappInfodeportistum();

        // if (!$info_deportista) {
        //     Log::error('No se encontró información en info_deportista para el username: ' . $user->username);
        //     return back()->withErrors(['No se pudo encontrar información para este usuario.']);
        // }

        $info_deportista = ArmorumappInfodeportistum::where('documento_tercero', $user->username)->first();

        if ($info_deportista === null) {
            Log::warning('No se encontró la información del deportista para el usuario: ' . $user->username);
            $info_deportista = new ArmorumappInfodeportistum();
        }

        try {
            Mail::to($user->email)->send(new nuevo_usuario($user, $info_deportista));
        } catch (\Exception $e) {
            Log::error('Error al enviar el correo: ' . $e->getMessage());
            // return back()->withErrors(['message' => 'Hubo un error al enviar el correo.']);
        }

        return $user;
    }
}
