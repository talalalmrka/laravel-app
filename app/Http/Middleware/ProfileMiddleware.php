<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProfileMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect(route('login'));
        }
        $user = auth()->user();
        $userToEdit = $request->route('user') ?? $user;
        if (!$user->hasRole('admin') && $user->id !== $userToEdit->id) {
            abort(403, 'You have not permissions.');
        }

        return $next($request);
    }
}
