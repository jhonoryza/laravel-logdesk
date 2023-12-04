<?php

namespace Jhonoryza\Logdesk\Concerns;

use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;

class ArgumentConverter
{
    protected static $themes = [
        'light' => [
            'default' => 'background:none; color:#CC7832; line-height:1.2em; font:12px Menlo, Monaco, Consolas, monospace; word-wrap: break-word; white-space: pre-wrap; position:relative; z-index:0; word-break: break-all',
            'num' => 'font-weight:bold; color:#1299DA',
            'const' => 'font-weight:bold',
            'str' => 'font-weight:bold; color:#629755;',
            'note' => 'color:#6897BB',
            'ref' => 'color:#6E6E6E',
            'public' => 'color:#262626',
            'protected' => 'color:#262626',
            'private' => 'color:#262626',
            'meta' => 'color:#B729D9',
            'key' => 'color:#789339',
            'index' => 'color:#1299DA',
            'ellipsis' => 'color:#CC7832',
            'ns' => 'user-select:none;',
        ]
    ];

    public static function convertToPrimitive($argument)
    {
        if (is_null($argument)) {
            return null;
        }

        if (is_string($argument)) {
            return $argument;
        }

        if (is_int($argument)) {
            return $argument;
        }

        if (is_bool($argument)) {
            return $argument;
        }

        $cloner = new VarCloner();

        $dumper = new HtmlDumper();
        $dumper->setStyles(static::$themes['light']);

        $clonedArgument = $cloner->cloneVar($argument);

        return $dumper->dump($clonedArgument, true);
    }
}
