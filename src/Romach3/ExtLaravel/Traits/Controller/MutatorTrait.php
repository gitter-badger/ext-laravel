<?php
namespace Romach3\ExtLaravel\Traits\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * trait MutatorTrait
 * Мутирует контроллер исходя из параметров запроса.
 * Первый аргумент принимается за название контроллера, второй за метод, остальное - параметры.
 * Свойства контроллера $this->any устанавливаются исходя из массива возвращаемого методом
 * mutatorGetParams() - array(controllerName => [[property => value]...])
 * @package Core\Traits\Controller
 */
trait MutatorTrait {

    abstract public function callAction($method, $parameters);
    abstract protected function mutatorGetParams();

    public final function missingMethod($parameters = array())
    {
        $count = count($parameters);
        if ($count === 0) {
            throw new NotFoundHttpException("Controller method not found.");
        }
        $this->setController(array_shift($parameters));
        $method = $this->getMethod($count, array_shift($parameters));
        if (method_exists($this, $method)) {
            return $this->callAction($method, $parameters);
        }
        throw new NotFoundHttpException("MutatorTrait: Controller method not found.");
    }

    /**
     * Устанавливает свойства объекту контроллера
     * @param $controllerName
     */
    private function setController($controllerName)
    {
        $controllers = $this->mutatorGetParams();
        if (!isset($controllers[$controllerName])) {
            throw new NotFoundHttpException("MutatorTrait: Controller not found.");
        }
        $params = $controllers[$controllerName];
        foreach ($params as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * Получает название метода контроллера
     * @param $count
     * @param $method
     * @return string
     */
    private function getMethod($count, $method)
    {
        if ($count > 1) {
            return camel_case(\Request::method() . '_' . $method);
        }
        return camel_case(\Request::method() . '_' . 'index');
    }
}
