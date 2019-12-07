<?php

$finder = PhpCsFixer\Finder::create()
    ->exclude(['vendor'])
    ->in(__DIR__ . '/app')
    ->append([__DIR__.'/tests'])
;

$config = PhpCsFixer\Config::create()
    ->setRiskyAllowed(false)
    ->setRules([
        '@PhpCsFixer' => true,
        '@PSR2' => true,
        'array_syntax' => ['syntax' => 'short'],
        'list_syntax' => ['syntax' => 'long'],
        'php_unit_test_class_requires_covers' => false,
        'single_line_comment_style' => false,
        'multiline_comment_opening_closing' => false,
    ])
    ->setFinder($finder)
    ->setUsingCache(false)
;

if (false !== getenv('FABBOT_IO')) {
    try {
        PhpCsFixer\FixerFactory::create()
            ->registerBuiltInFixers()
            ->registerCustomFixers($config->getCustomFixers())
            ->useRuleSet(new PhpCsFixer\RuleSet($config->getRules()))
        ;
    } catch (PhpCsFixer\ConfigurationException\InvalidConfigurationException $e) {
        $config->setRules([]);
    } catch (UnexpectedValueException $e) {
        $config->setRules([]);
    } catch (InvalidArgumentException $e) {
        $config->setRules([]);
    }
}

return $config;
