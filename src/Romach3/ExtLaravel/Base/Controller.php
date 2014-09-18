<?php
namespace Romach3\ExtLaravel\Base;

abstract class Controller extends \BaseController
{
    protected $coreTemplate = [
        'core-stylesheet' => [],
        'core-script' => [],
        'core-body-script' => [],
        'core-body-stylesheet' => [],
    ];

    public function __construct()
    {
        \View::share('crController', $this->controller());
        \View::addNamespace('ExtLaravel', __DIR__.'/../Views');
    }

    protected function controller($action = '')
    {
        if ($action !== '') {
            $action = '@'.$action;
        }
        return substr(\Route::currentRouteAction(), 0, strpos(\Route::currentRouteAction(), '@')).$action;
    }

    protected function getRequestVar($name, $default = null)
    {
        if (isset($this->requestVars) && isset($this->requestVars[$name])) {
            return $this->requestVars[$name];
        }
        return $default;
    }
}
