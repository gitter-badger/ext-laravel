<?php namespace Romach3\ExtLaravel\Traits;

use Romach3\ExtLaravel\Traits\Controller\CRUDTrait;
use Romach3\ExtLaravel\Traits\Controller\DataTableTrait;
use Romach3\ExtLaravel\Traits\Controller\PropertyTrait;
use Romach3\ExtLaravel\Traits\Controller\ValidatorTrait;

trait DataTableControllerTrait
{
    use PropertyTrait;
    use CRUDTrait;
    use DataTableTrait {
        DataTableTrait::getIndex insteadof CRUDTrait;
    }
    use ValidatorTrait;
}
