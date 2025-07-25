<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user()) {
            return redirect()->route('admin.login');
        }
        // if (Gate::allows('order.view')) {
        //     return $next($request);
        // }

        $permissions = Permission::all();
        foreach ($permissions as $permission) {
            if (Gate::allows($permission->slug)) {
                return $next($request);
            }
        }

        abort(403,'Bạn không có quyền truy cập tài nguyên này');
        // return redirect('/')->with('error', 'You do not have admin access.');

        // if (request()->user()->role_id != 1) {
        //     return redirect('/')->with('error', 'You do not have admin access.');
        // }
        // return $next($request);
    }
}
