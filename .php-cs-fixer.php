<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$rules = [
    '@PSR12'                                 => true,
    'array_indentation'                      => true,
    'array_syntax'                           => ['syntax' => 'short'],
    'combine_consecutive_unsets'             => true,
    'class_attributes_separation'            => ['elements' => ['method' => 'one']],
    'multiline_whitespace_before_semicolons' => true,
    'single_quote'                           => true,

    'binary_operator_spaces' => [
        'operators' => [
            '=>' => 'align_single_space_minimal',
        ],
    ],
    'braces' => [
        'allow_single_line_closure'                         => true,
        'allow_single_line_anonymous_class_with_empty_body' => true,
    ],
    'cast_spaces'                 => true,
    'combine_consecutive_issets'  => true,
    'concat_space'                => ['spacing' => 'none'],
    'function_typehint_space'     => true,
    'global_namespace_import'     => true,
    'single_line_comment_style'   => ['comment_types' => ['hash']],
    'include'                     => true,
    'method_argument_space'       => ['on_multiline' => 'ensure_fully_multiline'],
    'method_chaining_indentation' => true,
    'no_blank_lines_after_phpdoc' => true,
    'no_empty_statement'          => true,
    'no_extra_blank_lines'        => [
        'tokens' => [
            'curly_brace_block',
            'extra',
            'parenthesis_brace_block',
            'return',
            'square_brace_block',
            'throw',
            'use',
        ],
    ],
    'no_leading_namespace_whitespace'             => true,
    'no_multiline_whitespace_around_double_arrow' => true,
    'no_singleline_whitespace_before_semicolons'  => true,
    'no_spaces_around_offset'                     => true,
    'no_trailing_comma_in_list_call'              => true,
    'no_trailing_comma_in_singleline_array'       => true,
    'no_unused_imports'                           => true,
    'no_whitespace_before_comma_in_array'         => true,
    'object_operator_without_whitespace'          => true,
    'operator_linebreak'                          => true,
    'phpdoc_add_missing_param_annotation'         => true,
    'phpdoc_align'                                => ['align' => 'left'],
    'phpdoc_indent'                               => true,
    'phpdoc_order'                                => true,
    'phpdoc_return_self_reference'                => true,
    'phpdoc_scalar'                               => true,
    'phpdoc_separation'                           => true,
    'phpdoc_single_line_var_spacing'              => true,
    'phpdoc_trim'                                 => true,
    'phpdoc_types'                                => true,
    'phpdoc_var_annotation_correct_order'         => true,
    'standardize_not_equals'                      => true,
    'single_space_after_construct'                => true,
    'trailing_comma_in_multiline'                 => ['elements' => ['arrays']],
    'trim_array_spaces'                           => true,
    'unary_operator_spaces'                       => true,
    'whitespace_after_comma_in_array'             => true,
    'space_after_semicolon'                       => true,
];

$finder = Finder::create()
    ->in([
        __DIR__ . '/app',
        __DIR__ . '/config',
        __DIR__ . '/database',
        __DIR__ . '/resources',
        __DIR__ . '/routes',
        __DIR__ . '/tests',
    ])
    ->name('*.php')
    ->notName('*.blade.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

return (new Config())
    ->setFinder($finder)
    ->setRules($rules)
    ->setRiskyAllowed(false)
    ->setUsingCache(true);
