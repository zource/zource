<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\Rest;

use Doctrine\ORM\EntityManager;
use DoctrineModule\Paginator\Adapter\Selectable;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Exception;
use stdClass;
use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;

class AbstractDoctrineListener extends AbstractResourceListener
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * Initializes a new instance of this class.
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Gets the entity manager used to communicate with Doctrine ORM.
     *
     * @return EntityManager
     */
    protected function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * {@inheritDoc}
     */
    public function create($data)
    {
        $data = $this->convertData($data);

        $entityClass = $this->getEntityClass();

        $reflection = new \ReflectionClass($entityClass);
        $constructor = $reflection->getConstructor();

        if ($constructor) {
            $arguments = [];
            $dataArray = (array)$data;

            foreach ($constructor->getParameters() as $parameter) {
                if (array_key_exists($parameter->getName(), $dataArray)) {
                    $arguments[$parameter->getName()] = $dataArray[$parameter->getName()];
                } else {
                    $arguments[$parameter->getName()] = null;
                }
            }

            $entity = $reflection->newInstanceArgs($arguments);
        } else {
            $entity = new $entityClass;
        }

        $hydrator = new DoctrineObject($this->entityManager, true);
        $entity = $hydrator->hydrate((array)$data, $entity);

        $this->entityManager->beginTransaction();

        try {
            $this->entityManager->persist($entity);
            $this->entityManager->flush($entity);

            $this->entityManager->commit();
        } catch (Exception $e) {
            $this->entityManager->rollback();
            return new ApiProblem(500, $e);
        }

        return $entity;
    }

    /**
     * Delete a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        $repository = $this->entityManager->getRepository($this->getEntityClass());
        $entity = $repository->find($id);

        if (!$entity) {
            return new ApiProblem(404, 'The entity could not be found.');
        }

        $this->entityManager->beginTransaction();

        try {
            $this->entityManager->remove($entity);
            $this->entityManager->flush($entity);

            $this->entityManager->commit();
        } catch (Exception $e) {
            $this->entityManager->rollback();
            return new ApiProblem(500, $e);
        }

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function deleteList($data)
    {
        $repository = $this->entityManager->getRepository($this->getEntityClass());

        $this->entityManager->beginTransaction();

        try {
            $qb = $repository->createQueryBuilder('e');
            $qb->delete();
            $qb->where($qb->expr()->in('e.id', ':idList'));
            $qb->getQuery()->execute([
                'idList' => $data,
            ]);

            $this->entityManager->commit();
            $result = true;
        } catch (Exception $e) {
            $result = new ApiProblem(500, $e);
            $this->entityManager->rollback();
        }

        return $result;
    }

    /**
     * {@inheritDoc}
     */
    public function fetch($id)
    {
        $repository = $this->entityManager->getRepository($this->getEntityClass());

        return $repository->find($id);
    }

    /**
     * {@inheritDoc}
     */
    public function fetchAll($params = array())
    {
        $repository = $this->entityManager->getRepository($this->getEntityClass());

        $adapter = new Selectable($repository);

        $collectionFqcn = $this->getCollectionClass();

        return new $collectionFqcn($adapter);
    }

    /**
     * {@inheritDoc}
     */
    public function patch($id, $data)
    {
        $data = $this->convertData($data);

        $repository = $this->entityManager->getRepository($this->getEntityClass());
        $entity = $repository->find($id);

        $hydrator = new DoctrineObject($this->entityManager, true);
        $entity = $hydrator->hydrate((array)$data, $entity);

        $this->entityManager->beginTransaction();

        try {
            $this->entityManager->persist($entity);
            $this->entityManager->flush($entity);

            $this->entityManager->commit();
        } catch (Exception $e) {
            $this->entityManager->rollback();
            return new ApiProblem(500, $e);
        }

        return $entity;
    }

    /**
     * {@inheritDoc}
     */
    public function patchList($data)
    {
        $dataList = [];
        array_walk($data, function ($entry) use (&$dataList) {
            $entry = (array)$entry;

            $dataList[$entry['id']] = $entry;
        });


        $repository = $this->entityManager->getRepository($this->getEntityClass());

        $qb = $repository->createQueryBuilder('e');
        $qb->select();
        $qb->where($qb->expr()->in('e.id', ':idList'));
        $qb->setParameter('idList', array_keys($dataList));
        $entities = $qb->getQuery()->getResult();

        $this->entityManager->beginTransaction();

        try {
            $hydrator = new DoctrineObject($this->entityManager, true);

            foreach ($entities as $key => $entity) {
                $entity = $hydrator->hydrate($dataList[$entity->getId()], $entity);

                $this->entityManager->persist($entity);
            }

            $this->entityManager->flush();
            $this->entityManager->commit();

            $result = $entities;
        } catch (Exception $e) {
            $result = new ApiProblem(500, $e);
            $this->entityManager->rollback();
        }

        return $result;
    }

    /**
     * {@inheritDoc}
     */
    public function replaceList($data)
    {
        $dataList = [];
        array_walk($data, function ($entry) use (&$dataList) {
            $dataList[$entry->id] = (array)$entry;
        });

        $repository = $this->entityManager->getRepository($this->getEntityClass());

        $qb = $repository->createQueryBuilder('e');
        $qb->select();
        $qb->where($qb->expr()->in('e.id', ':idList'));
        $qb->setParameter('idList', array_keys($dataList));
        $entities = $qb->getQuery()->getResult();

        $this->entityManager->beginTransaction();

        try {
            $hydrator = new DoctrineObject($this->entityManager, true);

            foreach ($entities as $key => $entity) {
                $entity = $hydrator->hydrate($dataList[$entity->getId()], $entity);

                $this->entityManager->persist($entity);
            }

            $this->entityManager->flush();
            $this->entityManager->commit();

            $result = $entities;
        } catch (Exception $e) {
            $result = new ApiProblem(500, $e);
            $this->entityManager->rollback();
        }

        return $result;
    }

    /**
     * {@inheritDoc}
     */
    public function update($id, $data)
    {
        $data = $this->convertData($data);

        $repository = $this->entityManager->getRepository($this->getEntityClass());
        $entity = $repository->find($id);

        $hydrator = new DoctrineObject($this->entityManager, true);
        $entity = $hydrator->hydrate((array)$data, $entity);

        $this->entityManager->beginTransaction();

        try {
            $this->entityManager->persist($entity);
            $this->entityManager->flush($entity);

            $this->entityManager->commit();
        } catch (Exception $e) {
            $this->entityManager->rollback();

            return new ApiProblem(500, $e);
        }

        return $entity;
    }

    /**
     * Converts the given data into the correct format.
     * Hydrators are preferred but this method can give extended flexibility.
     *
     * @param stdClass $data
     * @return stdClass
     */
    protected function convertData($data)
    {
        return $data;
    }
}
