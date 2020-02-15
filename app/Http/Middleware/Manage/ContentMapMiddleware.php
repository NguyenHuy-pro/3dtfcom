<?php namespace App\Http\Middleware\Manage;
use Illuminate\Http\Response;
use App\Models\Manage\Content\System\Staff\TfStaff;
use Closure;

class ContentMapMiddleware {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$modelStaff = new TfStaff();

		$accessStatus = false;
		if($modelStaff->checkLogin()){
			$loginStaffId = $modelStaff->loginStaffID();
			if ($modelStaff->checkDepartmentBuild($loginStaffId)) {
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
