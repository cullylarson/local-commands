<?php

namespace Test\Cully\Local;

use Cully\Local\Command;

class CommandTest extends \PHPUnit_Framework_TestCase {
    public function testSuccessExitStatus() {
        $command = new Command();

        $command->exec("ls");

        $this->assertEquals(0, $command->getExitStatus());
    }

    public function testGetCommand() {
        $command = new Command();

        $command->exec("ls");

        $this->assertEquals("ls", $command->getCommand());
    }

    public function testSuccess() {
        $command = new Command();

        $command->exec("ls");

        $this->assertTrue($command->success());
    }

    public function testDidntFail() {
        $command = new Command();

        $command->exec("ls");

        $this->assertFalse($command->failure());
    }

    public function testHasRun() {
        $command = new Command();

        $command->exec("ls");

        $this->assertTrue($command->hasRun());
    }

    public function testHasntRun() {
        $command = new Command();

        $this->assertFalse($command->hasRun());
    }

    public function testNoFailureWhenNotRun() {
        $command = new Command();

        $this->assertFalse($command->failure());
    }

    public function testNoSuccessWhenNotRun() {
        $command = new Command();

        $this->assertFalse($command->success());
    }

    public function testAssertFailExitStatus() {
        $command = new Command();

        $command->exec("ls a/path/that/hopefully/doesnt/exist/if/it/does/craziness");

        $this->assertNotEquals(0, $command->getExitStatus());
    }

    public function testFailure() {
        $command = new Command();

        $command->exec("ls a/path/that/hopefully/doesnt/exist/if/it/does/craziness");

        $this->assertTrue($command->failure());
    }

    public function testDidntSucceed() {
        $command = new Command();

        $command->exec("ls a/path/that/hopefully/doesnt/exist/if/it/does/craziness");

        $this->assertFalse($command->success());
    }

    public function testOutput() {
        $command = new Command();

        $command->exec("ls");

        $this->assertNotEmpty($command->getOutput());
    }

    public function testNoOutput() {
        $command = new Command();

        $command->exec("ls a/path/that/hopefully/doesnt/exist/if/it/does/craziness");

        $this->assertEmpty($command->getOutput());
    }

    public function testError() {
        $command = new Command();

        $command->exec("ls a/path/that/hopefully/doesnt/exist/if/it/does/craziness");

        $this->assertNotEmpty($command->getError());
    }

    public function testNoError() {
        $command = new Command();

        $command->exec("ls");

        $this->assertEmpty($command->getError());
    }

    public function cwdTest() {
        $command = new Command();
        $command->exec("pwd", "/tmp");

        $this->assertEquals("/tmp", $command->getOutput());
    }

    public function envTest() {
        $command = new Command();
        $command->exec("echo \$CULLY_TEST_VARIABLE", null, ["CULLY_TEST_VARIABLE" => "works"]);

        $this->assertEquals("works", $command->getOutput());
    }
}
