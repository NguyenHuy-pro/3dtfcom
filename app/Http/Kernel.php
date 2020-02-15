<?php namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{

    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [

        'Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode',
        'Illuminate\Cookie\Middleware\EncryptCookies',
        'Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse',
        'Illuminate\Session\Middleware\StartSession',
        'Illuminate\View\Middleware\ShareErrorsFromSession',
        'App\Http\Middleware\VerifyCsrfToken',
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => 'App\Http\Middleware\Authenticate',
        'auth.basic' => 'Illuminate\Auth\Middleware\AuthenticateWithBasicAuth',
        'guest' => 'App\Http\Middleware\RedirectIfAuthenticated',

        # middleware of manage
        'ManageMiddleware' => \App\Http\Middleware\Manage\ManageMiddleware::class,
        # === build
        'ManageBuildMiddleware' => \App\Http\Middleware\Manage\ManageBuildMiddleware::class,
        # === end build

        # ==== content ===
        'ManageContentMiddleware' => \App\Http\Middleware\Manage\ManageContentMiddleware::class,

        # system
        'ContentBuildingMiddleware' => \App\Http\Middleware\Manage\ContentBuildingMiddleware::class,

        # system
        'ContentSystemMiddleware' => \App\Http\Middleware\Manage\ContentSystemMiddleware::class,

        # ads
        'ContentAdsMiddleware' => \App\Http\Middleware\Manage\ContentAdsMiddleware::class,

        # design
        'ContentDesignMiddleware' => \App\Http\Middleware\Manage\ContentDesignMiddleware::class,

        # help
        'ContentHelpMiddleware' => \App\Http\Middleware\Manage\ContentHelpMiddleware::class,

        # map
        'ContentMapMiddleware' => \App\Http\Middleware\Manage\ContentMapMiddleware::class,

        # sample
        'ContentSampleMiddleware' => \App\Http\Middleware\Manage\ContentSampleMiddleware::class,

        # user
        'ContentUserMiddleware' => \App\Http\Middleware\Manage\ContentUserMiddleware::class,
        # seller
        'ContentSellerMiddleware' => \App\Http\Middleware\Manage\ContentUserMiddleware::class,
        # ===== end content ====
    ];

}
