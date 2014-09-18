<?php
namespace Romach3\ExtLaravel\Traits\Controller;

trait PropertyTrait {
    /** @var \Eloquent */
    protected $model;
    protected $indexTemplate;
    protected $formTemplate;
    protected $viewTemplate;
    protected $paginate = null;
    protected $breadcrumbs = [];
    protected $requestVars = [];
}
