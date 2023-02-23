<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php');

# Loading environment variables available in .env file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

final class CmdOperatorTest extends TestCase
{
    public function testNoMethodSupplied(): void
    {
        $path_to_cmd_php = '..' . DIRECTORY_SEPARATOR . 'cmd.php';
        $command = 'php ' . $path_to_cmd_php;# No method name provided
        
        $output = shell_exec($command);
        $json_obj = json_decode($output);

        # status=0
        $this->assertSame(0, $json_obj->status);
        $this->assertStringContainsString('Please specify a method name', $json_obj->message);
    }

    public function testMoreThanOneMethodsSupplied(): void
    {
        $path_to_cmd_php = '..' . DIRECTORY_SEPARATOR . 'cmd.php';
        $command = 'php ' . $path_to_cmd_php . ' --subscribe --upgrade';# Two public methods provided

        $output = shell_exec($command);
        $json_obj = json_decode($output);

        $this->assertSame('More than one method found in the command issued', $json_obj->message);
    }

    public function testParamMissingOnMethod(): void
    {
        $path_to_cmd_php = '..' . DIRECTORY_SEPARATOR . 'cmd.php';
        $command = 'php ' . $path_to_cmd_php . ' --subscribe --first_name Foo --last_name Bar --email foobar@mail.com';# --plan_id is missing

        $output = shell_exec($command);
        $json_obj = json_decode($output);

        $this->assertSame(0, $json_obj->status);
        $this->assertSame('Parameter `--plan_id` not found in the command issued', $json_obj->message);
    }
}