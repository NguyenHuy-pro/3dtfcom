<?php namespace App\Http\Middleware\Manage;

use App\Models\Manage\Content\System\Staff\TfStaff;
use Closure;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Response;

class ManageMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $modelStaff = new TfStaff();
        # action content
        return $next($request);

    }

}
