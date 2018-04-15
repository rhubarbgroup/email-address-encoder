<?php

$rules = array(
    'psr4' => true,
);

return PhpCsFixer\Config::create()
    ->setRiskyAllowed(true)
    ->setRules($rules)
    ->setUsingCache(true)
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->exclude('assets')
            ->exclude('languages')
            ->in(__DIR__)
    );
