<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceContact\Fixture;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Zend\Math\Rand;
use ZourceContact\Entity\AbstractContact;
use ZourceContact\Entity\Company as CompanyEntity;
use ZourceContact\Entity\Person as PersonEntity;

class Contact implements FixtureInterface, OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 100; ++$i) {
            if ($i % 2 === 0) {
                $contact = new CompanyEntity('Company ' . $i);
                $this->populateCompany($contact);
            } else {
                $contact = new PersonEntity('Name', $i);
                $this->populatePerson($contact);
            }

            $this->populateGeneral($contact);

            $manager->persist($contact);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }

    private function populateGeneral(AbstractContact $contact)
    {
        $contact->setNotes('This is a note for this contact.');

        if (Rand::getFloat(true) < 0.8) {
            $contact->setDisplayName(Rand::getString(32));
        }
    }

    private function populateCompany(CompanyEntity $company)
    {
    }

    private function populatePerson(PersonEntity $person)
    {
        $genders = [0, 1, 2, 9];
        $gender = $genders[Rand::getInteger(0, count($genders) - 1)];

        $person->setGender($gender);
        $person->setJobTitle('Software Engineer');
        $person->setDepartment('Department');

        if ($gender === 2) {
            $person->setMaidenName('Maiden name');
        }
        
        $person->setNickname('Nickname');
        $person->set
    }
}
