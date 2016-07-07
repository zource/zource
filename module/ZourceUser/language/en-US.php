<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

return [
    'accountFormCurrentPassword' => 'Current password',
    'accountFormCurrentPasswordDesc' => 'Your current password.',
    'accountFormNewPassword' => 'New password',
    'accountFormNewPasswordDesc' => 'Your new password.',
    'accountFormConfirmPassword' => 'Confirm password',
    'accountFormConfirmPasswordDesc' => 'Confirm your new password.',
    'accountFormSubmit' => 'Change',

    'addEmailFormAddress' => 'E-mail address',
    'addEmailFormAddressDesc' => 'The e-mail address you would like to add.',
    'addEmailFormSubmit' => 'Add',

    'applicationFormName' => 'Name',
    'applicationFormNameDesc' => 'The name that is displayed to users when they authorize.',
    'applicationFormDescription' => 'Description',
    'applicationFormDescriptionDesc' => 'The description that is displayed to users when they authorize.',
    'applicationFormHomepage' => 'Homepage',
    'applicationFormHomepageDesc' => 'The homepage of the application.',
    'applicationFormRedirectUri' => 'Callback URL',
    'applicationFormRedirectUriDesc' => 'Your application\'s callback URL.',
    'applicationFormSubmit' => 'Save',
    'applicationFormCancel' => 'Cancel',
    'applicationFormDelete' => 'Delete',

    'changeIdentityFormIdentity' => 'Username',
    'changeIdentityFormIdentityDesc' => 'Enter your new username',
    'changeIdentityFormSubmit' => 'Change',

    'layoutTopMenuLogin' => 'Log in',
    'layoutTopMenuProfile' => 'Profile',

    'ldapServerHost' => 'Hostname',
    'ldapServerHostDesc' => 'The hostname to connect to.',
    'ldapServerPort' => 'Port',
    'ldapServerPortDesc' => 'The port number to connect to.',
    'ldapServerUseSsl' => 'Use SSL',
    'ldapServerUseSslDesc' => 'Whether or not to connect over SSL.',
    'ldapServerDnRequired' => 'DN Required',
    'ldapServerDnRequiredDesc' => 'Whether or not the DN is required.',
    'ldapServerBaseDn' => 'Base DN',
    'ldapServerBaseDnDesc' => 'A base dn is the point from where a server will search for users.',
    'ldapServerGroup' => 'Group',
    'ldapServerGroupDesc' => 'The name of the group to search for.',
    'ldapServerGroupDn' => 'Group DN',
    'ldapServerGroupDnDesc' => 'The group dn is the point from where a server will search for groups.',
    'ldapServerGroupScope' => 'Group scope',
    'ldapServerGroupScopeDesc' => 'The scope of the group.',
    'ldapServerGroupScopeSub' => 'Sub',
    'ldapServerGroupScopeOne' => 'One',
    'ldapServerGroupScopeBase' => 'Base',
    'ldapServerGroupAttribute' => 'Group attribute',
    'ldapServerGroupAttributeDesc' => 'Optional group attributes',
    'ldapServerGroupFilter' => 'Group filter',
    'ldapServerGroupFilterDesc' => 'The group filter to apply.',
    'ldapServerMemberAttribute' => 'Member attribute',
    'ldapServerMemberAttributeDesc' => 'The member attribute.',
    'ldapServerMemberIsDn' => 'Member is DN',
    'ldapServerMemberIsDnDesc' => 'Whether or not the memebr is a DN.',
    'ldapServerAccountForm' => 'Account canonical form',
    'ldapServerAccountFormDesc' => 'The canonical form of accounts.',
    'ldapServerAccountFormDn' => 'DN',
    'ldapServerAccountFormUsername' => 'Username',
    'ldapServerAccountFormBackslash' => 'Backslash',
    'ldapServerAccountFormPrincipal' => 'Principal',
    'ldapServerAccountDomainName' => 'Account domain name',
    'ldapServerAccountDomainNameDesc' => 'The account domain name.',
    'ldapServerAccountDomainNameShort' => 'Account domain name (short)',
    'ldapServerAccountDomainNameShortDesc' => 'A short account domain name.',
    'ldapServerAccountFilterFormat' => 'Account filter format',
    'ldapServerAccountFilterFormatDesc' => 'The account filter to apply.',
    'ldapServerAllowEmptyPassword' => 'Allow empty passwords',
    'ldapServerAllowEmptyPasswordDesc' => 'Whether or not accounts can authenticate with empty passwords.',
    'ldapServerUseStartTls' => 'Use StartTls',
    'ldapServerUseStartTlsDesc' => 'Whether or not to use StartTls',
    'ldapServerTimeout' => 'Network timeout',
    'ldapServerTimeoutDesc' => 'The network timeout in seconds.',
    'ldapDirectoryAutoCreateAccount' => 'Create non-existing user',
    'ldapDirectoryAutoCreateAccountDesc' => 'When enabled, non existing accounts will be automatically created.',
    'ldapDirectorySubmit' => 'Save',

    'loginTfaFormTitle' => 'Two-Factor Authentication',
    'loginTfaFormDesc' => 'Open the two-factor authentication app on your device to view your authentication code and verify your identity.',
    'loginTfaFormNoPhone' => 'If you do not have access to your phone, you can enter a recovery code to retrieve access to your account.',

    'loginFormTitle' => 'Login',
    'loginFormRequestPassword' => 'Do you have trouble logging in?',

    'loginFormInputIdentityLabel' => 'Username',
    'loginFormInputIdentityTooltip' => 'Your username',

    'loginFormInputCredentialLabel' => 'Password',
    'loginFormInputCredentialTooltip' => 'Your password',

    'loginFormInputSubmitValue' => 'Login',

    'oAuthAuthorizeFormTitle' => 'Authorize Application',
    'oAuthAuthorizeFormDescription' => 'Are you sure you want to authorize %s?',
    'oAuthAuthorizeFormYes' => 'Yes',
    'oAuthAuthorizeFormNo' => 'No',

    'layoutUserProfileTitle' => 'Profile',

    'pageRequestPasswordTitle' => 'Request Password',

    'pageResetPasswordTitle' => 'Reset Password',

    'resetPasswordFormCode' => 'Code',
    'resetPasswordFormCodeDesc' => 'The reset code of your account.',
    'resetPasswordFormCredential' => 'Password',
    'resetPasswordFormCredentialDesc' => 'Enter your new password.',
    'resetPasswordFormVerification' => 'Verify',
    'resetPasswordFormVerificationDesc' => 'Verify your new password.',
    'resetPasswordFormSubmit' => 'Change',
    'resetPasswordFormCancel' => 'Back to the login screen',

    'pageUserCreateApplicationTitle' => 'Create Application',

    'pageUserUpdateApplicationTitle' => 'Update Application',

    'pageUserApplicationTitle' => 'Applications',

    'pageUserAccountTitle' => 'Account',
    'pageUserChangeIdentityTitle' => 'Change Username',

    'pageUserEmailTitle' => 'Email',
    'pageUserEmailAddDesc' => 'You will receive an e-mail message in your inbox. This message contains a link which you need to click to verify the e-mail address is yours. It\'s always possible to delete unverified e-mail addresses.<br />Adding an e-mail address also means you can use it to login to your account.',
    'pageUserEmailVerified' => 'Verified',
    'pageUserEmailNotVerified' => 'Not verified',

    'pageUserAddEmailTitle' => 'Add Email Address',

    'pageUserVerifyEmailTitle' => 'Verify E-mail Address',
    'pageUserVerifyEmailDesc' => 'Verify e-mail addresses that you have added to your account. The code you need to enter has been sent to your e-mail address.',

    'pageUserNotificationTitle' => 'Notifications',

    'pageUserProfileTitle' => 'Profile',

    'pageUserSecurityTitle' => 'Security',

    'profileFormName' => 'Name',
    'profileFormNameDesc' => 'Your name.',
    'profileFormMiddleName' => 'Middle name',
    'profileFormMiddleNameDesc' => 'Your middle name, this field can also be used for surname prefixes.',
    'profileFormSurname' => 'Surname',
    'profileFormSurnameDesc' => 'Your surname.',
    'profileFormSubmit' => 'Save',

    'requestPasswordFormEmail' => 'E-mail',
    'requestPasswordFormEmailDesc' => 'Your e-mail address',
    'requestPasswordFormSubmit' => 'Send',
    'requestPasswordFormCancel' => 'Did you suddenly remember?',

    'topBarProfileMenuHeader' => 'Profile',
    'topBarProfileMenuLoggedInAsHeader' => 'Logged in as',
    'topBarProfileMenuProfile' => 'Profile',
    'topBarProfileMenuAccount' => 'Account',
    'topBarProfileMenuEmail' => 'E-mails',
    'topBarProfileMenuSecurity' => 'Security',
    'topBarProfileMenuApplications' => 'Applications',
    'topBarProfileMenuLogout' => 'Log out',

    'userSettingsMenuProfile' => 'Profile',
    'userSettingsMenuAccount' => 'Account',
    'userSettingsMenuEmails' => 'E-mails',
    'userSettingsMenuNotifications' => 'Notifications',
    'userSettingsMenuSecurity' => 'Security',
    'userSettingsMenuApplications' => 'Applications',

    'verifyCodeFormCode' => 'Code',
    'verifyCodeFormCodeDesc' => 'Enter the six-digit code from the application.',
    'verifyCodeFormSubmit' => 'Verify',

    'verifyCodeInputFilterCodeMessage' => 'Two-factor authentication failed.',

    'verifyEmailFormCode' => 'Code',
    'verifyEmailFormCodeDesc' => 'The activation code which you can find in the e-mail message.',
    'verifyEmailFormSubmit' => 'Verify',
    'verifyEmailFormCancel' => 'Cancel',
];
