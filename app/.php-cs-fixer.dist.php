<?php

$finder = PhpCsFixer\Finder::create()
    ->in([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])
    ->exclude([
        'var',
        'vendor',
    ])
    ->name('*.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        // Standards généraux
        '@Symfony' => true,
        '@Symfony:risky' => true,
        '@PSR12' => true,
        '@DoctrineAnnotation' => true,

        // Style & formatage
        'array_syntax' => ['syntax' => 'short'],
        'binary_operator_spaces' => ['default' => 'align'],
        'concat_space' => ['spacing' => 'one'],
        'ordered_imports' => [
            'sort_algorithm' => 'alpha',
            'imports_order' => ['class', 'function', 'const'],
        ],
        'phpdoc_order' => true,
        'phpdoc_align' => ['align' => 'vertical'],
        'phpdoc_separation' => true,
        'phpdoc_summary' => true,

        // Clean code
        'strict_param' => true,
        'declare_strict_types' => true,
        'no_unused_imports' => true,
        'no_superfluous_phpdoc_tags' => true,
        'no_empty_phpdoc' => true,
        'no_empty_statement' => true,
        'simplified_if_return' => true,
        'simplified_null_return' => true,

        // Optimisation
        'native_function_invocation' => [
            'include' => ['@internal'],
            'scope' => 'namespaced',
            'strict' => true,
        ],
        'modernize_types_casting' => true,
    ])
    ->setFinder($finder);
