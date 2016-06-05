<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceContact\TaskService;

use Ramsey\Uuid\Uuid;
use Sabre\VObject\Component\VCard;
use ZourceContact\Entity\Company;
use ZourceContact\Entity\Person;

class VCardBuilder
{
    const VERSION = '1.0';
    const DATE_FORMAT = 'Ymd\THis\Z';

    public function buildCompany(Company $company)
    {
        $data = [];
        $data['REV'] = $person->getLastUpdated()->format(self::DATE_FORMAT);
        $data['KIND'] = 'organization';

        return $this->buildObject($data);
    }

    public function buildPerson(Person $person)
    {
        $data = [];
        $data['REV'] = $person->getLastUpdated()->format(self::DATE_FORMAT);
        $data['FN'] = $person->getFullName();
        $data['KIND'] = 'individual';
        $data['N'] = [$person->getFirstName(), $person->getLastName()];

        //if ($person->getDateOfBirth() !== null) {
        //    $data['BDAY'] = $person->getDateOfBirth()->format('Ymd');
        //}

        $data['BIRTHPLACE'] = '';
        $data['DEATHDATE'] = '';
        $data['DEATHPLACE'] = '';
        $data['IMPP:aim'] = 'johndoe@aol.com';

        switch ($person->getGender()) {
            case Person::GENDER_FEMALE:
                $data['GENDER'] = 'F';
                break;

            case Person::GENDER_MALE:
                $data['GENDER'] = 'M';
                break;

            default:
                break;
        }

        if ($person->getNickname() !== null) {
            $data['NICKNAME'] = $person->getNickname();
        }

        if ($person->getNotes() !== null) {
            $data['NOTE'] = $person->getNotes();
        }

        //if ($person->getRole() !== null) {
        //    $data['ROLE'] = $person->getRole();
        //}

        $data['TEL;TYPE=cell'] = '(123) 555-5832';

        return $this->buildObject($data);
    }

    private function buildObject(array $data)
    {
        $data['PRODID'] = '-//Zource//Zource VObject ' . self::VERSION . '//EN';
        $data['UID'] = 'zource-vobject-' . Uuid::uuid4()->toString();
        $data['CLASS'] = 'public';

        return new VCard($data);
    }
}
