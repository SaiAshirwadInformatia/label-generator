<?php

return [
    'page'             => 'a4',
    'orientation'      => 'portrait',
    'pageOptions'      => ['a4' => 'A4', 'a3' => 'A3', 'a2' => 'A2'],
    'pageOrientations' => ['portrait' => 'Portrait', 'landscape'],
    'fieldTypes'       => [
        'Text' => 'Text',
        'Static' => 'Static',
        'SubCount' => 'SubCount',
        'Incremented' => 'Incremented',
        'Number' => 'Number',
        'Float' => 'Float',
        'Boolean' => 'Boolean',
        'dd/MM/YYYY' => 'dd/MM/YYYY',
        'INR' => 'INR',
        'EmptyRow' => 'EmptyRow',
        'Concatenated' => 'Concatenated'
    ],
    'fonts' => [
        'Roboto' => [
            'name' => 'Roboto',
            'weight' => [
                'Black' => 'Black',
                'BlackItalic' => 'BlackItalic',
                'Bold' => 'Bold',
                'BoldItalic' => 'BoldItalic',
                'Italic' => 'Italic',
                'Light' => 'Light',
                'LightItalic' => 'LightItalic',
                'Medium' => 'Medium',
                'MediumItalic' => 'MediumItalic',
                'Regular' => 'Regular',
                'Thin' => 'Thin',
                'ThinItalic' => 'ThinItalic',
            ],
        ],

        'Aleo' => [
            'name' => 'Aleo',
            'weight' => [
                'Bold' => 'Bold',
                'BoldItalic' => 'BoldItalic',
                'Italic' => 'Italic',
                'Light' => 'Light',
                'LightItalic' => 'LightItalic',
                'Regular' => 'Regular',
            ],
        ],
    ],
];
