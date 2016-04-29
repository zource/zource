<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceIssue\V1\Rest\FieldType;

/**
 * The representation of a field type.
 */
class FieldTypeEntity
{
    /**
     * The id of the field type.
     *
     * @var string
     */
    private $id;

    /**
     * The name of the field type.
     *
     * @var string
     */
    private $name;

    /**
     * The description of the field type.
     *
     * @var string
     */
    private $description;

    public function __construct($id, $name, $description)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
    }

    /**
     * Gets the value of id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Gets the value of name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Gets the value of description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}
