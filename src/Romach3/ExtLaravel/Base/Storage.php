<?php
namespace Romach3\ExtLaravel\Base;

use \Illuminate\Support\Collection;

abstract class Storage extends Collection
{
    protected $file;
    protected $prettyPrint = false;

    public function __construct()
    {
        $this->loadStorage();
    }

    public function __destruct()
    {
        $this->saveStorage();
    }

    private function loadStorage()
    {
        $this->items = null;
        if (is_file($this->file)) {
            $this->items = json_decode(file_get_contents($this->file), true);
        }
        if (is_null($this->items)) {
            $this->items = [];
        }
    }

    public function saveStorage()
    {
        if ($this->prettyPrint) {
            $json = json_encode($this->items, JSON_PRETTY_PRINT);
        } else {
            $json = json_encode($this->items);
        }
        file_put_contents($this->file, $json);
    }
}
