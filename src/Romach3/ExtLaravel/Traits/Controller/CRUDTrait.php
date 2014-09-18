<?php namespace Romach3\ExtLaravel\Traits\Controller;

/**
 * Class CRUDTrait
 *
 * @package Core\Traits\Controller
 */
trait CRUDTrait
{
    abstract protected function createOrBack($row, $data = null, $passes = null);
    abstract protected function updateOrBack($row, $data = null, $passes = null);
    abstract protected function deleteOrBack($row, $token = null, $passes = 'back');

    public function getIndex()
    {
        \Event::fire('crud.show', array($this));
        \Event::fire('crud.index', array($this));
        if (is_null($this->paginate)) {
            $rows = $this->model->get();
        } else {
            $rows = $this->model->paginate($this->paginate);
        }
        return \View::make($this->indexTemplate, ['rows' => $rows]);
    }

    public function getView($id)
    {
        $this->requestVars = ['id' => $id];
        \Event::fire('crud.show', array($this));
        \Event::fire('crud.view', array($this));
        return \View::make($this->viewTemplate, ['row' => $this->model->findOrFail($id)]);
    }

    public function getCreate()
    {
        \Event::fire('crud.show', array($this));
        \Event::fire('crud.create', array($this));
        return \View::make($this->formTemplate, ['row' => $this->model]);
    }

    public function postStore()
    {
        \Event::fire('crud.action', array($this));
        \Event::fire('crud.store', array($this));
        return $this->createOrBack($this->model);
    }

    public function getEdit($id)
    {
        $this->requestVars = ['id' => $id];
        \Event::fire('crud.show', array($this));
        \Event::fire('crud.edit', array($this));
        return \View::make($this->formTemplate, ['row' => $this->model->findOrFail($id)]);
    }

    public function postUpdate($id)
    {
        \Event::fire('crud.action', array($this));
        \Event::fire('crud.update', array($this));
        return $this->updateOrBack($this->model->findOrFail($id));
    }

    public function getDestroy($token, $id)
    {
        $this->requestVars = ['token' => $token, 'id' => $id];
        \Event::fire('crud.action', array($this));
        \Event::fire('crud.destroy', array($this));
        return $this->deleteOrBack($this->model->findOrFail($id), $token);
    }
}
