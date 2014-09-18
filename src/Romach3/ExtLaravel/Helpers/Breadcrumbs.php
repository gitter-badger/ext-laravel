<?php namespace Romach3\ExtLaravel\Helpers;

class Breadcrumbs
{
    protected static $items = [];

    /**
     * @param $array [url, title] or [[url, title]...]
     */
    public static function add($array)
    {
        if (is_array($array[0])) {
            foreach ($array as $row) {
                self::addItem($row[0], $row[1]);
            }
        } else {
            self::addItem($array[0], $array[1]);
        }
    }

    /**
     * Get all breadcrumbs
     * @return array
     */
    public static function all()
    {
        return self::$items;
    }

    /**
     * Replace breadcrumbs array
     * @param $items
     */
    public static function replace($items)
    {
        self::$items = $items;
    }

    /**
     * Render Breadcrumbs view
     */
    public static function render()
    {
        $items = self::all();
        if (count($items) === 0) {
            return '';
        }
        $active = array_pop($items);
        return \View::make('Core::Breadcrumbs.bootstrap3', ['items' => $items, 'active' => $active])->render();
    }

    public static function make($bc, $current, $share = false)
    {
        if (!isset($bc[$current])) {
            return;
        }
        if (isset($bc['start'])) {
            self::add($bc['start']);
        }
        self::add($bc[$current]);
        if ($share) {
            \View::share('Breadcrumbs', Breadcrumbs::render());
        }
    }

    private static function addItem($url, $title)
    {
        $row = new \StdClass;
        $row->url = $url;
        $row->title = $title;
        self::$items[] = $row;
    }
}
