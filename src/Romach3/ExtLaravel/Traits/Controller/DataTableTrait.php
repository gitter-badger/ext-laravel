<?php namespace Romach3\ExtLaravel\Traits\Controller;

/**
 * Class DataTableTrait
 * @package Core\Traits\Controller
 */
trait DataTableTrait
{
    public function getIndex()
    {
        \Event::fire('crud.view', array($this));
        \Event::fire('crud.index', array($this));
        return \View::make($this->indexTemplate);
    }

    abstract function getDataTable();

    abstract function controller($action = '');

    protected function buttonsClosure()
    {
        return function ($model) {
            $viewUrl = \URL::action($this->controller('getView'), $model->id);
            $deleteUrl = \URL::action($this->controller('getDestroy'), [\Session::token(), $model->id]);
            $editUrl = \URL::action($this->controller('getEdit'), $model->id);
            return "
            <a href='".$viewUrl."' class='btn btn-primary btn-sm'><i class='glyphicon glyphicon-file'></i></a>
            <a href='".$editUrl."' class='btn btn-success btn-sm'><i class='glyphicon glyphicon-pencil'></i></a>
            <a href='".$deleteUrl."' class='btn btn-danger btn-sm core-destroy-link'>
            <i class='glyphicon glyphicon-trash'></i></a>
            ";
        };
    }
}
