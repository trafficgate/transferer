<?php

namespace Trafficgate\Transferer\Daemon;

use Trafficgate\Transferer\CommandTestCase;

class RsyncDaemonTest extends CommandTestCase
{
    public function testConstruct()
    {
        $rsyncDaemon = new RsyncDaemon();
        $this->assertInstanceOf(RsyncDaemon::class, $rsyncDaemon);
    }

    public function testDaemon()
    {
        $rsyncDaemon = new RsyncDaemon();
        $return      = $rsyncDaemon->daemon($enable = false);
        $this->assertSame($rsyncDaemon, $return);
        $this->assertEquals("'rsync' {$this->emptyQuotes} {$this->emptyQuotes}", $rsyncDaemon->getCommandString());

        $rsyncDaemon->daemon();
        $this->assertEquals("'rsync' '--daemon' {$this->emptyQuotes} {$this->emptyQuotes}", $rsyncDaemon->getCommandString());
    }

    public function testAddress()
    {
        $rsyncDaemon = new RsyncDaemon();
        $return      = $rsyncDaemon->address('127.0.0.1');
        $this->assertSame($rsyncDaemon, $return);
        $this->assertEquals("'rsync' '--address' '127.0.0.1' '--daemon' {$this->emptyQuotes} {$this->emptyQuotes}", $rsyncDaemon->getCommandString());

        $rsyncDaemon->address('192.168.1.100');
        $this->assertEquals("'rsync' '--address' '192.168.1.100' '--daemon' {$this->emptyQuotes} {$this->emptyQuotes}", $rsyncDaemon->getCommandString());

        $rsyncDaemon->address($address = null, $remove = true);
        $this->assertEquals("'rsync' '--daemon' {$this->emptyQuotes} {$this->emptyQuotes}", $rsyncDaemon->getCommandString());
    }

    public function testBwLimit()
    {
        $rsyncDaemon = new RsyncDaemon();
        $return      = $rsyncDaemon->bwLimit('1.5m');
        $this->assertSame($rsyncDaemon, $return);
        $this->assertEquals("'rsync' '--bwlimit' '1.5m' '--daemon' {$this->emptyQuotes} {$this->emptyQuotes}", $rsyncDaemon->getCommandString());

        $rsyncDaemon->bwLimit('100m');
        $this->assertEquals("'rsync' '--bwlimit' '100m' '--daemon' {$this->emptyQuotes} {$this->emptyQuotes}", $rsyncDaemon->getCommandString());

        $rsyncDaemon->bwLimit($rate = null, $remove = true);
        $this->assertEquals("'rsync' '--daemon' {$this->emptyQuotes} {$this->emptyQuotes}", $rsyncDaemon->getCommandString());
    }

    public function testConfig()
    {
        $rsyncDaemon = new RsyncDaemon();
        $return      = $rsyncDaemon->config('/etc/rsyncd.conf');
        $this->assertSame($rsyncDaemon, $return);
        $this->assertEquals("'rsync' '--daemon' '--config' '/etc/rsyncd.conf' {$this->emptyQuotes} {$this->emptyQuotes}", $rsyncDaemon->getCommandString());

        $rsyncDaemon->config('/home/user/rsyncd.conf');
        $this->assertEquals("'rsync' '--daemon' '--config' '/home/user/rsyncd.conf' {$this->emptyQuotes} {$this->emptyQuotes}", $rsyncDaemon->getCommandString());

        $rsyncDaemon->config($file = null, $remove = true);
        $this->assertEquals("'rsync' '--daemon' {$this->emptyQuotes} {$this->emptyQuotes}", $rsyncDaemon->getCommandString());
    }

    public function testDparam()
    {
        $rsyncDaemon = new RsyncDaemon();
        $return      = $rsyncDaemon->dparam('pidfile=/path/rsync.pid');
        $this->assertSame($rsyncDaemon, $return);
        $this->assertEquals("'rsync' '--daemon' '--dparam' 'pidfile=/path/rsync.pid' {$this->emptyQuotes} {$this->emptyQuotes}", $rsyncDaemon->getCommandString());

        $rsyncDaemon->dparam('motdfile=/path/motd');
        $this->assertEquals("'rsync' '--daemon' '--dparam' 'pidfile=/path/rsync.pid' '--dparam' 'motdfile=/path/motd' {$this->emptyQuotes} {$this->emptyQuotes}", $rsyncDaemon->getCommandString());

        $rsyncDaemon->dparam('pidfile=/path/rsync.pid', $remove = true);
        $this->assertEquals("'rsync' '--daemon' '--dparam' 'motdfile=/path/motd' {$this->emptyQuotes} {$this->emptyQuotes}", $rsyncDaemon->getCommandString());

        $rsyncDaemon->dparam('motdfile=/path/motd', $remove = true);
        $this->assertEquals("'rsync' '--daemon' {$this->emptyQuotes} {$this->emptyQuotes}", $rsyncDaemon->getCommandString());
    }

    public function testNoDetach()
    {
        $rsyncDaemon = new RsyncDaemon();
        $return      = $rsyncDaemon->noDetach();
        $this->assertSame($rsyncDaemon, $return);
        $this->assertEquals("'rsync' '--daemon' '--no-detach' {$this->emptyQuotes} {$this->emptyQuotes}", $rsyncDaemon->getCommandString());
        $rsyncDaemon->noDetach($enable = false);
        $this->assertEquals("'rsync' '--daemon' {$this->emptyQuotes} {$this->emptyQuotes}", $rsyncDaemon->getCommandString());
    }

    public function testPort()
    {
        $rsyncDaemon = new RsyncDaemon();
        $return      = $rsyncDaemon->port(873);
        $this->assertSame($rsyncDaemon, $return);
        $this->assertEquals("'rsync' '--port' '873' '--daemon' {$this->emptyQuotes} {$this->emptyQuotes}", $rsyncDaemon->getCommandString());

        $rsyncDaemon->port(8873);
        $this->assertEquals("'rsync' '--port' '8873' '--daemon' {$this->emptyQuotes} {$this->emptyQuotes}", $rsyncDaemon->getCommandString());

        $rsyncDaemon->port($address = null, $remove = true);
        $this->assertEquals("'rsync' '--daemon' {$this->emptyQuotes} {$this->emptyQuotes}", $rsyncDaemon->getCommandString());
    }

    public function testLogFile()
    {
        $rsyncDaemon = new RsyncDaemon();
        $return      = $rsyncDaemon->logFile('/tmp/rlog');
        $this->assertSame($rsyncDaemon, $return);
        $this->assertEquals("'rsync' '--log-file' '/tmp/rlog' '--daemon' {$this->emptyQuotes} {$this->emptyQuotes}", $rsyncDaemon->getCommandString());

        $rsyncDaemon->logFile('/tmp/rlog2');
        $this->assertEquals("'rsync' '--log-file' '/tmp/rlog2' '--daemon' {$this->emptyQuotes} {$this->emptyQuotes}", $rsyncDaemon->getCommandString());

        $rsyncDaemon->logFile($file = null, $remove = true);
        $this->assertEquals("'rsync' '--daemon' {$this->emptyQuotes} {$this->emptyQuotes}", $rsyncDaemon->getCommandString());
    }

    public function testLogFileFormat()
    {
        $rsyncDaemon = new RsyncDaemon();
        $return      = $rsyncDaemon->logFileFormat('%n%L');
        $this->assertSame($rsyncDaemon, $return);
        $this->assertEquals("'rsync' '--log-file-format' '%n%L' '--daemon' {$this->emptyQuotes} {$this->emptyQuotes}", $rsyncDaemon->getCommandString());

        $rsyncDaemon->logFileFormat('%t %f %b');
        $this->assertEquals("'rsync' '--log-file-format' '%t %f %b' '--daemon' {$this->emptyQuotes} {$this->emptyQuotes}", $rsyncDaemon->getCommandString());

        $rsyncDaemon->logFileFormat($format = null, $remove = true);
        $this->assertEquals("'rsync' '--daemon' {$this->emptyQuotes} {$this->emptyQuotes}", $rsyncDaemon->getCommandString());
    }

    public function testSockopts()
    {
        $rsyncDaemon = new RsyncDaemon();
        $return      = $rsyncDaemon->sockopts('SO_SNDBUF=65536,SO_RCVBUF=65536');
        $this->assertSame($rsyncDaemon, $return);
        $this->assertEquals("'rsync' '--sockopts' 'SO_SNDBUF=65536,SO_RCVBUF=65536' '--daemon' {$this->emptyQuotes} {$this->emptyQuotes}", $rsyncDaemon->getCommandString());

        $rsyncDaemon->sockopts('SO_SNDBUF=128000,SO_RCVBUF=128000');
        $this->assertEquals("'rsync' '--sockopts' 'SO_SNDBUF=128000,SO_RCVBUF=128000' '--daemon' {$this->emptyQuotes} {$this->emptyQuotes}", $rsyncDaemon->getCommandString());

        $rsyncDaemon->sockopts($address = null, $remove = true);
        $this->assertEquals("'rsync' '--daemon' {$this->emptyQuotes} {$this->emptyQuotes}", $rsyncDaemon->getCommandString());
    }

    public function testVerbose()
    {
        $rsyncDaemon = new RsyncDaemon();
        $return      = $rsyncDaemon->verbose();
        $this->assertSame($rsyncDaemon, $return);
        $this->assertEquals("'rsync' '--verbose' '--daemon' {$this->emptyQuotes} {$this->emptyQuotes}", $rsyncDaemon->getCommandString());
        $rsyncDaemon->verbose($enable = false);
        $this->assertEquals("'rsync' '--daemon' {$this->emptyQuotes} {$this->emptyQuotes}", $rsyncDaemon->getCommandString());
    }

    public function testIpv4()
    {
        $rsyncDaemon = new RsyncDaemon();
        $return      = $rsyncDaemon->ipv4();
        $this->assertSame($rsyncDaemon, $return);
        $this->assertEquals("'rsync' '--ipv4' '--daemon' {$this->emptyQuotes} {$this->emptyQuotes}", $rsyncDaemon->getCommandString());
        $rsyncDaemon->ipv4($enable = false);
        $this->assertEquals("'rsync' '--daemon' {$this->emptyQuotes} {$this->emptyQuotes}", $rsyncDaemon->getCommandString());
    }

    public function testIpv6()
    {
        $rsyncDaemon = new RsyncDaemon();
        $return      = $rsyncDaemon->ipv6();
        $this->assertSame($rsyncDaemon, $return);
        $this->assertEquals("'rsync' '--ipv6' '--daemon' {$this->emptyQuotes} {$this->emptyQuotes}", $rsyncDaemon->getCommandString());
        $rsyncDaemon->ipv6($enable = false);
        $this->assertEquals("'rsync' '--daemon' {$this->emptyQuotes} {$this->emptyQuotes}", $rsyncDaemon->getCommandString());
    }

    public function testHelp()
    {
        $rsyncDaemon = new RsyncDaemon();
        $return      = $rsyncDaemon->help();
        $this->assertSame($rsyncDaemon, $return);
        $this->assertEquals("'rsync' '--help' '--daemon' {$this->emptyQuotes} {$this->emptyQuotes}", $rsyncDaemon->getCommandString());
        $rsyncDaemon->help($enable = false);
        $this->assertEquals("'rsync' '--daemon' {$this->emptyQuotes} {$this->emptyQuotes}", $rsyncDaemon->getCommandString());
    }
}
