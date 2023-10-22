<?php

return [
    'author' => 'Author',
    'merge-tags' => 'Merge tags',
    'app-title' => 'Registration system VŠE',
    'cs' => 'Česky',
    'en' => 'English',
    'app' => 'Application',
    'administration' => 'Administration',
    'homepage' => 'Homepage',
    '403-error-message' => 'You do not have sufficient permissions.',
    'yes' => 'Yes',
    'no' => 'No',

    'actions' => [
        'edit' => 'Edit',
        'duplicate' => 'Duplicate',
        'delete' => 'Delete',
        'save' => 'Save',
        'cancel' => 'Cancel',
        'back' => 'Back',
    ],
    'auth' => [
        'login' => 'Login',
        'login-picker' => 'Choose login',
        'login-error' => 'Invalid login credentials',
        'shibboleth' => 'Shibboleth',
        'graduate-login' => 'Login for graduates',
        'external-login' => 'External login',
        'password' => 'Password',
        'password-confirm' => 'Confirm password',
        'remember_me' => 'Remember login',
        'logout' => 'Log out',
        'register' => 'Sign up',
        'shibboleth-hint' => 'With Shibboleth single sign-on, your user details are the same as for InSIS',
        'graduate-hint' => 'Login through Absolventský portál.',
        'change-password' => 'Change password',
        'current-password' => 'Current password',
        'new-password' => 'New password',
        'new-password-confirm' => 'Confirm new password',
        'password-changed-success' => 'Password changed successfully',
        'password-change-error' => 'Invalid current password.'
    ],
    'blacklist' => [
        'blacklist' => 'Blacklist',
        'user-hint' => 'Enter the xname of each user separated by a comma.<br> e.g.: <br><b>xname00, xname01, xname02, ...</b>',
        'block_reason' => 'Block reason',
        'blocked_until' => 'Blocked until',
        'global-blacklist' => 'Global blacklist',
    ],
    'date' => [
        'date' => 'Date',
        'dates' => 'Dates',
        'list' => 'Date list',
        'date_start' => 'From',
        'date_end' => 'Until',
        'name' => 'Name',
        'enrollment_start' => 'Enrollment from',
        'enrollment_end' => 'Enrollment until',
        'withdraw_end' => 'Withdraw until',
        'capacity' => 'Capacity',
        'from-to' => 'From-To',
        'location' => 'Location'
    ],
    'event' => [
        'events' => 'Events',
        'status' => [
            'status' => 'Status',
            '1' => 'Published',
            '2' => 'Draft',
            '3' => 'Deleted',
        ],
        'type' => [
            'type' => 'Event type',
            '1' => 'A recurring event',
            '2' => 'Related parts of one event'
        ],
        'saved' => 'Event saved',
        'updated' => 'Event updated',
        'deleted' => 'Event deleted',
        'detail' => 'Event detail',
        'create' => 'Create event',
        'edit' => 'Edit event',
        'name' => 'Title',
        'subtitle' => 'Subtitle',
        'event-name' => 'Event title',
        'status-label' => 'Status',
        'participants' => 'Participants',
        'import' => 'Import',
        'show-dates' => 'See dates',
        'show-all-participants' => 'See all participants',
        'delete-date-error' => 'You cannot delete this event. Participants are enrolled for the event.',
        'calendar_id' => 'ID of event in calendar',
        'contact_person' => 'Contact person',
        'contact_email' => 'Contact email',
        'event_blacklist' => 'Event blacklist',
        'user_group' => [
            'user_group' => 'User group',
            '1' => 'Everyone',
            '2' => 'Students',
            '3' => 'Graduates',
            '4' => 'Staff',
            '5' => 'Students and graduates',
        ],
        'enums' => 'Enums'
    ],
    'email' => [
        'email' => 'Email',
        'your-email' => 'Your email',
        'send-test' => 'Send test email',
    ],
    'enrollment' => [
        'enrollment_form' => 'Enrollment formu',
        'list' => 'Participants list',
        'enrolled' => 'Enrolled',
        'c_fields' => 'Custom fields',
        'cannot_enroll' => 'You cannot enroll for this term as you do not meet the application criteria.',
        'my_enrollments' => 'My enrollments',
        'no-enrollments' => 'You do not have any enrollments',
        'state' => [
            'title' => 'Enrollment status',
            '1' => 'Enrolled',
            '2' => 'Substitute',
            '3' => 'Signed off'
        ],
        'sign-out' => 'Sign out of event',
        'signed-off' => 'You have been signed off the date.',
        'sign-off-error' => 'You cannot sign off the date.',
        'enroll-email-success' => 'You have been enrolled successfully',
        'enroll-email-error' => 'Another substitute has already signed up for the date.',
    ],
    'c_fields' => [
        'name' => 'Tag label',
        'type' => 'Type',
        'required' => 'Required',
        'default' => 'Default value',
    ],
    'user' => [
        'first_name' => 'First name',
        'last_name' => 'Surname',
        'email' => 'Email',
        'xname' => 'Xname',
        'users' => 'Users',
        'roles' => 'User role role'
    ],
    'templates' => [
        'template' => 'Template',
        'templates' => 'Templates',
        'name' => 'Template title',
        'approved' => 'Approved',
        'not_approved' => 'Not approved',
        'html' => 'HTML code',
        'default-template' => 'Default template',
        'custom-template' => 'Custom template',
        'content' => 'Content',
        'content-placeholder' => 'Enter text',
        'template-hint' => 'Each template must contain a tag for <code>[message]</code> to insert the content defined in the event',
        'custom-template-hint' => 'Insert a valid HTML template. Template should contain valid HTML and CSS code.',
        'content-missing' => 'Required tag <code>[message]</code> not found in tag.',
        'saved-approval' => 'Template saved, it will be available for use after administrator approval.',
        'deleted' => 'Template deleted.',
        'my-templates' => 'My templates',
        'for-approval' => 'Templates waiting for approval',
        'updated' => 'Template updated',
        'show-content' => 'See template',
        'invalid-html' => 'Invalid HTML code, missing <body> tag.',
        'status' => 'Status',
        'template-create-title' => 'Template create',
        'template-edit-title' => 'Template edit',
        'test-sent-success' => 'Test email sent successfully'
    ],
    'notifications' => [
        'sign_off_title' => 'Sign off title',
        'sign_off' => 'You have been signed off from the date :date, sign off reason :reason.',
        'enrollment_end_title' => 'End of enrollment',
        'enrollment_end' => 'Today is the end of enrolling for the date :date, for the event :event.',
        'enrollment_title' => 'Event enrollment',
        'enrollment_text' => 'You have been successfully enrolled for :event on termín :date.',
        'enrollment_tags' => '\n Here are the details you filled in. :tags',
        'capacity_full_title' => 'Term capacity filled',
        'capacity_full' => 'The capacity on the date :date for the event :event has been filled. Event details and a list of participants can be viewed <a href=":link">here</a>',
        'free_spot_title' => 'Free spot on a term you are registerd as a substitute',
        'free_spot' => 'There was a vacancy for the date :date at the event :event. If you want to sign up click <a href=":link">here</a>.',
        'substitute_signed_title' => 'You have been registered on an term',
        'substitute_signed' => 'You have been registered for the :date for the :event, as you have signed up as a substitute for this date'
    ]
];
