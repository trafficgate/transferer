<?php

namespace Trafficgate\Transfer;

use PHPUnit_Framework_TestCase;
use Symfony\Component\Process\Exception\ProcessFailedException;

class ScpTransferTest extends PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $scpTransfer = new ScpTransfer();
        $this->assertInstanceOf(ScpTransfer::class, $scpTransfer);
    }

    public function testProtocol1andProtocol2()
    {
        $scpTransfer = new ScpTransfer();
        $return      = $scpTransfer->protocol1();
        $this->assertSame($scpTransfer, $return);
        $this->assertEquals("'scp' '-1' '' ''", $scpTransfer->getCommandString());

        $return = $scpTransfer->protocol2();
        $this->assertSame($scpTransfer, $return);
        $this->assertEquals("'scp' '-2' '' ''", $scpTransfer->getCommandString());

        $scpTransfer->protocol2($enabled = false);
        $this->assertEquals("'scp' '' ''", $scpTransfer->getCommandString());

        $scpTransfer->protocol1()->protocol1($enabled = false);
        $this->assertEquals("'scp' '' ''", $scpTransfer->getCommandString());
    }

    public function testIp4OnlyAndIp6Only()
    {
        $scpTransfer = new ScpTransfer();
        $return      = $scpTransfer->ip4Only();
        $this->assertSame($scpTransfer, $return);
        $this->assertEquals("'scp' '-4' '' ''", $scpTransfer->getCommandString());

        $return = $scpTransfer->ip6Only();
        $this->assertSame($scpTransfer, $return);
        $this->assertEquals("'scp' '-6' '' ''", $scpTransfer->getCommandString());

        $scpTransfer->ip6Only($enabled = false);
        $this->assertEquals("'scp' '' ''", $scpTransfer->getCommandString());

        $scpTransfer->ip4Only()->ip4Only($enabled = false);
        $this->assertEquals("'scp' '' ''", $scpTransfer->getCommandString());
    }

    public function testBatchMode()
    {
        $scpTransfer = new ScpTransfer();
        $return      = $scpTransfer->batchMode();
        $this->assertSame($scpTransfer, $return);
        $this->assertEquals("'scp' '-B' '' ''", $scpTransfer->getCommandString());
        $scpTransfer->batchMode($enabled = false);
        $this->assertEquals("'scp' '' ''", $scpTransfer->getCommandString());
    }

    public function testCompression()
    {
        $scpTransfer = new ScpTransfer();
        $return      = $scpTransfer->compression();
        $this->assertSame($scpTransfer, $return);
        $this->assertEquals("'scp' '-C' '' ''", $scpTransfer->getCommandString());
        $scpTransfer->compression($enabled = false);
        $this->assertEquals("'scp' '' ''", $scpTransfer->getCommandString());
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Value can only be a string or numeric.
     */
    public function testCipherException()
    {
        $scpTransfer = new ScpTransfer();
        $scpTransfer->cipher();
    }

    public function testCipher()
    {
        $scpTransfer = new ScpTransfer();
        $return      = $scpTransfer->cipher('blowfish-cbc');
        $this->assertSame($scpTransfer, $return);
        $this->assertEquals("'scp' '-c' 'blowfish-cbc' '' ''", $scpTransfer->getCommandString());

        $scpTransfer->cipher('aes256-cbc');
        $this->assertEquals("'scp' '-c' 'aes256-cbc' '' ''", $scpTransfer->getCommandString());

        $scpTransfer->cipher($value = '', $remove = false, $enabled = false);
        $this->assertEquals("'scp' '' ''", $scpTransfer->getCommandString());
    }

    public function testSshConfig()
    {
        $scpTransfer = new ScpTransfer();
        $return      = $scpTransfer->sshConfig('/some/fake/path/to/config');
        $this->assertSame($scpTransfer, $return);
        $this->assertEquals("'scp' '-F' '/some/fake/path/to/config' '' ''", $scpTransfer->getCommandString());

        $scpTransfer->sshConfig('/another/fake/path/to/config');
        $this->assertEquals("'scp' '-F' '/another/fake/path/to/config' '' ''", $scpTransfer->getCommandString());

        $scpTransfer->sshConfig($value = '', $remove = false, $enabled = false);
        $this->assertEquals("'scp' '' ''", $scpTransfer->getCommandString());
    }

    public function testIdentityFile()
    {
        $scpTransfer = new ScpTransfer();
        $return      = $scpTransfer->identityFile('/some/fake/path/to/id_rsa');
        $this->assertSame($scpTransfer, $return);
        $this->assertEquals("'scp' '-i' '/some/fake/path/to/id_rsa' '' ''", $scpTransfer->getCommandString());

        $scpTransfer->identityFile('/another/fake/path/to/id_rsa');
        $this->assertEquals("'scp' '-i' '/another/fake/path/to/id_rsa' '' ''", $scpTransfer->getCommandString());

        $scpTransfer->identityFile($value = '', $remove = false, $enabled = false);
        $this->assertEquals("'scp' '' ''", $scpTransfer->getCommandString());
    }

    public function testLimit()
    {
        $scpTransfer = new ScpTransfer();
        $return      = $scpTransfer->limit(200);
        $this->assertSame($scpTransfer, $return);
        $this->assertEquals("'scp' '-l' '200' '' ''", $scpTransfer->getCommandString());

        $scpTransfer->limit(400);
        $this->assertEquals("'scp' '-l' '400' '' ''", $scpTransfer->getCommandString());

        $scpTransfer->limit($value = '', $remove = false, $enabled = false);
        $this->assertEquals("'scp' '' ''", $scpTransfer->getCommandString());
    }

    public function testSshOptions()
    {
        $scpTransfer = new ScpTransfer();
        $return      = $scpTransfer->sshOptions('Host distant');
        $this->assertSame($scpTransfer, $return);
        $this->assertEquals("'scp' '-o' 'Host distant' '' ''", $scpTransfer->getCommandString());

        $scpTransfer->sshOptions('ProxyCommand ssh near dc distant 22');
        $this->assertEquals(
            "'scp' '-o' 'Host distant' '-o' 'ProxyCommand ssh near dc distant 22' '' ''",
            $scpTransfer->getCommandString()
        );

        $scpTransfer->sshOptions($value = 'Host distant', $remove = true);
        $this->assertEquals("'scp' '-o' 'ProxyCommand ssh near dc distant 22' '' ''", $scpTransfer->getCommandString());

        $scpTransfer->sshOptions($value = 'ProxyCommand ssh near dc distant 22', $remove = true);
        $this->assertEquals("'scp' '' ''", $scpTransfer->getCommandString());
    }

    public function testPort()
    {
        $scpTransfer = new ScpTransfer();
        $return      = $scpTransfer->port(54321);
        $this->assertSame($scpTransfer, $return);
        $this->assertEquals("'scp' '-P' '54321' '' ''", $scpTransfer->getCommandString());

        $scpTransfer->port(12345);
        $this->assertEquals("'scp' '-P' '12345' '' ''", $scpTransfer->getCommandString());

        $scpTransfer->port($value = '', $remove = false, $enabled = false);
        $this->assertEquals("'scp' '' ''", $scpTransfer->getCommandString());
    }

    public function testPreserveFile()
    {
        $scpTransfer = new ScpTransfer();
        $return      = $scpTransfer->preserveFile();
        $this->assertSame($scpTransfer, $return);
        $this->assertEquals("'scp' '-p' '' ''", $scpTransfer->getCommandString());
        $scpTransfer->preserveFile($enabled = false);
        $this->assertEquals("'scp' '' ''", $scpTransfer->getCommandString());
    }

    public function testQuietMode()
    {
        $scpTransfer = new ScpTransfer();
        $return      = $scpTransfer->quietMode();
        $this->assertSame($scpTransfer, $return);
        $this->assertEquals("'scp' '-q' '' ''", $scpTransfer->getCommandString());
        $scpTransfer->quietMode($enabled = false);
        $this->assertEquals("'scp' '' ''", $scpTransfer->getCommandString());
    }

    public function testRecursive()
    {
        $scpTransfer = new ScpTransfer();
        $return      = $scpTransfer->recursive();
        $this->assertSame($scpTransfer, $return);
        $this->assertEquals("'scp' '-r' '' ''", $scpTransfer->getCommandString());
        $scpTransfer->recursive($enabled = false);
        $this->assertEquals("'scp' '' ''", $scpTransfer->getCommandString());
    }

    public function testProgram()
    {
        $scpTransfer = new ScpTransfer();
        $return      = $scpTransfer->program('some_program');
        $this->assertSame($scpTransfer, $return);
        $this->assertEquals("'scp' '-S' 'some_program' '' ''", $scpTransfer->getCommandString());

        $scpTransfer->program('another_program');
        $this->assertEquals("'scp' '-S' 'another_program' '' ''", $scpTransfer->getCommandString());

        $scpTransfer->program($value = '', $remove = false, $enabled = false);
        $this->assertEquals("'scp' '' ''", $scpTransfer->getCommandString());
    }

    public function testVerbose()
    {
        $scpTransfer = new ScpTransfer();
        $return      = $scpTransfer->verbose();
        $this->assertSame($scpTransfer, $return);
        $this->assertEquals("'scp' '-v' '' ''", $scpTransfer->getCommandString());
        $scpTransfer->verbose($enabled = false);
        $this->assertEquals("'scp' '' ''", $scpTransfer->getCommandString());
    }

    public function testSource()
    {
        $scpTransfer = new ScpTransfer();
        $return      = $scpTransfer->source('/path/to/file');
        $this->assertSame($scpTransfer, $return);
        $this->assertEquals("'scp' '/path/to/file' ''", $scpTransfer->getCommandString());

        $scpTransfer->source('/path/to/file', 'host');
        $this->assertEquals("'scp' 'host:/path/to/file' ''", $scpTransfer->getCommandString());

        $scpTransfer->source('/path/to/file', 'host', 'user');
        $this->assertEquals("'scp' 'user@host:/path/to/file' ''", $scpTransfer->getCommandString());
    }

    public function testDestination()
    {
        $scpTransfer = new ScpTransfer();
        $return      = $scpTransfer->destination('/path/to/file');
        $this->assertSame($scpTransfer, $return);
        $this->assertEquals("'scp' '' '/path/to/file'", $scpTransfer->getCommandString());

        $scpTransfer->destination('/path/to/file', 'host');
        $this->assertEquals("'scp' '' 'host:/path/to/file'", $scpTransfer->getCommandString());

        $scpTransfer->destination('/path/to/file', 'host', 'user');
        $this->assertEquals("'scp' '' 'user@host:/path/to/file'", $scpTransfer->getCommandString());
    }

    public function testSourceAndDestination()
    {
        $scpTransfer = new ScpTransfer();
        $scpTransfer->source('/path/to/source')
                    ->destination('/path/to/destination');
        $this->assertEquals(
            "'scp' '/path/to/source' '/path/to/destination'",
            $scpTransfer->getCommandString()
        );

        $scpTransfer->source('/path/to/source', 'source')
                    ->destination('/path/to/destination', 'destination');
        $this->assertEquals(
            "'scp' 'source:/path/to/source' 'destination:/path/to/destination'",
            $scpTransfer->getCommandString()
        );

        $scpTransfer->source('/path/to/source', 'source', 'source')
                    ->destination('/path/to/destination', 'destination', 'destination');
        $this->assertEquals(
            "'scp' 'source@source:/path/to/source' 'destination@destination:/path/to/destination'",
            $scpTransfer->getCommandString()
        );
    }

    public function testTransfer()
    {
        mkdir(__DIR__.'/source');
        file_put_contents(__DIR__.'/source/test.txt', 'Hello World');
        mkdir(__DIR__.'/destination');

        $scpTransfer = new ScpTransfer();
        $scpTransfer->source(__DIR__.'/source/test.txt')
                    ->destination(__DIR__.'/destination/')
                    ->transfer();

        $this->assertFileExists(__DIR__.'/destination/test.txt');
        $this->assertFileEquals(__DIR__.'/source/test.txt', __DIR__.'/destination/test.txt');

        unlink(__DIR__.'/destination/test.txt');
        rmdir(__DIR__.'/destination');

        unlink(__DIR__.'/source/test.txt');
        rmdir(__DIR__.'/source');
    }

    public function testLastError()
    {
        $scpTransfer = new ScpTransfer();
        $scpTransfer->source(__DIR__.'/does/not/exist')
            ->destination(__DIR__.'/also/does/not/exist')
            ->transfer();
        $this->assertInstanceOf(ProcessFailedException::class, $scpTransfer->lastError());
    }
}
