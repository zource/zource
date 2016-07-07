<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\Form\Element;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Ldap\Ldap;

class LdapServer extends Fieldset implements InputFilterProviderInterface
{
    public function init()
    {
        $this->addText('host', 'ldapServerHost', 'ldapServerHostDesc');
        $this->addText('port', 'ldapServerPort', 'ldapServerPortDesc');
        $this->addCheckbox('useSsl', 'ldapServerUseSsl', 'ldapServerUseSslDesc');

        $this->addCheckbox('bindRequiresDn', 'ldapServerDnRequired', 'ldapServerDnRequiredDesc');
        $this->addText('baseDn', 'ldapServerBaseDn', 'ldapServerBaseDnDesc');

        $this->addText('group', 'ldapServerGroup', 'ldapServerGroupDesc');
        $this->addText('groupDn', 'ldapServerGroupDn', 'ldapServerGroupDnDesc');

        $this->addSelect('groupScope', 'ldapServerGroupScope', 'ldapServerGroupScopeDesc', [
            Ldap::SEARCH_SCOPE_SUB => 'ldapServerGroupScopeSub',
            Ldap::SEARCH_SCOPE_ONE => 'ldapServerGroupScopeOne',
            Ldap::SEARCH_SCOPE_BASE => 'ldapServerGroupScopeBase',
        ], '');

        $this->addText('groupAttr', 'ldapServerGroupAttribute', 'ldapServerGroupAttributeDesc');
        $this->addText('groupFilter', 'ldapServerGroupFilter', 'ldapServerGroupFilterDesc');

        $this->addText('memberAttr', 'ldapServerMemberAttribute', 'ldapServerMemberAttributeDesc');
        $this->addCheckbox('memberIsDn', 'ldapServerMemberIsDn', 'ldapServerMemberIsDnDesc');

        $this->addSelect('accountCanonicalForm', 'ldapServerAccountForm', 'ldapServerAccountFormDesc', [
            Ldap::ACCTNAME_FORM_DN => 'ldapServerAccountFormDn',
            Ldap::ACCTNAME_FORM_USERNAME => 'ldapServerAccountFormUsername',
            Ldap::ACCTNAME_FORM_BACKSLASH => 'ldapServerAccountFormBackslash',
            Ldap::ACCTNAME_FORM_PRINCIPAL => 'ldapServerAccountFormPrincipal',
        ], '');

        $this->addText('accountDomainName', 'ldapServerAccountDomainName', 'ldapServerAccountDomainNameDesc');
        $this->addText('accountDomainNameShort', 'ldapServerAccountDomainNameShort', 'ldapServerAccountDomainNameShortDesc');
        $this->addText('accountFilterFormat', 'ldapServerAccountFilterFormat', 'ldapServerAccountFilterFormatDesc');

        $this->addCheckbox('allowEmptyPassword', 'ldapServerAllowEmptyPassword', 'ldapServerAllowEmptyPasswordDesc');
        $this->addCheckbox('useStartTls', 'ldapServerUseStartTls', 'ldapServerUseStartTlsDesc');

        $this->addText('networkTimeout', 'ldapServerTimeout', 'ldapServerTimeoutDesc', 5);
    }

    private function addText($name, $label, $description, $defaultValue = '')
    {
        $this->add([
            'type' => 'Text',
            'name' => $name,
            'options' => [
                'label' => $label,
                'description' => $description,
            ],
            'attributes' => [
                'value' => $defaultValue,
            ],
        ]);
    }

    private function addCheckbox($name, $label, $description, $defaultValue = '')
    {
        $this->add([
            'type' => 'Checkbox',
            'name' => $name,
            'options' => [
                'label' => $label,
                'description' => $description,
            ],
            'attributes' => [
                'value' => $defaultValue,
            ],
        ]);
    }

    private function addSelect($name, $label, $description, $options, $defaultValue = '')
    {
        $this->add([
            'type' => 'Select',
            'name' => $name,
            'options' => [
                'description' => $description,
                'label' => $label,
                'empty_option' => '---',
                'value_options' => $options,
            ],
            'attributes' => [
                'value' => $defaultValue,
            ],
        ]);
    }

    public function getInputFilterSpecification()
    {
        return [
            'host' => [
                'required' => true,
            ],
            'port' => [
                'required' => true,
            ],
            'useSsl' => [
                'required' => false,
            ],
            'baseDn' => [
                'required' => true,
            ],
            'bindRequiresDn' => [
                'required' => false,
            ],
            'groupScope' => [
                'required' => false,
            ],
            'accountCanonicalForm' => [
                'required' => false,
            ],
        ];
    }
}
