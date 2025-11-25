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
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------
    public array $create_user = [
        'firstname'=> 'required|min_length[2]|max_length[50]|regex_match[/^[A-Za-z][A-Za-z\' -]*$/]',
        'lastname'=> 'required|min_length[2]|max_length[50]|regex_match[/^[A-Za-z][A-Za-z\' -]*$/]',
        'email' => 'required|valid_email|is_unique[users.email]|',
    ];
}
