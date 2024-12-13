<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\ResetsUserPasswords;

class ResetUserPassword implements ResetsUserPasswords
{
    use PasswordValidationRules;

    /**
     * Validate and reset the user's forgotten password.
     *
     * @param  array<string, string>  $input
     */
    public function reset(User $user, array $input): void
    {
        Validator::make($input, [
            'password' => $this->passwordRules(),
            // 'password' => ['required', 'string', 'confirmed', 'min:8'],
        ])->validate();

        User::withoutEvents(function () use ($user, $input) {
            $user->forceFill([
                'password' => Hash::make($input['password']),
            ])->save();
        });

        $user->forceFill([
            'password' => Hash::make($input['password']),
        ])->save();
    }
}
