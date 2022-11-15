<?php


namespace App\Message;


use App\Entity\Source;

class NewsParser
{

    private Source $source;

    public function __construct(Source $source)
    {
        $this->source = $source;
    }

    public function getContent(): Source
    {
        return $this->source;
    }
}