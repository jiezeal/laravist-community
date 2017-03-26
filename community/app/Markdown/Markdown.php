<?php
/**
 * Created by PhpStorm.
 * User: zhulinjie
 * Date: 2017/3/6
 * Time: 21:45
 */

namespace App\Markdown;


class Markdown
{
    protected $parser;

    /**
     * Markdown constructor.
     * @param $parser
     */
    public function __construct(Parser $parser)
    {
        $this->parser = $parser;
    }

    /**
     * @param $text
     * @return string
     */
    public function markdown($text){
        $html = $this->parser->makeHtml($text);
        return $html;
    }
}