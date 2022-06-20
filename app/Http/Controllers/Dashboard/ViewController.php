<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class ViewController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return Application|Factory|View
     */
    public function __invoke()
    {
        return view('layout')->with([
            'jsVars' => [
                'languageCodes' => availableLanguageCodes(),
                'maxUpload' => config('dashboard.upload_filesize'),
                'path' => dashboardPath(),
                'roles' => availableRoles(),
                'timezone' => config('app.timezone'),
                'translations' => availableTranslations(request()->user()->locale),
                'unsplash' => config('dashboard.unsplash.access_key'),
                'user' => request()->user(),
            ],
        ]);
    }
}
