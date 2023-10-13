<?php

return [
    'author' => 'Autor',
    'merge-tags' => 'Merge tagy',
    'app-title' => 'Registrační systém VŠE',
    'login-picker' => 'Výběr přihlášení',
    'cs' => 'Česky',
    'en' => 'English',
    'app' => 'Aplikace',
    'administration' => 'Administrace',
    'homepage' => 'Hlavní stránka',

    'actions' => [
        'edit' => 'Editovat',
        'duplicate' => 'Duplikovat',
        'delete' => 'Odstranit',
        'save' => 'Uložit',
        'cancel' => 'Zrušit',
        'back' => 'Zpět',
    ],
    'auth' => [
        'login' => 'Přihlásit se',
        'login-picker' => 'Výběr přihlášení',
        'shibboleth' => 'Shibboleth',
        'graduate-login' => 'Přihlášení pro absolventy',
        'external-login' => 'Přihlášení pro externisty',
        'password' => 'Heslo',
        'password-confirm' => 'Zopakujte heslo',
        'remember_me' => 'Zapamatovat si přihlášení',
        'logout' => 'Odhlásit se',
        'register' => 'Registrovat se',
        'shibboleth-hint' => 'V rámci jednotného školního přihlášení pomocí Shibbolethu jsou vaše uživatelské údaje stejné jako do systému InSIS.',
        'graduate-hint' => 'Přihlášení pomocí absolventského portálu.',
    ],
    'blacklist' => [
        'blacklist' => 'Blacklist',
        'user-hint' => 'Vkládejte xname jednotlivých uživatelů oddělených čárkou.<br> Například: <br><b>xname00, xname01, xname02, ...</b>',
        'block_reason' => 'Důvod blokace',
        'blocked_until' => 'Blokace do',
        'global-blacklist' => 'Globální blacklist',
    ],
    'date' => [
        'dates' => 'Termíny',
        'list' => 'Seznam termínů',
        'date_start' => 'Začátek',
        'date_end' => 'Konec',
        'name' => 'Název termínu',
        'enrollment_start' => 'Přihlašování od',
        'enrollment_end' => 'Přihlašování do',
        'withdraw_end' => 'Odhlašování do',
        'capacity' => 'Kapacita',
        'from-to' => 'Od-Do',
    ],
    'event' => [
        'events' => 'Události',
        'status' => [
            '1' => 'Publikováno',
            '2' => 'Koncept',
            '3' => 'Smazána',
        ],
        'saved' => 'Událost vytvořena',
        'updated' => 'Událost upravena',
        'deleted' => 'Událost odstraněna',
        'detail' => 'Detail události',
        'create' => 'Vytvořit událost',
        'edit' => 'Editace události',
        'name' => 'Název',
        'status-label' => 'Stav',
        'participants' => 'Účastníci',
        'import' => 'Importovat',
        'show-dates' => 'Zobrazit termíny',
        'show-all-participants' => 'Zobrazit všechny účasnítky'
    ],
    'email' => [
        'email' => 'Email',
        'your-email' => 'Váš email',
        'send-test' => 'Poslat testovací email',
    ],
    'enrollment' => [
        'enrollment_form' => 'Přihlašovací formulář',
        'list' => 'Seznam účastníků',
        'enrolled' => 'Přihlášen',
        'c_fields' => 'Vyplněné hodnoty',
        'already_exists' => 'Pro tento termín již máte podanou přihlášku.',
        'my_enrollments' => 'Moje přihlášky',
    ],
    'c_fields' => [
        'name' => 'Název tagu',
        'type' => 'Typ',
        'required' => 'Povinné',
        'default' => 'Výchozí hodnota',
    ],
    'user' => [
        'first_name' => 'Jméno',
        'last_name' => 'Příjmení',
        'email' => 'Email',
        'xname' => 'Xname',
        'users' => 'Uživatelé',
        'roles' => 'Uživatelské role'
    ],
    'templates' => [
        'template' => 'Šablona',
        'templates' => 'Šablony',
        'name' => 'Název šablony',
        'approved' => 'Schválená',
        'not_approved' => 'Ke schválení',
        'html' => 'HTML kód',
        'default-template' => 'Výchozí šablona',
        'custom-template' => 'Vlastní šablona',
        'content' => 'Obsah',
        'content-placeholder' => 'Zde zadejte vlastní text',
        'template-hint' => 'Každá šablona musí obsahovat tag pro <code>[message]</code> vložení obsahu definovaného v události',
        'custom-template-hint' => 'Zde vložte validní HTML šablonu. Šablona by měla obsahovat validní HTML a CSS kód.',
        'content-missing' => 'Povinné vložení tagu <code>[message]</code> nebylo nalezeno v šabloně.',
        'saved-approval' => 'Šablona byla uložena. Bude dostupná, jakmile bude schválena správcem.',
        'deleted' => 'Šablona byla odstraněna.',
        'my-templates' => 'Moje šablony',
        'for-approval' => 'Šablony čekající na schválení',
        'updated' => 'Šablona byla úspěšně změněna.',
        'show-content' => 'Zobrazit obsah šablony',
        'invalid-html' => 'HTML kód není validní. Chybí <body> tag.',
        'status' => 'Stav',
        'template-create-title' => 'Vytvoření šablony',
        'template-edit-title' => 'Editace šablony',
        'test-sent-success' => 'Testovací email byl úspěšně odeslán.'
    ]
];
