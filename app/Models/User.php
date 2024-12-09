<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Request;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends \TCG\Voyager\Models\User implements MustVerifyEmail

{
    use HasApiTokens, HasFactory, HasProfilePhoto, Notifiable, TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        // 'primer_nombre',
        'tipo_documento',
        'username',
        'email',
        'password',
        'documento_tercero',
        'fecha_nacimiento',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function modalidadesArma()
    {
        return $this->belongsToMany(ModalidadArma::class, 'arma_modalidad', 'user_id', 'modalidad_arma_id');
    }

    public function tiposArma()
    {
        return $this->belongsToMany(TipoArma::class, 'arma_modalidad', 'user_id', 'tipo_arma_id');
    }

    public function Municipios()
    {
        return $this->belongsTo(Municipios::class, 'municipios');
    }


    public function Club()
    {
        return $this->belongsTo(Club::class, 'club');
    }

    public function Liga()
    {
        return $this->belongsTo(Liga::class, 'liga');
    }

    // protected static function boot()
    // {
    //     parent::boot();

    //     // Utiliza el evento creating para establecer el campo documento_tercero
    //     static::creating(function ($user) {
    //         // Establece el valor del campo documento_tercero como el nombre de usuario del usuario
    //         $user->documento_tercero = $user->username;
    //     });

    //     // Utiliza el evento creating para establecer el campo documento_tercero
    //     static::updating(function ($user) {
    //         // Establece el valor del campo documento_tercero como el nombre de usuario del usuario
    //         $user->documento_tercero = $user->username;
    //     });
    // }

    protected static function boot()
{
    parent::boot();

    // Utiliza el evento creating para establecer el campo documento_tercero
    static::creating(function ($user) {
        // Si el usuario autenticado NO es administrador, establece el valor del campo documento_tercero como el nombre de usuario
        if (!auth()->user() || !auth()->user()->is_admin) {
            $user->documento_tercero = $user->username;
        }
    });

    // Utiliza el evento updating para evitar que el administrador modifique el campo documento_tercero
    static::updating(function ($user) {
        // Si el usuario autenticado es administrador, no modificar ni borrar el campo documento_tercero
        if (!auth()->user() || !auth()->user()->is_admin) {
            $user->documento_tercero = $user->username;
        }
    });
}


    public function getAgeAttribute()
    {
        return Carbon::parse($this->fecha_nacimiento)->age;
    }

    protected function credentials(Request $request)
    {
        return array_merge($request->only($this->username(), 'password'), ['isActive' => true]);
    }
}
