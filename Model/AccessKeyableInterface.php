<?php

namespace PC\Aws4AuthBundle\Model;

interface AccessKeyableInterface
{
    /**
     * Gets the access keys granted to the user.
     *
     * @return \Traversable
     */
    public function getAccessKeys();
    
    /**
     * Add a group to the user groups.
     *
     * @param AccessKeyInterface $accessKey
     * @return self
     */
    public function addAccessKey(AccessKeyInterface $accessKey);

    /**
     * Remove a group from the user groups.
     *
     * @param AccessKeyInterface $accessKey
     * @return self
     */
    public function removeAccessKey(AccessKeyInterface $accessKey);
}
