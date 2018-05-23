<?php

namespace Trafficgate\Transferer\Ssh;

use PHPUnit\Framework\TestCase;

class SshCommandTest extends TestCase
{
    public function testGetCommandString()
    {
        $sshCommand = new SshCommand();
        $sshCommand->host('127.0.0.1');
        $sshCommand->remoteCommand('echo Hello');
        $commandString = $sshCommand->getCommandString();

        $this->assertEquals(
            "'ssh' ".
            "'-q' ".
            "'-o' 'BatchMode yes' ".
            "'-o' 'StrictHostKeyChecking no' ".
            "'-o' 'UserKnownHostsFile /dev/null' ".
            "'127.0.0.1' ".
            "'echo Hello'",
            $commandString
        );
    }

    public function testRunOnce()
    {
        $sshCommand = new SshCommand();
        $sshCommand->host('127.0.0.1');
        $sshCommand->remoteCommand('echo Hello');

        $output = '';
        $sshCommand->runOnce(null, function ($type, $buffer) use (&$output) {
            $output .= $buffer;
        });

        $this->assertEquals("Hello\n", $output);
    }
}
