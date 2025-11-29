<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var list<string>
     */
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public array $templates = [
        'list' => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------

    public array $login = [
        'username' => 'required|min_length[3]|max_length[50]',
        'password' => [
            'rules' => 'required|min_length[8]|regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/]',
            'errors' => [
                'regex_match' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one symbol.',
            ]
        ],
    ];

    public array $reset = [
        'password' => [
            'rules' => 'required|min_length[8]|regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/]',
            'errors' => [
                'regex_match' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one symbol.',
            ]
        ],
        'confirm_password' => [
            'rules' => 'matches[password]',
            'errors' => [
                'matches' => 'Password confirmation does not match the password.',
            ]
        ]
    ];

    public array $create_user = [
        'firstname' => 'required|min_length[2]|max_length[50]|regex_match[/^[A-Za-z][A-Za-z\' -]*$/]',
        'lastname' => 'required|min_length[2]|max_length[50]|regex_match[/^[A-Za-z][A-Za-z\' -]*$/]',
        'email' => 'required|valid_email|is_unique[users.email]',
        'acctype' => 'required|in_list[student,associate]',
    ];

}
