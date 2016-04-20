<?php

namespace PC\Aws4AuthBundle\Model;

interface AccessKeyManagerInterface
{
    /**
     * Returns an empty Access Key instance.
     *
     * @param string $accessKey
     * @return AccessKeyInterface
     */
    public function createAccessKey($accessKey);

    /**
     * Deletes an Access Key.
     *
     * @param AccessKeyInterface $accessKey
     * @return void
     */
    public function deleteAccessKey(AccessKeyInterface $accessKey);

    /**
     * Finds one Access Key by the given criteria.
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
     * Returns the Access Key FQCN.
     *
     * @return string
     */
    public function getClass();
}
