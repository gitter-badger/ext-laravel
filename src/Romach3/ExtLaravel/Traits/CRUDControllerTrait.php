<?php namespace Romach3\ExtLaravel\Traits;

use Romach3\ExtLaravel\Traits\Controller\CRUDTrait;
use Romach3\ExtLaravel\Traits\Controller\PropertyTrait;
use Romach3\ExtLaravel\Traits\Controller\ValidatorTrait;

trait CRUDControllerTrait
{
    use PropertyTrait;
    use CRUDTrait;
    use ValidatorTrait;
}
