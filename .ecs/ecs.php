<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\ArrayNotation\ArraySyntaxFixer;
use PhpCsFixer\Fixer\ControlStructure\YodaStyleFixer;
use PhpCsFixer\Fixer\FunctionNotation\NativeFunctionInvocationFixer;
use PhpCsFixer\Fixer\FunctionNotation\SingleLineThrowFixer;
use PhpCsFixer\Fixer\Operator\BinaryOperatorSpacesFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocToCommentFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitTestClassRequiresCoversFixer;
use PhpCsFixer\Fixer\ReturnNotation\NoUselessReturnFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ECSConfig $ecsConfig) use ($paths): void {
    $ecsConfig->sets([
        SetList::CLEAN_CODE,
        SetList::DOCTRINE_ANNOTATIONS,
        __DIR__ .'/php-cs-fixer.php',
        __DIR__ .'/symfony.php',
        __DIR__ .'/symfony-risky.php',
        SetList::PSR_12,
        SetList::COMMON,
        SetList::STRICT,
    ]);

    $ecsConfig->paths($paths);
    $ecsConfig->skip([
        __DIR__ . '/src/Kernel.php',
        __DIR__ . '/src/Message/AbstractMessage.php',
        NativeFunctionInvocationFixer::class,
        PhpUnitTestClassRequiresCoversFixer::class,
        PhpdocToCommentFixer::class,
        NoUselessReturnFixer::class,
        SingleLineThrowFixer::class,
    ]);

    $ecsConfig->ruleWithConfiguration(YodaStyleFixer::class, ['always_move_variable' => false]);
    $ecsConfig->ruleWithConfiguration(BinaryOperatorSpacesFixer::class, ['operators' => ['|' => 'no_space']]);
    $ecsConfig->ruleWithConfiguration(ArraySyntaxFixer::class, ['syntax' => 'short']);
};
