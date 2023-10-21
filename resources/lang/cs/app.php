<?php

return [
    'author' => 'Autor',
    'merge-tags' => 'Merge tagy',
    'app-title' => 'Registrační systém VŠE',
    'cs' => 'Česky',
    'en' => 'English',
    'app' => 'Aplikace',
    'administration' => 'Administrace',
    'homepage' => 'Hlavní stránka',
    '403-error-message' => 'Nemáte dostatečné oprávnění.',

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
        'login-error' => 'Nesprávné přihlašovací údaje',
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
        'change-password' => 'Změna hesla',
        'current-password' => 'Stávající heslo',
        'new-password' => 'Nové heslo',
        'new-password-confirm' => 'Potvrdit nové heslo',
        'password-changed-success' => 'Heslo úspěšně změněno',
        'password-change-error' => 'Zadané stávající heslo nesouhlasí.'
    ],
    'blacklist' => [
        'blacklist' => 'Blacklist',
        'user-hint' => 'Vkládejte xname jednotlivých uživatelů oddělených čárkou.<br> Například: <br><b>xname00, xname01, xname02, ...</b>',
        'block_reason' => 'Důvod blokace',
        'blocked_until' => 'Blokace do',
        'global-blacklist' => 'Globální blacklist',
    ],
    'date' => [
        'date' => 'Termín',
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
        'event-name' => 'Název události',
        'status-label' => 'Stav',
        'participants' => 'Účastníci',
        'import' => 'Importovat',
        'show-dates' => 'Zobrazit termíny',
        'show-all-participants' => 'Zobrazit všechny účastníky',
        'delete-date-error' => 'Nelze odstranit událost. Na události jsou přihlášeni účastníci.'
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
        'cannot_enroll' => 'Na tento termín se nemůžete přihlásit, jelikož nesplňujete kritéria přihlášení.',
        'my_enrollments' => 'Moje přihlášky',
        'no-enrollments' => 'Zatím nemáte žádné přihlášky.',
        'state' => [
            'title' => 'Stav přihlášky',
            '1' => 'Přihlášen',
            '2' => 'Náhradník',
            '3' => 'Odhlášen'
        ],
        'sign-out' => 'Odhlásit se',
        'signed-off' => 'Byli jste odhlášeni z termínu.',
        'sign-off-error' => 'Z termínu se nemůžete odhlásit.',
        'enroll-email-success' => 'Byli jste přihlášeni na termín.',
        'enroll-email-error' => 'Na termín se již přihlásil jiný náhradník.',
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
    ],
    'notifications' => [
        'sign_off_title' => 'Odhlášení z termínu',
        'sign_off' => 'Byli jste odhlášeni z termínu :date, důvod odhlášení :reason.',
        'enrollment_end_title' => 'Konec prihlašování na termín',
        'enrollment_end' => 'Dnes končí přihlašování na termín :date, u události :event.',
        'enrollment_title' => 'Registrace na událost',
        'enrollment_text' => 'Byli jste úspěšně registrováni na událost :event na termín :date.',
        'enrollment_tags' => 'Zde jsou vámi vyplněné údaje: :tags',
        'capacity_full_title' => 'Kapacita termínu naplněna',
        'capacity_full' => 'Kapacita na termínu :date u události :event byla naplněna.',
        'free_spot_title' => 'Volné místo na termínu, u kterého jste náhradníkem',
        'free_spot' => 'Pro termín :date u události :event bylo uvolněné místo. Pokud se chcete přihlásit klikněte <a href=":link">zde</a>.',
        'substitute_signed_title' => 'Byli jste přihlášeni na termín',
        'substitute_signed' => 'Byli jste přihlášeni na termín :date u události :event, jelikož jste se na tento termín přihlásili jako náhradník'
    ]
];
