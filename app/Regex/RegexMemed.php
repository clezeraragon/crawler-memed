<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 22/06/18
 * Time: 17:12
 */

namespace Memed\Regex;



class RegexMemed extends AbstractRegex
{

    public function capturaToken($page_acesso)
    {
        $regex = '/"token.:.(.*?)"/';
        return $this->regexFirst($regex, $page_acesso, 0);
    }

    public function capturaLinks($page_acesso)
    {
        $regex = '/(.*?)page\[offset\]=/';
        return $this->regexFirst($regex, $page_acesso, 0);
    }



}