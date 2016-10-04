<?php

namespace Trafficgate\Console\Commands;

use Illuminate\Console\Command;
use Trafficgate\Transfer\RsyncTransfer;
use Trafficgate\Util\DataSourceName;

class Rsync extends Command
{
    /**
     * The command signature.
     *
     * @var string
     */
    protected $signature = 'rsync
                            {--command-timeout= : time before considering the command failed}
                            {--retry-limit=1 : number of times to retry a failed command}
                            {--info= : fine-grained informational verbosity}
                            {--debug= : fine-grained debug verbosity}
                            {--msgs2stderr : special output handling for debugging}
                            {--q|quiet : suppress non-error messages}
                            {--no-motd : suppress daemon-mode MOTD (see caveat)}
                            {--c|checksum : skip based on checksum, not mod-time & size}
                            {--a|archive : archive mode; equals -rlptgoD (no -H,-A,-X)}
                            {--no- : turn off an implied OPTION (e.g. --no-D)}
                            {--r|recursive : recurse into directories}
                            {--R|relative : use relative path names}
                            {--no-implied-dirs : don’t send implied dirs with --relative}
                            {--b|backup : make backups (see --suffix & --backup-dir)}
                            {--backup-dir= : make backups into hierarchy based in DIR}
                            {--suffix= : backup suffix (default ~ w/o --backup-dir)}
                            {--u|update : skip files that are newer on the receiver}
                            {--inplace : update destination files in-place}
                            {--append : append data onto shorter files}
                            {--append-verify : --append w/old data in file checksum}
                            {--d|dirs : transfer directories without recursing}
                            {--l|links : copy symlinks as symlinks}
                            {--L|copy-links : transform symlink into referent file/dir}
                            {--copy-unsafe-links : only "unsafe" symlinks are transformed}
                            {--safe-links : ignore symlinks that point outside the tree}
                            {--munge-links : munge symlinks to make them safer}
                            {--k|copy-dirlinks : transform symlink to dir into referent dir}
                            {--K|keep-dirlinks : treat symlinked dir on receiver as dir}
                            {--H|hard-links : preserve hard links}
                            {--p|perms : preserve permissions}
                            {--E|executability : preserve executability}
                            {--chmod= : affect file and/or directory permissions}
                            {--A|acls : preserve ACLs (implies -p)}
                            {--X|xattrs : preserve extended attributes}
                            {--o|owner : preserve owner (super-user only)}
                            {--g|group : preserve group}
                            {--devices : preserve device files (super-user only)}
                            {--specials : preserve special files}
                            {-D : same as --devices --specials}
                            {--t|times : preserve modification times}
                            {--O|omit-dir-times : omit directories from --times}
                            {--J|omit-link-times : omit symlinks from --times}
                            {--super : receiver attempts super-user activities}
                            {--fake-super : store/recover privileged attrs using xattrs}
                            {--S|sparse : handle sparse files efficiently}
                            {--drop-cache : drop cache continuously using fadvise}
                            {--preallocate : allocate dest files before writing}
                            {--dry-run : perform a trial run with no changes made}
                            {--W|whole-file : copy files whole (w/o delta-xfer algorithm)}
                            {--x|one-file-system : don\'t cross filesystem boundaries}
                            {--B|block-size= : force a fixed checksum block-size}
                            {--e|rsh= : specify the remote shell to use}
                            {--rsync-path= : specify the rsync to run on remote machine}
                            {--existing : skip creating new files on receiver}
                            {--ignore-non-existing : skip creating new files on receiver}
                            {--ignore-existing : skip updating files that exist on receiver}
                            {--remove-source-files : sender removes synchronized files (non-dir)}
                            {--del : an alias for --delete-during}
                            {--delete : delete extraneous files from dest dirs}
                            {--delete-before : receiver deletes before xfer, not during}
                            {--delete-during : receiver deletes during the transfer}
                            {--delete-delay : find deletions during, delete after}
                            {--delete-after : receiver deletes after transfer, not during}
                            {--delete-excluded : also delete excluded files from dest dirs}
                            {--ignore-missing-args : ignore missing source args without error}
                            {--delete-missing-args : delete missing source args from destination}
                            {--ignore-errors : delete even if there are I/O errors}
                            {--force : force deletion of dirs even if not empty}
                            {--max-delete= : don\'t delete more than NUM files}
                            {--max-size= : don\'t transfer any file larger than SIZE}
                            {--min-size= : don\'t transfer any file smaller than SIZE}
                            {--partial : keep partially transferred files}
                            {--partial-dir= : put a partially transferred file into DIR}
                            {--delay-updates : put all updated files into place at end}
                            {--m|prune-empty-dirs : prune empty directory chains from file-list}
                            {--numeric-ids : don\'t map uid/gid values by user/group name}
                            {--usermap= : custom username mapping}
                            {--groupmap= : custom groupname mapping}
                            {--chown= : simple username/groupname mapping}
                            {--timeout= : set I/O timeout in seconds}
                            {--contimeout= : set daemon connection timeout in seconds}
                            {--I|ignore-times : don\'t skip files that match size and time}
                            {--size-only : skip files that match in size}
                            {--modify-window= : compare mod-times with reduced accuracy}
                            {--T|temp-dir= : create temporary files in directory DIR}
                            {--y|fuzzy : find similar file for basis if no dest file}
                            {--compare-dest= : also compare received files relative to DIR}
                            {--copy-dest= : ... and include copies of unchanged files}
                            {--link-dest= : hardlink to files in DIR when unchanged}
                            {--compress : compress file data during the transfer}
                            {--compress-level= : explicitly set compression level}
                            {--skip-compress= : skip compressing files with suffix in LIST}
                            {--C|cvs-exclude : auto-ignore files in the same way CVS does}
                            {--f|filter= : add a file-filtering RULE}
                            {-F : same as --filter=\'dir-merge ./rsync-filter\'}
                            {--exclude= : exclude files matching PATTERN}
                            {--exclude-from= : read exclude file patterns from FILE}
                            {--include= : don\'t exclude files matching PATTERN}
                            {--include-from= : read include patterns from FILE}
                            {--files-from= : read list of source-file names from FILE}
                            {--0|from0 : all *from/filter files are delimited by 0s}
                            {--s|protect-args : no space-splitting; wildcard chars allowed}
                            {--address= : bind address for outgoing socket to daemon}
                            {--port= : specify double-colon alternate port number}
                            {--sockopts= : specify custom TCP options}
                            {--blocking-io : use blocking I/O for the remote shell}
                            {--outbuf= : set out buffering to (N)one, (L)ine, or (B)lock}
                            {--stats : give some file-transfer stats}
                            {--8|8-bit-output : leave high-bit chars unescaped in output}
                            {--human-readable : output numbers in a human-readable format}
                            {--progress : show progress during transfer}
                            {-P : same as --partial --progress}
                            {--i|itemize-changes : output a change-summary for all updates}
                            {--M|remote-option= : send OPTION to the remote side only}
                            {--out-format= : output updates using the specified FORMAT}
                            {--log-file= : log what we\'re doing to the specified FILE}
                            {--log-file-format= : log updates using the specified FMT}
                            {--password-file= : read daemon-access password from FILE}
                            {--list-only : list the files instead of copying them}
                            {--bwlimit= : limit socket I/O bandwidth}
                            {--write-batch= : write a batched update to FILE}
                            {--only-write-batch=}
                            {--read-batch= : read a batched update from FILE}
                            {--protocol= : force an older protocol version to be used}
                            {--iconv= : request charset conversion of filenames}
                            {--checksum-seed= : set block/file checksum seed (advanced)}
                            {--4|ipv4 : prefer IPv4}
                            {--6|ipv6 : prefer IPv6}
                            {source}
                            {destination}';

    /**
     * The command description.
     *
     * @var string
     */
    protected $description = 'Rsync syncs files between hosts on a network.';

    /**
     * @var RsyncTransfer
     */
    protected $rsync;

    /**
     * @param RsyncTransfer $rsync
     */
    public function __construct(RsyncTransfer $rsync)
    {
        parent::__construct();
        $this->setRsync($rsync);
    }

    /**
     * Get the rsync transfer command.
     *
     * @return RsyncTransfer
     */
    protected function getRsync()
    {
        return $this->rsync;
    }

    /**
     * Set the rsync transfer command.
     *
     * @param RsyncTransfer $rsync
     */
    protected function setRsync(RsyncTransfer $rsync)
    {
        $this->rsync = $rsync;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $commandTimeout    = $this->option('command-timeout');
        $retryLimit        = $this->option('retry-limit');
        $verbose           = $this->option('verbose');
        $info              = $this->option('info');
        $debug             = $this->option('debug');
        $msgs2stderr       = $this->option('msgs2stderr');
        $quiet             = $this->option('quiet');
        $noMotd            = $this->option('no-motd');
        $checksum          = $this->option('checksum');
        $archive           = $this->option('archive');
        $recursive         = $this->option('recursive');
        $relative          = $this->option('relative');
        $noImpliedDirs     = $this->option('no-implied-dirs');
        $backup            = $this->option('backup');
        $backupDir         = $this->option('backup-dir');
        $suffix            = $this->option('suffix');
        $update            = $this->option('update');
        $inplace           = $this->option('inplace');
        $append            = $this->option('append');
        $appendVerify      = $this->option('append-verify');
        $dirs              = $this->option('dirs');
        $links             = $this->option('links');
        $copyLinks         = $this->option('copy-links');
        $copyUnsafeLinks   = $this->option('copy-unsafe-links');
        $safeLinks         = $this->option('safe-links');
        $mungeLinks        = $this->option('munge-links');
        $copyDirlinks      = $this->option('copy-dirlinks');
        $keepDirlinks      = $this->option('keep-dirlinks');
        $hardLinks         = $this->option('hard-links');
        $perms             = $this->option('perms');
        $executability     = $this->option('executability');
        $chmod             = $this->option('chmod');
        $acls              = $this->option('acls');
        $xattrs            = $this->option('xattrs');
        $owner             = $this->option('owner');
        $group             = $this->option('group');
        $devices           = $this->option('devices');
        $specials          = $this->option('specials');
        $d                 = $this->option('D');
        $times             = $this->option('times');
        $omitDirTimes      = $this->option('omit-dir-times');
        $omitLinkTimes     = $this->option('omit-link-times');
        $super             = $this->option('super');
        $fakeSuper         = $this->option('fake-super');
        $sparse            = $this->option('sparse');
        $dropCache         = $this->option('drop-cache');
        $preallocate       = $this->option('preallocate');
        $dryRun            = $this->option('dry-run');
        $wholeFile         = $this->option('whole-file');
        $oneFileSystem     = $this->option('one-file-system');
        $blockSize         = $this->option('block-size');
        $rsh               = $this->option('rsh');
        $rsyncPath         = $this->option('rsync-path');
        $existing          = $this->option('existing');
        $ignoreNonExisting = $this->option('ignore-non-existing');
        $ignoreExisting    = $this->option('ignore-existing');
        $removeSourceFiles = $this->option('remove-source-files');
        $del               = $this->option('del');
        $delete            = $this->option('delete');
        $deleteBefore      = $this->option('delete-before');
        $deleteDuring      = $this->option('delete-during');
        $deleteDelay       = $this->option('delete-delay');
        $deleteAfter       = $this->option('delete-after');
        $deleteExcluded    = $this->option('delete-excluded');
        $ignoreMissingArgs = $this->option('ignore-missing-args');
        $deleteMissingArgs = $this->option('delete-missing-args');
        $ignoreErrors      = $this->option('ignore-errors');
        $force             = $this->option('force');
        $maxDelete         = $this->option('max-delete');
        $maxSize           = $this->option('max-size');
        $minSize           = $this->option('min-size');
        $partial           = $this->option('partial');
        $partialDir        = $this->option('partial-dir');
        $delayUpdates      = $this->option('delay-updates');
        $pruneEmptyDirs    = $this->option('prune-empty-dirs');
        $numericIds        = $this->option('numeric-ids');
        $usermap           = $this->option('usermap');
        $groupmap          = $this->option('groupmap');
        $chown             = $this->option('chown');
        $timeout           = $this->option('timeout');
        $contimeout        = $this->option('contimeout');
        $ignoreTimes       = $this->option('ignore-times');
        $sizeOnly          = $this->option('size-only');
        $modifyWindow      = $this->option('modify-window');
        $tempDir           = $this->option('temp-dir');
        $fuzzy             = $this->option('fuzzy');
        $compareDest       = $this->option('compare-dest');
        $copyDest          = $this->option('copy-dest');
        $linkDest          = $this->option('link-dest');
        $compress          = $this->option('compress');
        $compressLevel     = $this->option('compress-level');
        $skipCompress      = $this->option('skip-compress');
        $cvsExclude        = $this->option('cvs-exclude');
        $filter            = $this->option('filter');
        $f                 = $this->option('F');
        $exclude           = $this->option('exclude');
        $excludeFrom       = $this->option('exclude-from');
        $include           = $this->option('include');
        $includeFrom       = $this->option('include-from');
        $filesFrom         = $this->option('files-from');
        $fromZero          = $this->option('from0');
        $protectArgs       = $this->option('protect-args');
        $address           = $this->option('address');
        $port              = $this->option('port');
        $sockopts          = $this->option('sockopts');
        $blockingIo        = $this->option('blocking-io');
        $outbuf            = $this->option('outbuf');
        $stats             = $this->option('stats');
        $eightBitOutput    = $this->option('8-bit-output');
        $humanReadable     = $this->option('human-readable');
        $progress          = $this->option('progress');
        $p                 = $this->option('P');
        $itemizeChanges    = $this->option('itemize-changes');
        $outFormat         = $this->option('out-format');
        $logFile           = $this->option('log-file');
        $logFileFormat     = $this->option('log-file-format');
        $passwordFile      = $this->option('password-file');
        $listOnly          = $this->option('list-only');
        $bwlimit           = $this->option('bwlimit');
        $writeBatch        = $this->option('write-batch');
        $onlyWriteBatch    = $this->option('only-write-batch');
        $readBatch         = $this->option('read-batch');
        $protocol          = $this->option('protocol');
        $iconv             = $this->option('iconv');
        $checksumSeed      = $this->option('checksum-seed');
        $ipv4              = $this->option('ipv4');
        $ipv6              = $this->option('ipv6');

        // Not yet implemented:

        // $no = $this->option('no');
        // $remoteOption = $this->option('remote-option');
        // $version = $this->option('version');
        // $help = $this->option('help');

        $source       = $this->argument('source');
        $destination  = $this->argument('destination');

        $sourceUser      = null;
        $sourceHost      = null;
        $destinationUser = null;
        $destinationHost = null;

        list($sourceUser, $sourceHost, $source)                = DataSourceName::split($source);
        list($destinationUser, $destinationHost, $destination) = DataSourceName::split($destination);

        // Not yet implemented:

        // ->no($no, isset($no))
        // ->remoteOption($remoteOption, isset($remoteOption))
        // ->version($version)
        // ->help($help)

        $this->getRsync()
            ->setCommandTimeout($commandTimeout)
            ->setRetryLimit($retryLimit)
            ->verbose($verbose)
            ->info($info, isset($info))
            ->debug($debug, isset($debug))
            ->msgs2StdErr($msgs2stderr)
            ->quiet($quiet)
            ->noMotd($noMotd)
            ->checksum($checksum)
            ->archive($archive)
            ->recursive($recursive)
            ->relative($relative)
            ->noImpliedDirs($noImpliedDirs)
            ->backup($backup)
            ->backupDir($backupDir, isset($backupDir))
            ->suffix($suffix, isset($suffix))
            ->update($update)
            ->inplace($inplace)
            ->append($append)
            ->appendVerify($appendVerify)
            ->dirs($dirs)
            ->links($links)
            ->copyLinks($copyLinks)
            ->copyUnsafeLinks($copyUnsafeLinks)
            ->safeLinks($safeLinks)
            ->mungeLinks($mungeLinks)
            ->copyDirlinks($copyDirlinks)
            ->keepDirlinks($keepDirlinks)
            ->hardLinks($hardLinks)
            ->perms($perms)
            ->executability($executability)
            ->chmod($chmod, isset($chmod))
            ->acls($acls)
            ->xattrs($xattrs)
            ->owner($owner)
            ->group($group)
            ->devices($devices)
            ->specials($specials)
            ->d($d)
            ->times($times)
            ->omitDirTimes($omitDirTimes)
            ->omitLinkTimes($omitLinkTimes)
            ->super($super)
            ->fakeSuper($fakeSuper)
            ->sparse($sparse)
            ->dropCache($dropCache)
            ->preallocate($preallocate)
            ->dryRun($dryRun)
            ->wholeFile($wholeFile)
            ->oneFileSystem($oneFileSystem)
            ->blockSize($blockSize, isset($blockSize))
            ->rsh($rsh, isset($rsh))
            ->rsyncPath($rsyncPath, isset($rsyncPath))
            ->existing($existing)
            ->ignoreNonExisting($ignoreNonExisting)
            ->ignoreExisting($ignoreExisting)
            ->removeSourceFiles($removeSourceFiles)
            ->del($del)
            ->delete($delete)
            ->deleteBefore($deleteBefore)
            ->deleteDuring($deleteDuring)
            ->deleteDelay($deleteDelay)
            ->deleteAfter($deleteAfter)
            ->deleteExcluded($deleteExcluded)
            ->ignoreMissingArgs($ignoreMissingArgs)
            ->deleteMissingArgs($deleteMissingArgs)
            ->ignoreErrors($ignoreErrors)
            ->force($force)
            ->maxDelete($maxDelete, isset($maxDelete))
            ->maxSize($maxSize, isset($maxSize))
            ->minSize($minSize, isset($minSize))
            ->partial($partial)
            ->partialDir($partialDir, isset($partialDir))
            ->delayUpdates($delayUpdates)
            ->pruneEmptyDirs($pruneEmptyDirs)
            ->numericIds($numericIds)
            ->usermap($usermap, isset($usermap))
            ->groupmap($groupmap, isset($groupmap))
            ->chown($chown, isset($chown))
            ->timeout($timeout, isset($timeout))
            ->contimeout($contimeout, isset($contimeout))
            ->ignoreTimes($ignoreTimes)
            ->sizeOnly($sizeOnly)
            ->modifyWindow($modifyWindow, isset($modifyWindow))
            ->tempDir($tempDir, isset($tempDir))
            ->fuzzy($fuzzy)
            ->compareDest($compareDest, isset($compareDest))
            ->copyDest($copyDest, isset($copyDest))
            ->linkDest($linkDest, isset($linkDest))
            ->compress($compress)
            ->compressLevel($compressLevel, isset($compressLevel))
            ->skipCompress($skipCompress, isset($skipCompress))
            ->cvsExclude($cvsExclude)
            ->filter($filter, isset($filter))
            ->f($f)
            ->exclude($exclude, isset($exclude))
            ->excludeFrom($excludeFrom, isset($excludeFrom))
            ->includeFile($include, isset($include))
            ->includeFrom($includeFrom, isset($includeFrom))
            ->filesFrom($filesFrom, isset($filesFrom))
            ->fromZero($fromZero)
            ->protectArgs($protectArgs)
            ->address($address, isset($address))
            ->port($port, isset($port))
            ->sockopts($sockopts, isset($sockopts))
            ->blockingIo($blockingIo)
            ->outbuf($outbuf, isset($outbuf))
            ->stats($stats)
            ->eightBitOutput($eightBitOutput)
            ->humanReadable($humanReadable)
            ->progress($progress)
            ->p($p)
            ->itemizeChanges($itemizeChanges)
            ->outFormat($outFormat, isset($outFormat))
            ->logFile($logFile, isset($logFile))
            ->logFileFormat($logFileFormat, isset($logFileFormat))
            ->passwordFile($passwordFile, isset($passwordFile))
            ->listOnly($listOnly)
            ->bwLimit($bwlimit, isset($bwlimit))
            ->writeBatch($writeBatch, isset($writeBatch))
            ->onlyWriteBatch($onlyWriteBatch, isset($onlyWriteBatch))
            ->readBatch($readBatch, isset($readBatch))
            ->protocol($protocol, isset($protocol))
            ->iconv($iconv, isset($iconv))
            ->checksumSeed($checksumSeed, isset($checksumSeed))
            ->ipv4($ipv4)
            ->ipv6($ipv6)
            ->source($source, $sourceHost, $sourceUser)
            ->destination($destination, $destinationHost, $destinationUser);

        $transferSucceeded = false;
        foreach ($this->getRsync()->transferMulti() as $result) {
            if ($result) {
                $transferSucceeded = true;
                break;
            }

            $this->error('Transfer failed, trying again...');
        }

        if ($transferSucceeded) {
            $this->info('Transfer finished successfully.');
        }
    }
}
