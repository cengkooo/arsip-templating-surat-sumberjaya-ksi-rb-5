<?php

return [
    'version' => [
        'tiny' => '7.3.0',
        'language' => [
            // https://cdn.jsdelivr.net/npm/tinymce-i18n@latest/
            'version' => '24.7.29',
            'package' => 'langs7',
        ],
        'licence_key' => env('TINY_LICENSE_KEY', 'no-api-key'),
    ],
    'provider' => 'cloud', // cloud|vendor
    // 'direction' => 'rtl',
    /**
     * change darkMode: 'auto'|'force'|'class'|'media'|false|'custom'
     */
    'darkMode' => false,

    /** cutsom */
    'skins' => [
        // oxide, oxide-dark, tinymce-5, tinymce-5-dark
        'ui' => 'oxide',

        // dark, default, document, tinymce-5, tinymce-5-dark, writer
        'content' => 'default'
    ],

    'profiles' => [
        'default' => [
            'plugins' => 'accordion autoresize codesample directionality advlist link image lists preview pagebreak searchreplace wordcount code fullscreen insertdatetime media table emoticons',
            'toolbar' => 'undo redo removeformat | fontfamily fontsize fontsizeinput font_size_formats styles | bold italic underline | rtl ltr | alignjustify alignleft aligncenter alignright | numlist bullist outdent indent | forecolor backcolor | blockquote table toc hr | image link media codesample emoticons | wordcount fullscreen',
            'upload_directory' => null,
        ],

        'simple' => [
            'plugins' => 'autoresize directionality emoticons link wordcount',
            'toolbar' => 'removeformat | bold italic | rtl ltr | numlist bullist | link emoticons',
            'upload_directory' => null,
        ],

        'minimal' => [
            'plugins' => 'link wordcount',
            'toolbar' => 'bold italic link numlist bullist',
            'upload_directory' => null,
        ],

        'full' => [
            'plugins' => 'accordion autoresize codesample directionality advlist autolink link image lists charmap preview anchor pagebreak searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media table emoticons help',
            'toolbar' => 'undo redo removeformat | styles fontfamily fontsize | bold italic underline strikethrough | forecolor backcolor | alignleft aligncenter alignright alignjustify | outdent indent | numlist bullist | blockquote table hr | link image media | code fullscreen help',
            'toolbar_mode' => 'sliding',
            'menubar' => 'file edit view insert format tools table help',
            'menu' => [
                'file' => ['title' => 'File', 'items' => 'newdocument | preview print'],
                'edit' => ['title' => 'Edit', 'items' => 'undo redo | cut copy paste | selectall | searchreplace'],
                'view' => ['title' => 'View', 'items' => 'code | visualblocks | fullscreen'],
                'insert' => ['title' => 'Insert', 'items' => 'link image media | table hr | insertdatetime | charmap emoticons'],
                'format' => ['title' => 'Format', 'items' => 'bold italic underline strikethrough | styles | align | indent outdent | removeformat'],
                'tools' => ['title' => 'Tools', 'items' => 'wordcount code'],
                'table' => ['title' => 'Table', 'items' => 'inserttable | cell row column | advtablesort | tableprops deletetable'],
                'help' => ['title' => 'Help', 'items' => 'help']
            ],
            'style_formats' => [
                ['title' => 'Judul Surat', 'block' => 'h2', 'styles' => ['textAlign' => 'center', 'fontWeight' => 'bold', 'textDecoration' => 'underline', 'fontSize' => '14pt']],
                ['title' => 'Subjudul', 'block' => 'h3', 'styles' => ['textAlign' => 'center', 'fontWeight' => 'bold', 'fontSize' => '12pt']],
                ['title' => 'Paragraf Normal', 'block' => 'p', 'styles' => ['textAlign' => 'justify', 'lineHeight' => '1.5', 'textIndent' => '50px']],
                ['title' => 'Paragraf Tanpa Indent', 'block' => 'p', 'styles' => ['textAlign' => 'justify', 'lineHeight' => '1.5']],
                ['title' => 'Paragraf Tengah', 'block' => 'p', 'styles' => ['textAlign' => 'center', 'lineHeight' => '1.5']],
                ['title' => 'Paragraf Kanan', 'block' => 'p', 'styles' => ['textAlign' => 'right', 'lineHeight' => '1.5']],
            ],
            'style_formats_merge' => false,
            'indent_use_margin' => true,
            'indentation' => '30pt',
            'content_style' => 'body { font-family: "Times New Roman", Times, serif; font-size: 12pt; color: #000000; background-color: #ffffff; line-height: 1.5; } p { margin: 0 0 10px 0; text-align: justify; } table { border-collapse: collapse; width: auto; } td { padding: 2px 5px; }',
            'upload_directory' => null,
        ],
    ],

    /**
     * this option will load optional language file based on you app locale
     * example:
     * languages => [
     *      'fa' => 'https://cdn.jsdelivr.net/npm/tinymce-i18n@24.7.29/langs7/fa.min.js',
     *      'es' => 'https://cdn.jsdelivr.net/npm/tinymce-i18n@24.7.29/langs7/es.min.js',
     *      'ja' => asset('assets/ja.min.js')
     * ]
     */
    'languages' => [],

    'extra' => [
        'toolbar' => [
            'fontsize' => '8pt 9pt 10pt 11pt 12pt 13pt 14pt 16pt 18pt 20pt 24pt 28pt 32pt 36pt',
            'fontfamily' => 'Times New Roman=times new roman,times,serif; Arial=arial,helvetica,sans-serif; Courier New=courier new,courier,monospace; Georgia=georgia,serif; Calibri=calibri,sans-serif; Tahoma=tahoma,arial,helvetica,sans-serif; Verdana=verdana,sans-serif;',
            'lineheight_formats' => '1 1.15 1.5 2 2.5 3',
            'content_style' => 'body { font-family: "Times New Roman", Times, serif; font-size: 12pt; color: #000000 !important; background-color: #ffffff !important; line-height: 1.5; } * { color: #000000 !important; } p { margin: 0 0 10px 0; } table { border-collapse: collapse; } td { padding: 2px 5px; }',
        ]
    ]
];
