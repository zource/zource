<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceContact\Form\Service;

class CompanyFactory extends AbstractFactory
{
    protected function getConfigKey()
    {
        return 'company';
    }

    protected function getHydratorName()
    {
        return 'ZourceContactCompanyHydrator';
    }

    protected function getInputFilterName()
    {
        return 'ZourceContactCompanyInputFilter';
    }
}
