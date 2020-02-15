<?php namespace App\Http\Middleware\Manage;

use Closure;
use Illuminate\Http\Response;
use App\Models\Manage\Content\System\Staff\TfStaff;

class ContentSystemMiddleware
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
        $loginStaffId = $modelStaff->loginStaffID();
        $accessStatus = false;
        if ($modelStaff->checkLogin()) {
            if ($modelStaff->checkDepartmentSystem($loginStaffId)) {
                $accessStatus = true;
            }
        }
        if ($accessStatus) {
            return $next($request);
        } else {
            return new Response(view('manage.content.components.access-notify'));
        }
    }

}
