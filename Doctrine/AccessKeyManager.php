<?php

namespace PC\Aws4AuthBundle\Doctrine;

use Doctrine\Common\Persistence\ObjectManager;
use PC\Aws4AuthBundle\Model\AccessKeyInterface;
use PC\Aws4AuthBundle\Model\AccessKeyManager as BaseAccessKeyManager;

class AccessKeyManager extends BaseAccessKeyManager
{
    protected $objectManager;
    protected $class;
    protected $repository;

    public function __construct(ObjectManager $om, $class)
    {
        $this->objectManager = $om;
        $this->repository = $om->getRepository($class);
        $metadata = $om->getClassMetadata($class);
        $this->class = $metadata->getName();
    }

    /**
     * Deletes an Access Key.
     *
     * @param AccessKeyInterface $accessKey
     * @return void
     */
    public function deleteAccessKey(AccessKeyInterface $accessKey)
    {
        $this->objectManager->remove($accessKey);
        $this->objectManager->flush();
    }

    /**
     * Finds one Access Key by the given criteria.
     *
     * @param array $criteria
     * @return AccessKeyInterface
     */
    public function findAccessKeyBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }

    /**
     * Returns the Access Key FQCN.
     *
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }
}
