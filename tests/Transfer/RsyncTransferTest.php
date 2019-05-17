<?php

namespace Trafficgate\Transferer\Transfer;

use PHPUnit\Framework\TestCase;
use Trafficgate\Transferer\Exceptions\UnimplementedSwitchException;

class RsyncTransferTest extends TestCase
{
    public function testConstruct()
    {
        $rsyncTransfer = new RsyncTransfer();
        $this->assertInstanceOf(RsyncTransfer::class, $rsyncTransfer);
    }

    public function testVerbose()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->verbose();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--verbose' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->verbose($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testInfo()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->info('progress2');
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--info' 'progress2' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->info('stats2,misc1,flist0');
        $this->assertEquals("'rsync' '--info' 'stats2,misc1,flist0' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->info($flags = null, $remove = true);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testDebug()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->debug('none');
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--debug' 'none' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->debug('del2,acl');
        $this->assertEquals("'rsync' '--debug' 'del2,acl' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->debug($flags = null, $remove = true);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testMsgs2StdErr()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->msgs2StdErr();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--msgs2stderr' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->msgs2StdErr($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testQuiet()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->quiet();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--quiet' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->quiet($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testNoMotd()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->noMotd();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--no-motd' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->noMotd($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testChecksum()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->checksum();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--checksum' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->checksum($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testArchive()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->archive();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--archive' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->archive($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testNoOption()
    {
        $switch  = RsyncTransfer::OPTION_NO_OPTION;
        $message = "The switch {$switch} is not yet implemented!";

        $this->expectException(UnimplementedSwitchException::class);
        $this->expectExceptionMessage($message);

        (new RsyncTransfer())->noOption();
    }

    public function testRecursive()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->recursive();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--recursive' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->recursive($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testRelative()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->relative();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--relative' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->relative($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testNoImpliedDirs()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->noImpliedDirs();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--no-implied-dirs' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->noImpliedDirs($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testBackup()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->backup();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--backup' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->backup($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testBackupDir()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->backupDir('../backup');
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--backup-dir' '../backup' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->backupDir('/tmp/backup');
        $this->assertEquals("'rsync' '--backup-dir' '/tmp/backup' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->backupDir($flags = null, $remove = true);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testSuffix()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->suffix('.bak');
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--suffix' '.bak' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->suffix('~');
        $this->assertEquals("'rsync' '--suffix' '~' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->suffix($suffix = null, $remove = true);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testUpdate()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->update();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--update' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->update($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testInplace()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->inplace();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--inplace' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->inplace($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testAppend()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->append();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--append' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->append($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testAppendVerify()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->appendVerify();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--append-verify' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->appendVerify($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testDirs()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->dirs();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--dirs' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->dirs($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testLinks()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->links();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--links' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->links($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testCopyLinks()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->copyLinks();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--copy-links' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->copyLinks($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testCopyUnsafeLinks()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->copyUnsafeLinks();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--copy-unsafe-links' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->copyUnsafeLinks($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testSafeLinks()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->safeLinks();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--safe-links' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->safeLinks($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testMungeLinks()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->mungeLinks();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--munge-links' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->mungeLinks($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testCopyDirlinks()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->copyDirlinks();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--copy-dirlinks' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->copyDirLinks($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testKeepDirlinks()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->keepDirlinks();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--keep-dirlinks' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->keepDirlinks($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testHardLinks()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->hardLinks();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--hard-links' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->hardLinks($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testPerms()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->perms();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--perms' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->perms($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testExecutablility()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->executability();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--executability' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->executability($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testChmod()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->chmod('F0666');
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--chmod' 'F0666' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->chmod('D0755');
        $this->assertEquals("'rsync' '--chmod' 'F0666' '--chmod' 'D0755' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->chmod($mode = 'F0666', $remove = true);
        $this->assertEquals("'rsync' '--chmod' 'D0755' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->chmod($mode = 'D0755', $remove = true);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testAcls()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->acls();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--acls' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->acls($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testXattrs()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->xattrs();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--xattrs' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->xattrs($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testOwner()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->owner();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--owner' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->owner($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testGroup()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->group();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--group' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->group($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testDevices()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->devices();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--devices' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->devices($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testSpecials()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->specials();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--specials' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->specials($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testD()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->d();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '-D' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->d($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testTimes()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->times();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--times' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->times($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testOmitDirTimes()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->omitDirTimes();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--omit-dir-times' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->omitDirTimes($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testOmitLinkTimes()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->omitLinkTimes();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--omit-link-times' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->omitLinkTimes($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testSuper()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->super();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--super' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->super($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testFakeSuper()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->fakeSuper();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--fake-super' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->fakeSuper($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testSparse()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->sparse();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--sparse' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->sparse($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testDropCache()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->dropCache();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--drop-cache' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->dropCache($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testPreallocate()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->preallocate();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--preallocate' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->preallocate($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testDryRun()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->dryRun();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--dry-run' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->dryRun($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testWholeFile()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->wholeFile();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--whole-file' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->wholeFile($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testOneFileSystem()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->oneFileSystem();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--one-file-system' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->oneFileSystem($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testBlockSize()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->blockSize(100);
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--block-size' '100' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->blockSize(200);
        $this->assertEquals("'rsync' '--block-size' '200' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->blockSize($blockSize = null, $remove = true);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testRsh()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->rsh('-e \'ssh -p 2234\'');
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--rsh' '-e '\\''ssh -p 2234'\\''' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->rsh('-e \'ssh -o "ProxyCommand nohup ssh firewall nc -w1 %h %p"\'');
        $this->assertEquals("'rsync' '--rsh' '-e '\\''ssh -o \"ProxyCommand nohup ssh firewall nc -w1 %h %p\"'\\''' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->rsh($command = null, $remove = true);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testRsyncPath()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->rsyncPath('/usr/local/bin/rsync');
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--rsync-path' '/usr/local/bin/rsync' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->rsyncPath('cd /a/b && rsync');
        $this->assertEquals("'rsync' '--rsync-path' 'cd /a/b && rsync' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->rsyncPath($program = null, $remove = true);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testExisting()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->existing();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--existing' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->existing($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testIgnoreNonExisting()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->ignoreNonExisting();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--ignore-non-existing' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->ignoreNonExisting($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testIgnoreExisting()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->ignoreExisting();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--ignore-existing' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->ignoreExisting($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testRemoveSourceFiles()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->removeSourceFiles();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--remove-source-files' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->removeSourceFiles($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testDel()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->del();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--del' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->del($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testDelete()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->delete();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--delete' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->delete($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testDeleteBefore()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->deleteBefore();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--delete-before' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->deleteBefore($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testDeleteDuring()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->deleteDuring();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--delete-during' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->deleteDuring($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testDeleteDelay()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->deleteDelay();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--delete-delay' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->deleteDelay($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testDeleteAfter()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->deleteAfter();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--delete-after' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->deleteAfter($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testDeleteExcluded()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->deleteExcluded();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--delete-excluded' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->deleteExcluded($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testIgnoreMissingArgs()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->ignoreMissingArgs();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--ignore-missing-args' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->ignoreMissingArgs($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testDeleteMissingArgs()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->deleteMissingArgs();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--delete-missing-args' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->deleteMissingArgs($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testIgnoreErrors()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->ignoreErrors();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--ignore-errors' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->ignoreErrors($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testForce()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->force();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--force' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->force($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testMaxDelete()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->maxDelete(15);
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--max-delete' '15' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->maxDelete(30);
        $this->assertEquals("'rsync' '--max-delete' '30' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->maxDelete($num = null, $remove = true);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testMaxSize()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->maxSize('1.5mb-1');
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--max-size' '1.5mb-1' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->maxSize('2g+1');
        $this->assertEquals("'rsync' '--max-size' '2g+1' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->maxSize($size = null, $remove = true);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testMinSize()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->minSize('2g+1');
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--min-size' '2g+1' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->minSize('1.5mb-1');
        $this->assertEquals("'rsync' '--min-size' '1.5mb-1' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->minSize($size = null, $remove = true);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testPartial()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->partial();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--partial' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->partial($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testPartialDir()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->partialDir('.rsync-partial');
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--partial-dir' '.rsync-partial' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->partialDir('.rsync-tmp');
        $this->assertEquals("'rsync' '--partial-dir' '.rsync-tmp' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->partialDir($dir = null, $remove = true);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testDelayUpdates()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->delayUpdates();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--delay-updates' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->delayUpdates($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testPruneEmptyDirs()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->pruneEmptyDirs();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--prune-empty-dirs' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->pruneEmptyDirs($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testNumericIds()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->numericIds();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--numeric-ids' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->numericIds($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testUsermap()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->usermap('0-99:nobody,wayne:admin,*:normal');
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--usermap' '0-99:nobody,wayne:admin,*:normal' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->usermap(':nobody');
        $this->assertEquals("'rsync' '--usermap' ':nobody' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->usermap($string = null, $remove = true);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testGroupmap()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->groupmap('usr:1,1:usr');
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--groupmap' 'usr:1,1:usr' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->groupmap('*:nobody');
        $this->assertEquals("'rsync' '--groupmap' '*:nobody' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->groupmap($string = null, $remove = true);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testChown()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->chown('foo');
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--chown' 'foo' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->chown(':bar');
        $this->assertEquals("'rsync' '--chown' ':bar' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->chown('foo:bar');
        $this->assertEquals("'rsync' '--chown' 'foo:bar' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->chown($chown = null, $remove = true);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testTimeout()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->timeout(30);
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--timeout' '30' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->timeout(60);
        $this->assertEquals("'rsync' '--timeout' '60' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->timeout($timeout = null, $remove = true);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testContimeout()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->contimeout(10);
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--contimeout' '10' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->contimeout(50);
        $this->assertEquals("'rsync' '--contimeout' '50' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->contimeout($contimeout = null, $remove = true);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testIgnoreTimes()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->ignoreTimes();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--ignore-times' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->ignoreTimes($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testSizeOnly()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->sizeOnly();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--size-only' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->sizeOnly($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testModifyWindow()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->modifyWindow(1);
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--modify-window' '1' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->modifyWindow(0);
        $this->assertEquals("'rsync' '--modify-window' '0' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->modifyWindow($time = null, $remove = true);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testTempDir()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->tempDir('/dev/mnt/tmp');
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--temp-dir' '/dev/mnt/tmp' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->tempDir('/dev/mnt/tmpfs');
        $this->assertEquals("'rsync' '--temp-dir' '/dev/mnt/tmpfs' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->tempDir($dir = null, $remove = true);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testFuzzy()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->fuzzy();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--fuzzy' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->fuzzy($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testCompareDest()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->compareDest('/tmp');
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--compare-dest' '/tmp' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->compareDest('/another');
        $this->assertEquals("'rsync' '--compare-dest' '/another' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->compareDest($dir = null, $remove = true);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testCopyDest()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->copyDest('/tmp');
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--copy-dest' '/tmp' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->copyDest('../rsync-copy');
        $this->assertEquals("'rsync' '--copy-dest' '../rsync-copy' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->copyDest($dir = null, $remove = true);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testLinkDest()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->linkDest('$PWD/prior_dir');
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--link-dest' '\$PWD/prior_dir' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->linkDest('../rsync-copy');
        $this->assertEquals("'rsync' '--link-dest' '../rsync-copy' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->linkDest($dir = null, $remove = true);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testCompress()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->compress();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--compress' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->compress($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testCompressLevel()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->compressLevel(1);
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--compress-level' '1' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->compressLevel(9);
        $this->assertEquals("'rsync' '--compress-level' '9' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->compressLevel($num = null, $remove = true);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testSkipCompress()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->skipCompress('gz/jpg/mp[34]/7z/bz2');
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--skip-compress' 'gz/jpg/mp[34]/7z/bz2' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->skipCompress('gz/jpg');
        $this->assertEquals("'rsync' '--skip-compress' 'gz/jpg' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->skipCompress($list = null, $remove = true);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testCvsExclude()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->cvsExclude();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--cvs-exclude' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->cvsExclude($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testFilter()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->filter('! */');
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--filter' '! */' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->filter('-p .DS_Store');
        $this->assertEquals("'rsync' '--filter' '! */' '--filter' '-p .DS_Store' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->filter($pattern = '! */', $remove = true);
        $this->assertEquals("'rsync' '--filter' '-p .DS_Store' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->filter($pattern = '-p .DS_Store', $remove = true);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testF()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->f();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '-F' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->f($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testExclude()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->exclude('file1.txt');
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--exclude' 'file1.txt' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->exclude('dir3/file4.txt');
        $this->assertEquals("'rsync' '--exclude' 'file1.txt' '--exclude' 'dir3/file4.txt' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->exclude($pattern = 'file1.txt', $remove = true);
        $this->assertEquals("'rsync' '--exclude' 'dir3/file4.txt' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->exclude($pattern = 'dir3/file4.txt', $remove = true);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testExcludeFrom()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->excludeFrom('../exclusions.txt');
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--exclude-from' '../exclusions.txt' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->excludeFrom('../other-exclusions.txt');
        $this->assertEquals("'rsync' '--exclude-from' '../other-exclusions.txt' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->excludeFrom($file = null, $remove = true);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testIncludeFile()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->includeFile('file1.txt');
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--include' 'file1.txt' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->includeFile('dir3/file4.txt');
        $this->assertEquals("'rsync' '--include' 'file1.txt' '--include' 'dir3/file4.txt' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->includeFile($mode = 'file1.txt', $remove = true);
        $this->assertEquals("'rsync' '--include' 'dir3/file4.txt' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->includeFile($mode = 'dir3/file4.txt', $remove = true);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testIncludeFrom()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->includeFrom('../inclusions.txt');
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--include-from' '../inclusions.txt' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->includeFrom('../other-inclusions.txt');
        $this->assertEquals("'rsync' '--include-from' '../other-inclusions.txt' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->includeFrom($file = null, $remove = true);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testFilesFrom()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->filesFrom('/tmp/foo');
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--files-from' '/tmp/foo' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->filesFrom(':/path/file-list');
        $this->assertEquals("'rsync' '--files-from' ':/path/file-list' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->filesFrom($file = null, $remove = true);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testFromZero()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->fromZero();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--from0' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->fromZero($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testProtectArgs()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->protectArgs();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--protect-args' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->protectArgs($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testAddress()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->address('127.0.0.1');
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--address' '127.0.0.1' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->address('192.168.1.100');
        $this->assertEquals("'rsync' '--address' '192.168.1.100' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->address($address = null, $remove = true);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testPort()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->port(873);
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--port' '873' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->port(8873);
        $this->assertEquals("'rsync' '--port' '8873' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->port($address = null, $remove = true);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testSockopts()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->sockopts('SO_SNDBUF=65536,SO_RCVBUF=65536');
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--sockopts' 'SO_SNDBUF=65536,SO_RCVBUF=65536' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->sockopts('SO_SNDBUF=128000,SO_RCVBUF=128000');
        $this->assertEquals("'rsync' '--sockopts' 'SO_SNDBUF=128000,SO_RCVBUF=128000' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->sockopts($address = null, $remove = true);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testBlockingIo()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->blockingIo();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--blocking-io' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->blockingIo($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testOutbuf()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->outbuf('line');
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--outbuf' 'line' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->outbuf('block');
        $this->assertEquals("'rsync' '--outbuf' 'block' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->outbuf($mode = null, $remove = true);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testStats()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->stats();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--stats' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->stats($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testEightBitOutput()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->eightBitOutput();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--8-bit-output' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->eightBitOutput($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testHumanReadable()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->humanReadable();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--human-readable' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->humanReadable($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testProgress()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->progress();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--progress' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->progress($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testP()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->p();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '-P' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->p($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testItemizeChanges()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->itemizeChanges();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--itemize-changes' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->itemizeChanges($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testRemoteOption()
    {
        $switch  = RsyncTransfer::OPTION_REMOTE_OPTION;
        $message = "The switch {$switch} is not yet implemented!";

        $this->expectException(UnimplementedSwitchException::class);
        $this->expectExceptionMessage($message);

        (new RsyncTransfer())->remoteOption();
    }

    public function testOutFormat()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->outFormat('%n%L');
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--out-format' '%n%L' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->outFormat('%t %f %b');
        $this->assertEquals("'rsync' '--out-format' '%t %f %b' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->outFormat($format = null, $remove = true);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testLogFile()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->logFile('/tmp/rlog');
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--log-file' '/tmp/rlog' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->logFile('/tmp/rlog2');
        $this->assertEquals("'rsync' '--log-file' '/tmp/rlog2' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->logFile($file = null, $remove = true);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testLogFileFormat()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->logFileFormat('%n%L');
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--log-file-format' '%n%L' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->logFileFormat('%t %f %b');
        $this->assertEquals("'rsync' '--log-file-format' '%t %f %b' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->logFileFormat($format = null, $remove = true);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testPasswordFile()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->passwordFile('/root/rsync-password');
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--password-file' '/root/rsync-password' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->passwordFile('/root/rsync-password2');
        $this->assertEquals("'rsync' '--password-file' '/root/rsync-password2' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->passwordFile($file = null, $remove = true);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testListOnly()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->listOnly();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--list-only' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->listOnly($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testBwLimit()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->bwLimit('1.5m');
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--bwlimit' '1.5m' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->bwLimit('100m');
        $this->assertEquals("'rsync' '--bwlimit' '100m' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->bwLimit($rate = null, $remove = true);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testWriteBatch()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->writeBatch('write-batch.log');
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--write-batch' 'write-batch.log' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->writeBatch('../batch.log');
        $this->assertEquals("'rsync' '--write-batch' '../batch.log' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->writeBatch($file = null, $remove = true);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testOnlyWriteBatch()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->onlyWriteBatch('write-batch.log');
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--only-write-batch' 'write-batch.log' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->onlyWriteBatch('../batch.log');
        $this->assertEquals("'rsync' '--only-write-batch' '../batch.log' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->onlyWriteBatch($file = null, $remove = true);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testReadBatch()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->readBatch('write-batch.log');
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--read-batch' 'write-batch.log' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->readBatch('../batch.log');
        $this->assertEquals("'rsync' '--read-batch' '../batch.log' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->readBatch($file = null, $remove = true);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testProtocol()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->protocol(28);
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--protocol' '28' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->protocol(30);
        $this->assertEquals("'rsync' '--protocol' '30' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->protocol($num = null, $remove = true);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testIconv()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->iconv('utf8');
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--iconv' 'utf8' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->iconv('euc_jp');
        $this->assertEquals("'rsync' '--iconv' 'euc_jp' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->iconv($convertSpec = null, $remove = true);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testChecksumSeed()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->checksumSeed(32761);
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--checksum-seed' '32761' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->checksumSeed(54321);
        $this->assertEquals("'rsync' '--checksum-seed' '54321' \"\" \"\"", $rsyncTransfer->getCommandString());

        $rsyncTransfer->checksumSeed($num = null, $remove = true);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testIpv4()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->ipv4();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--ipv4' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->ipv4($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testIpv6()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->ipv6();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--ipv6' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->ipv6($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testVersion()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->version();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--version' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->version($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }

    public function testHelp()
    {
        $rsyncTransfer = new RsyncTransfer();
        $return        = $rsyncTransfer->help();
        $this->assertSame($rsyncTransfer, $return);
        $this->assertEquals("'rsync' '--help' \"\" \"\"", $rsyncTransfer->getCommandString());
        $rsyncTransfer->help($enable = false);
        $this->assertEquals("'rsync' \"\" \"\"", $rsyncTransfer->getCommandString());
    }
}
