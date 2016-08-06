<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\TaskService;

use Doctrine\ORM\EntityManager;
use DoctrineModule\Paginator\Adapter\Selectable;
use Zend\Paginator\Paginator;
use ZourceApplication\Entity\Gadget as GadgetEntity;
use ZourceApplication\Entity\GadgetContainer;
use ZourceUser\Entity\AccountInterface;

class Gadget
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var array
     */
    private $availableGadgets;

    public function __construct(EntityManager $entityManager, $availableGadgets)
    {
        $this->entityManager = $entityManager;
        $this->availableGadgets = $availableGadgets;
    }

    public function find($id)
    {
        $repository = $this->entityManager->getRepository(GadgetEntity::class);

        return $repository->find($id);
    }

    public function findContainer($id)
    {
        $repository = $this->entityManager->getRepository(GadgetContainer::class);

        return $repository->find($id);
    }

    public function findAll()
    {
        $repository = $this->entityManager->getRepository(GadgetEntity::class);

        return $repository->findAll();
    }

    public function getGadgetCategories()
    {
        $result = [];

        foreach ($this->availableGadgets as $gadget) {
            $category = $gadget['category'];

            if (!array_key_exists($category, $result)) {
                $result[$category] = [
                    'key' => preg_replace('/[^a-z0-9]+/i', '-', $category),
                    'label' => $category,
                    'gadgetCount' => 0,
                ];
            }

            $result[$category]['gadgetCount']++;
        }

        return $result;
    }

    public function getAvailableGadgets()
    {
        return $this->availableGadgets;
    }

    public function getPaginator()
    {
        $repository = $this->entityManager->getRepository(GadgetEntity::class);

        $adapter = new Selectable($repository);

        return new Paginator($adapter);
    }

    public function getContainerPaginator()
    {
        $repository = $this->entityManager->getRepository(GadgetContainer::class);

        $adapter = new Selectable($repository);

        return new Paginator($adapter);
    }

    public function updateGadgetContainer(GadgetContainer $gadgetContainer, array $data)
    {
        $gadgets = [];

        if (array_key_exists('layout', $data)) {
            $gadgetContainer->setLayout($data['layout']);
        }

        if (array_key_exists('gadgets', $data)) {
            foreach ($data['gadgets'] as $gadget) {
                $gadgetEntity = null;

                if ($gadget['id']) {
                    $gadgetEntity = $gadgetContainer->getGadget($gadget['id']);
                }

                if (!$gadgetEntity) {
                    $gadgetEntity = new GadgetEntity($gadgetContainer, $gadget['type']);
                }

                $gadgetEntity->setColumn($gadget['column']);
                $gadgetEntity->setPosition($gadget['position']);

                $this->entityManager->persist($gadgetEntity);

                $gadgets[] = $gadgetEntity;
            }
        }

        $this->entityManager->flush();

        $result = [];
        foreach ($gadgets as $gadget) {
            $result[] = $gadget->getId()->toString();
        }
        return $result;
    }

    public function persist(GadgetEntity $dashboard)
    {
        $this->entityManager->persist($dashboard);
        $this->entityManager->flush($dashboard);
    }

    public function persistFromArray(AccountInterface $account, $data)
    {
        $dashboard = new GadgetEntity($account, $data['name']);

        $this->persist($dashboard);
    }

    public function remove(GadgetEntity $dashboard)
    {
        $this->entityManager->remove($dashboard);
        $this->entityManager->flush($dashboard);
    }
}
