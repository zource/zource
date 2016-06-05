<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceContact\Entity;

use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="contact_impp_address")
 */
class ImppAddress
{
    const TYPE_ICQ = 'icq';
    const TYPE_SKYPE = 'skype';

    /**
     * @ORM\Id
     * @ORM\Column(type="uuid_binary")
     * @var UuidInterface
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     * @var DateTime
     */
    private $creationDate;

    /**
     * @ORM\ManyToOne(targetEntity="AbstractContact", inversedBy="imppAddresses")
     * @ORM\JoinColumn(onDelete="CASCADE")
     * @var AbstractContact
     */
    private $contact;

    /**
     * @ORM\Column(type="datetime")
     * @var string
     */
    private $type;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $address;

    /**
     * Initializes a new instance of this class.
     *
     * @param AbstractContact $contact The contact to which this IMPP address belongs.
     * @param string $type The IMPP type.
     * @param string $address The IMPP address.
     */
    public function __construct(AbstractContact $contact, $type, $address)
    {
        $this->id = Uuid::uuid4();
        $this->creationDate = new DateTime();
        $this->contact = $contact;
    }

    /**
     * @return UuidInterface
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return DateTimeInterface
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }
}
