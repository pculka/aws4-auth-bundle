<?php

namespace PC\Aws4AuthBundle\Model;

interface AccessKeyManagerInterface
{
    /**
     * Returns an empty group instance.
     *
     * @param string $accessKey
     * @return AccessKeyInterface
     */
    public function createAccessKey($accessKey);

    /**
     * Deletes a group.
     *
     * @param AccessKeyInterface $accessKey
     * @return void
     */
    public function deleteAccessKey(AccessKeyInterface $accessKey);

    /**
     * Finds one group by the given criteria.
     *
     * @param array $criteria
     * @return AccessKeyInterface
     */
    public function findAccessKeyBy(array $criteria);

    /**
     * Finds an Access Key by Key value.
     *
     * @param string $key
     * @return AccessKeyInterface
     */
    public function findAccessKeyByKey($key);

    /**
     * Returns the AccessKey's fully qualified class name.
     *
     * @return string
     */
    public function getClass();
}
