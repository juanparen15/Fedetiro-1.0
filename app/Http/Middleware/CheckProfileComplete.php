<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckProfileComplete
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Obtener el nombre de la ruta actual
        $currentRoute = $request->route() ? $request->route()->getName() : null;

        // Si el usuario está autenticado, tiene el correo verificado y el perfil incompleto
        if (
            $user &&
            $user->hasVerifiedEmail() &&
            !$this->profileCompleted($user)  &&
            !$request->ajax()
        ) {
            // Si la ruta es la de edición, permitir el acceso sin redirección adicional
            if (in_array($currentRoute, $this->allowedRoutes())) {
                return $next($request);
            }

            // Si el usuario intenta acceder a otra ruta, redirigir a la página de edición
            return redirect()->route('voyager.users.edit', $user->id)
                ->with('message', 'Por favor, completa tu perfil antes de continuar.');
        }
        
        // Continuar con la petición si el perfil está completo
        return $next($request);
    }

    /**
     * Rutas permitidas donde no se requiere verificar el perfil.
     */
    private function allowedRoutes()
    {
        return [
            'voyager.users.edit',   // Ruta de edición de usuario
            'voyager.users.update', // Ruta de actualización de perfil
            'voyager.voyager_assets',
            'voyager.logout',
        ];
    }
    
    private function profileCompleted($user)
    {
        // Lógica para verificar si el perfil del usuario está completo
        return !is_null($user->primer_nombre) &&
            !is_null($user->primer_apellido) &&
            !is_null($user->movil) &&
            !is_null($user->direccion) &&
            !is_null($user->fecha_nacimiento) &&
            !is_null($user->peso) &&
            !is_null($user->altura) &&
            !is_null($user->entrenador_personal) &&
            !is_null($user->entrenador_nacional) &&
            !is_null($user->inicio_competencia) &&
            !is_null($user->practicando_tiro_desde) &&
            !is_null($user->medico_tramitante) &&
            !is_null($user->lugar_entrenamiento) &&
            !is_null($user->estado_civil) &&
            !is_null($user->genero);
    }
}
