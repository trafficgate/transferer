<?php

namespace Trafficgate\Transferer\Console\Commands;

use Illuminate\Console\Command;
use Trafficgate\Transferer\Transfer\ScpTransfer;
use Trafficgate\Transferer\Util\DataSourceName;

class Scp extends Command
{
    /**
     * The command signature.
     *
     * @var string
     */
    protected $signature = 'scp
                            {--command-timeout= : time before considering the command failed}
                            {--retry-limit=1 : number of times to retry a failed command}
                            {--1|protocol1 : Forces scp to use protocol 1.}
                            {--2|protocol2 : Forces scp to use protocol 2.}
                            {--4|ip4only : Forces scp to use IPv4 addresses only.}
                            {--6|ip6only : Forces scp to use IPv6 addresses only.}
                            {--B|batch_mode : Selects batch mode (prevents asking for passwords or passphrases).}
                            {--C|compression : Compression enable. Passes the -C flag to ssh(1) to enable compression.}
                            {--c|cipher= : Selects the cipher to use for encrypting the data transfer.}
                            {--F|ssh_config= : Specifies an alternative per-user configuration file for ssh.}
                            {--i|identify_file= : Selects the file from which the identity (private key) for public key authentication is read.}
                            {--l|limit= : Limits the used bandwidth, specified in Kbit/s.}
                            {--o|ssh_option= : Can be used to pass options to ssh in the format used in ssh_config.}
                            {--P|port= : Specifies the port to connect to on the remote host.}
                            {--p|preserve_file : Preserves modification times, access times, and modes from the original file.}
                            {--Q|quiet_mode : Quiet mode: disables the progress meter as well as warning and diagnostic messages from ssh.}
                            {--r|recursive : Recursively copy entire directories. Note that scp follows symbolic links encountered in the tree traversal.}
                            {--S|program : Name of program to use for the encrypted connection.}
                            {--w|verbose_scp : Verbose mode.}
                            {source}
                            {destination}';

    /**
     * The command description.
     *
     * @var string
     */
    protected $description = 'SCP copies files between hosts on a network.';

    /**
     * @var ScpTransfer
     */
    protected $scp;

    /**
     * @param ScpTransfer $scp
     */
    public function __construct(ScpTransfer $scp)
    {
        parent::__construct();
        $this->setScp($scp);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $commandTimeout = $this->option('command-timeout');
        $retryLimit     = $this->option('retry-limit');
        $protocol1      = $this->option('protocol1');
        $protocol2      = $this->option('protocol2');
        $ip4Only        = $this->option('ip4only');
        $ip6Only        = $this->option('ip6only');
        $batchMode      = $this->option('batch_mode');
        $compression    = $this->option('compression');
        $cipher         = $this->option('cipher');
        $sshConfig      = $this->option('ssh_config');
        $identityFile   = $this->option('identity_file');
        $limit          = $this->option('limit');
        $sshOption      = $this->option('ssh_option');
        $port           = $this->option('port');
        $preserveFile   = $this->option('preserve_file');
        $quietMode      = $this->option('quiet_mode');
        $recursive      = $this->option('recursive');
        $program        = $this->option('program');
        $verbose        = $this->option('verbose');
        $source         = $this->argument('source');
        $destination    = $this->argument('destination');

        $sourceUser      = null;
        $sourceHost      = null;
        $destinationUser = null;
        $destinationHost = null;

        list($sourceUser, $sourceHost, $source)                = DataSourceName::split($source);
        list($destinationUser, $destinationHost, $destination) = DataSourceName::split($destination);

        $this->getScp()
            ->setCommandTimeout($commandTimeout)
            ->setRetryLimit($retryLimit)
            ->protocol1($protocol1)
            ->protocol2($protocol2)
            ->ip4Only($ip4Only)
            ->ip6Only($ip6Only)
            ->batchMode($batchMode)
            ->compression($compression)
            ->cipher($cipher, isset($cipher))
            ->sshConfig($sshConfig, isset($sshConfig))
            ->identityFile($identityFile, isset($identityFile))
            ->limit($limit, isset($limit))
            ->sshOptions($sshOption, isset($sshOptions))
            ->port($port, isset($port))
            ->preserveFile($preserveFile)
            ->quietMode($quietMode)
            ->recursive($recursive)
            ->program($program, isset($program))
            ->verbose($verbose)
            ->source($source, $sourceHost, $sourceUser)
            ->destination($destination, $destinationHost, $destinationUser);

        $transferSucceeded = false;
        foreach ($this->getScp()->transferMulti() as $result) {
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

    /**
     * Get the SCP transfer command.
     *
     * @return ScpTransfer
     */
    protected function getScp()
    {
        return $this->scp;
    }

    /**
     * Set the SCP transfer command.
     *
     * @param ScpTransfer $scp
     */
    protected function setScp(ScpTransfer $scp)
    {
        $this->scp = $scp;
    }
}
