<?php
/**
 * Created by PhpStorm.
 * User: Peter
 * Date: 20.04.2016
 * Time: 10:34
 */

namespace PC\Aws4AuthBundle\Model;

interface AccessKeyInterface
{
    public function getAccessKey();
    public function getSecretKey();
    public function getScope();
}
