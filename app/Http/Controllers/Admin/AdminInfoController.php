<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\DomCrawler\Crawler;

class AdminInfoController extends AdminController
{
    protected $pregRoutesExcept = '/^(_|team)/i';

    public function routes(Request $request)
    {
        $routeName = $request->input('routeName');
        $data = collect([]);
        /**
         * @var $route \Illuminate\Routing\Route
         */
        foreach(Route::getRoutes() as $route) {
            if(!preg_match($this->pregRoutesExcept, $route->uri) ) {
                $data->push($route);
            }
        }

        if($routeName) {
            $data = $data->filter(
                function ($item) use ($routeName) {
                    return (isset($item->action['as']) && false !== stristr($item->action['as'], $routeName));
                }
            );
        }
        return view('admin.infos.routes', compact('data', 'routeName'));
    }

    public function phpinfo()
    {
        ob_start();
        phpinfo();
        $phpinfo = ob_get_contents();
        ob_end_clean();
        $crawler = new Crawler($phpinfo);
        $phpinfo = $crawler->filter('body > div')->first()->html();
        return view('admin.infos.phpinfo', compact('phpinfo'));
    }
}
