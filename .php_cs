<?php

return PhpCsFixer\Config::create()
    ->setRules([
        '@PSR2' => true,
        'array_indentation' => true,
        'array_syntax' => ['syntax' => 'short'],
        'combine_consecutive_unsets' => true,
        'class_attributes_separation' => true,
        'no_multiline_whitespace_before_semicolons' => true,
        'explicit_string_variable'=>true,

        'blank_line_after_opening_tag' => true,
        'blank_line_before_statement' => true,

        'braces' => [
            'allow_single_line_closure' => true,
        ],
        'cast_spaces' => true,
        'concat_space' => ['spacing' => 'one'],
        'function_typehint_space' => true,
        'single_line_comment_style' => true,
        'include' => true,

        'lowercase_cast' => true,
        'new_with_braces' => true,
        'native_function_casing' => true,
        'no_empty_comment' => true,
        'no_empty_statement' => true,

        'no_extra_blank_lines' => [
            'extra',
        ],
        'no_leading_namespace_whitespace' => true,
        'no_multiline_whitespace_around_double_arrow' => true,
        'no_singleline_whitespace_before_semicolons' => true,
        'no_spaces_around_offset' => true,
        'no_trailing_comma_in_list_call' => true,
        'no_trailing_comma_in_singleline_array' => true,
        'no_unneeded_control_parentheses' => true,
        'no_unused_imports' => true,
        'no_whitespace_before_comma_in_array' => true,
        'no_whitespace_in_blank_line' => true,
        'object_operator_without_whitespace' => true,
        'single_blank_line_before_namespace' => true,
        'ternary_operator_spaces' => true,
        'trim_array_spaces' => true,
        'unary_operator_spaces' => true,
        'whitespace_after_comma_in_array' => true,
    ])
    ->setLineEnding("\n");
