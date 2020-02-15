<?php namespace App\Http\Middleware\Manage;

use Closure;
use Illuminate\Http\Response;
use App\Models\Manage\Content\System\Staff\TfStaff;

class ManageBuildMiddleware {

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
		if($modelStaff->checkLogin()) {
			$loginStaffId = $modelStaff->loginStaffId();
			if($modelStaff->checkDepartmentBuild($loginStaffId)) {
				return $next($request);
			}
			else
			{
				return new Response(view('manage.content.components.access-notify'));
			}
		}
		else
		{
			return new Response(view('manage.login.login-form'));
		}

	}

}
