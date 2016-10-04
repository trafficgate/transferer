<?php

namespace Trafficgate\Util;

use PHPUnit_Framework_TestCase;

class DataSourceNameTest extends PHPUnit_Framework_TestCase
{
    public function testJoinNoUserNoHostNoPath()
    {
        $user = null;
        $host = null;
        $path = null;

        $dsn = DataSourceName::join($path, $host, $user);
        $this->assertEquals('', $dsn);
    }

    public function testJoinNoHostNoPath()
    {
        $user = 'user';
        $host = null;
        $path = null;

        $dsn = DataSourceName::join($path, $host, $user);
        $this->assertEquals('', $dsn);
    }

    public function testJoinNoUserNoPath()
    {
        $user = null;
        $host = 'host';
        $path = null;

        $dsn = DataSourceName::join($path, $host, $user);
        $this->assertEquals('', $dsn);
    }

    public function testJoinNoPath()
    {
        $user = 'user';
        $host = 'host';
        $path = null;

        $dsn = DataSourceName::join($path, $host, $user);
        $this->assertEquals('', $dsn);
    }

    public function testJoinNoUserNoHost()
    {
        $user = null;
        $host = null;
        $path = 'path';

        $dsn = DataSourceName::join($path, $host, $user);
        $this->assertEquals('path', $dsn);
    }

    public function testJoinNoUser()
    {
        $user = null;
        $host = 'host';
        $path = 'path';

        $dsn = DataSourceName::join($path, $host, $user);
        $this->assertEquals('host:path', $dsn);
    }

    public function testJoinNoHost()
    {
        $user = 'user';
        $host = null;
        $path = 'path';

        $dsn = DataSourceName::join($path, $host, $user);
        $this->assertEquals('path', $dsn);
    }

    public function testJoin()
    {
        $user = 'user';
        $host = 'host';
        $path = 'path';

        $dsn = DataSourceName::join($path, $host, $user);
        $this->assertEquals('user@host:path', $dsn);
    }

    public function testSplitNoUserNoHostNoPath()
    {
        $dsn = '';

        list($user, $host, $path) = DataSourceName::split($dsn);
        $this->assertEquals('', $user);
        $this->assertEquals('', $host);
        $this->assertEquals('', $path);
    }

    public function testSplitNoHostNoPath()
    {
        $dsn = 'user@';

        list($user, $host, $path) = DataSourceName::split($dsn);
        $this->assertEquals('user', $user);
        $this->assertEquals('', $host);
        $this->assertEquals('', $path);
    }

    public function testSplitNoUserNoPath()
    {
        $dsn = 'host:';

        list($user, $host, $path) = DataSourceName::split($dsn);
        $this->assertEquals('', $user);
        $this->assertEquals('host', $host);
        $this->assertEquals('', $path);
    }

    public function testSplitNoPath()
    {
        $dsn = 'user@host:';

        list($user, $host, $path) = DataSourceName::split($dsn);
        $this->assertEquals('user', $user);
        $this->assertEquals('host', $host);
        $this->assertEquals('', $path);
    }

    public function testSplitNoUserNoHost()
    {
        $dsn = 'path';

        list($user, $host, $path) = DataSourceName::split($dsn);
        $this->assertEquals('', $user);
        $this->assertEquals('', $host);
        $this->assertEquals('path', $path);
    }

    public function testSplitNoUser()
    {
        $dsn = 'host:path';

        list($user, $host, $path) = DataSourceName::split($dsn);
        $this->assertEquals('', $user);
        $this->assertEquals('host', $host);
        $this->assertEquals('path', $path);
    }

    public function testSplitNoHost()
    {
        $dsn = 'user@path';

        list($user, $host, $path) = DataSourceName::split($dsn);
        $this->assertEquals('user', $user);
        $this->assertEquals('', $host);
        $this->assertEquals('path', $path);
    }

    public function testSplit()
    {
        $dsn = 'user@host:path';

        list($user, $host, $path) = DataSourceName::split($dsn);
        $this->assertEquals('user', $user);
        $this->assertEquals('host', $host);
        $this->assertEquals('path', $path);
    }
}
