<?php

namespace App\Seo;
//use Sonata\Exporter\Source\SourceIteratorInterface;
use Sonata\Exporter\Source\SourceIteratorInterface ;
//use sonata-project\exporter\SourceIteratorInterface;

class SiteMape implements SourceIteratorInterface 
{
    protected $key;

    protected $stop;

    protected $current;

    public function __construct($stop = 1000)
    {
        $this->stop = $stop;
    }

    public function current()
    {
        return $this->current;
    }

    public function next()
    {
        $this->key++;
        $this->current = [
            'url'  => '/the/path/to/target',
            'lastmod'    => '01.01.2020',
            'changefreq' => 'weekly',
            'priority'   => 0.5
        ];
    }

    public function key()
    {
        return $this->key;
    }

    public function valid()
    {
        return $this->key < $this->stop;
    }

    public function rewind()
    {
        $this->key = 0;
    }
}