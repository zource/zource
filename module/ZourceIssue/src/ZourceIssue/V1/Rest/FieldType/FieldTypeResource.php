<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceIssue\V1\Rest\FieldType;

use Zend\Paginator\Adapter\ArrayAdapter;
use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;

class FieldTypeResource extends AbstractResourceListener
{
    /**
     * @var array
     */
    private $config;

    /**
     * Initializes a new instance of this class.
     *
     * @param array $config The configuration of the field types.
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function fetch($id)
    {
        foreach ($this->config as $fieldType) {
            if ($fieldType['id'] === $id) {
                return $fieldType;
            }
        }

        return null;
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = array())
    {
        $adapter = new ArrayAdapter($this->config);

        return new FieldTypeCollection($adapter);
    }
}
