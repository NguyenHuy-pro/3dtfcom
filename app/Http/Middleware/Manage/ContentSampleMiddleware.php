<?php namespace App\Http\Middleware\Manage;

use Closure;
use Illuminate\Http\Response;
use App\Models\Manage\Content\System\Staff\TfStaff;

class ContentSampleMiddleware
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
        $accessStatus = false;
        if($modelStaff->checkLogin()){
            $loginStaffId = $modelStaff->loginStaffID();
            if ($modelStaff->checkDepartmentDesign($loginStaffId)) {
                $accessStatus = true;
            } elseif ($modelStaff->checkDepartmentSystem($loginStaffId)) {
                if ($modelStaff->loginStaffInfo('level') == 1) $accessStatus = true;
            }
        }

        if ($accessStatus) {
            return $next($request);
        } else {
            return new Response(view('manage.content.components.access-notify'));
        }
    }

}
