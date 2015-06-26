<?php

$header = <<<EOF
This file is part of the PHP CS utility.

(c) Fabien Potencier <fabien@symfony.com>

This source file is subject to the MIT license that is bundled
with this source code in the file LICENSE.
EOF;

Symfony\CS\Fixer\Contrib\HeaderCommentFixer::setHeader($header);

return Symfony\CS\Config\Config::create()
    // use default SYMFONY_LEVEL and extra fixers:
    ->level(\Symfony\CS\FixerInterface::PSR2_LEVEL)
    ->fixers(array(
        'short_array_syntax',
        'extra_empty_lines',
        'blankline_after_open_tag',
    ))
    ->finder(
        Symfony\CS\Finder\DefaultFinder::create()
            ->in([
                __DIR__.'/src'
            ])
    )
;
