<?php

namespace PC\Aws4AuthBundle\Model;

/**
 * Abstract Access Key Manager implementation which can be used as base class for a custom manager.
 *
 * @author Peter Culka
 */
abstract class AccessKeyManager implements AccessKeyManagerInterface
{
    /**
     * {@inheritDoc}
     */
    public function createAccessKey($name)
    {
        $class = $this->getClass();
        return new $class($name);
    }

    /**
     * {@inheritDoc}
     */
    public function findAccessKeyByKey($key)
    {
        return $this->findAccessKeyBy(array('key' => $key));
    }
}
