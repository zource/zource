<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceIssue\Validator;

use Zend\Validator\AbstractValidator;

class FieldType extends AbstractValidator
{
    const INVALID_FIELD_TYPE = 'invalidFieldType';

    /**
     * @var array
     */
    protected $messageTemplates = [
        self::INVALID_FIELD_TYPE => 'Invalid field type given.',
    ];

    /**
     * @var array
     */
    private $fieldTypes;

    /**
     * Gets the value of fieldTypes
     *
     * @return array
     */
    public function getFieldTypes()
    {
        return $this->fieldTypes;
    }

    /**
     * Sets the value of fieldTypes
     *
     * @param array $fieldTypes
     */
    public function setFieldTypes($fieldTypes)
    {
        $this->fieldTypes = $fieldTypes;
    }

    /**
     * {@inheritDoc}
     */
    public function isValid($value)
    {
        $fieldTypes = array_column($this->getFieldTypes(), 'id');

        if (!in_array($value, $fieldTypes)) {
            $this->error(self::INVALID_FIELD_TYPE);
            return false;
        }

        $this->setValue($value);

        return true;
    }
}
