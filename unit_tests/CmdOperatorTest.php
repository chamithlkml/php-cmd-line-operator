<?php

/**
 * This file contains basic unit tests for testing the
 * functionalities of the CmdOperator class
 */

declare(strict_types=1);

namespace Chamithlkml;

use PHPUnit\Framework\TestCase;

final class CmdOperatorTest extends TestCase
{
    public function testNoMethodSupplied(): void
    {
        $pathToCmd = realpath(__DIR__)
            . DIRECTORY_SEPARATOR
            . '..'
            . DIRECTORY_SEPARATOR
            . 'Cmd.php';

        # No method name provided
        $command = '$(which php) ' . $pathToCmd;

        $output = shell_exec($command);
        $jsonObj = json_decode($output);

        # status=0
        $this->assertSame(0, $jsonObj->status);
        $this->assertStringContainsString(
            'Please specify a method name',
            $jsonObj->message
        );
    }

    public function testMoreThanOneMethodsSupplied(): void
    {
        $pathToCmd = realpath(__DIR__)
            . DIRECTORY_SEPARATOR
            . '..'
            . DIRECTORY_SEPARATOR
            . 'Cmd.php';

        # Two public methods provided
        $command = '$(which php) ' . $pathToCmd . ' --subscribe --upgrade';

        $output = shell_exec($command);
        $jsonObj = json_decode($output);

        $this->assertSame(
            'More than one method found in the command issued',
            $jsonObj->message
        );
    }

    public function testParamMissingOnMethod(): void
    {
        $pathToCmd = realpath(__DIR__)
            . DIRECTORY_SEPARATOR
            . '..'
            . DIRECTORY_SEPARATOR
            . 'Cmd.php';

        # --planId is missing
        $command = '$(which php) ' . $pathToCmd .
        ' --subscribe --firstName Foo --lastName Bar --email foobar@mail.com';
        $output = shell_exec($command);
        $jsonObj = json_decode($output);

        $this->assertSame(0, $jsonObj->status);
        $this->assertSame(
            'Parameter `--planId` not found in the command issued',
            $jsonObj->message
        );
    }
}
