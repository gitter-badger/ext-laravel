<?php
namespace Romach3\ExtLaravel\Base;

use Romach3\ExtLaravel\Traits\Model\ValidatorTrait;

abstract class Model extends \Eloquent
{
    use ValidatorTrait;
}
