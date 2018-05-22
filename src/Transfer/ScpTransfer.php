<?php

namespace Trafficgate\Transferer\Transfer;

use Trafficgate\Transferer\Transfer;

/**
 * Class ScpTransfer.
 *
 * scp copies files between hosts on a network.  It uses ssh(1) for data transfer,
 * and uses the same authentication and provides the same security as ssh(1).
 * Unlike rcp(1), scp will ask for passwords or passphrases if they are
 * needed for authentication.
 *
 * File names may contain a user and host specification to indicate that the file
 * is to be copied to/from that host.  Local file names can be made explicit
 * using absolute or relative pathnames to avoid scp treating file names
 * containing ‘:’ as host specifiers.  Copies between two remote hosts
 * are also permitted.
 *
 * When copying a source file to a target file which already exists, scp will
 * replace the contents of the target file (keeping the inode). scp copies
 * files between hosts on a network.  It uses ssh(1) for data transfer,
 * and uses the same authentication and provides the same security as
 * ssh(1). Unlike rcp(1), scp will ask for passwords or passphrases
 * if they are needed for authentication.
 *
 * File names may contain a user and host specification to indicate that the
 * file is to be copied to/from that host.  Local file names can be made
 * explicit using absolute or relative pathnames to avoid scp treating
 * file names containing ‘:’ as host specifiers.  Copies between two
 * remote hosts are also permitted.
 *
 * When copying a source file to a target file which already exists, scp will
 * replace the contents of the target file (keeping the inode).
 *
 * If the target file does not yet exist, an empty file with the target file
 * name is created, then filled with the source file contents.  No attempt
 * is made at "near-atomic" transfer using temporary files.
 */
class ScpTransfer extends Transfer
{
    /** The SCP command. */
    const SCP_COMMAND = 'scp';

    /** @see protocol1() */
    const OPTION_PROTOCOL1 = '-1';

    /** @see protocol2() */
    const OPTION_PROTOCOL2 = '-2';

    /** @see ip4Only() */
    const OPTION_IP4_ONLY = '-4';

    /** @see ip6Only() */
    const OPTION_IP6_ONLY = '-6';

    /** @see batchMode() */
    const OPTION_BATCH_MODE = '-B';

    /** @see compression() */
    const OPTION_COMPRESSION = '-C';

    /** @see cipher() */
    const OPTION_CIPHER = '-c=';

    /** @see sshConfig() */
    const OPTION_SSH_CONFIG = '-F=';

    /** @see identityFile() */
    const OPTION_IDENTITY_FILE = '-i=';

    /** @see limit() */
    const OPTION_LIMIT = '-l=';

    /** @see sshOptions() */
    const OPTION_SSH_OPTIONS = '-o=*';

    /** @see port() */
    const OPTION_PORT = '-P=';

    /** @see preserveFile() */
    const OPTION_PRESERVE_FILE = '-p';

    /** @see quietMode() */
    const OPTION_QUIET_MODE = '-q';

    /** @see recursive() */
    const OPTION_RECURSIVE = '-r';

    /** @see program() */
    const OPTION_PROGRAM = '-S=';

    /** @see verbose() */
    const OPTION_VERBOSE = '-v';

    /**
     * The SCP command.
     *
     * @var string
     */
    protected $command = self::SCP_COMMAND;

    /**
     * The options for the SCP command.
     *
     * @var array
     */
    protected $options = [
        self::OPTION_PROTOCOL1,
        self::OPTION_PROTOCOL1,
        self::OPTION_PROTOCOL2,
        self::OPTION_IP4_ONLY,
        self::OPTION_IP6_ONLY,
        self::OPTION_BATCH_MODE,
        self::OPTION_COMPRESSION,
        self::OPTION_PRESERVE_FILE,
        self::OPTION_QUIET_MODE,
        self::OPTION_RECURSIVE,
        self::OPTION_VERBOSE,
        self::OPTION_CIPHER,
        self::OPTION_SSH_CONFIG,
        self::OPTION_IDENTITY_FILE,
        self::OPTION_LIMIT,
        self::OPTION_PORT,
        self::OPTION_PROGRAM,
        self::OPTION_SSH_OPTIONS,
    ];

    /**
     * Forces scp to use protocol 1.
     *
     * @param bool|true $enabled
     *
     * @return $this
     */
    public function protocol1($enabled = true)
    {
        $this->option(static::OPTION_PROTOCOL1)->enable($enabled);
        $this->option(static::OPTION_PROTOCOL2)->disable();

        return $this;
    }

    /**
     * Forces scp to use protocol 2.
     *
     * @param bool|true $enabled
     *
     * @return $this
     */
    public function protocol2($enabled = true)
    {
        $this->option(static::OPTION_PROTOCOL2)->enable($enabled);
        $this->option(static::OPTION_PROTOCOL1)->disable();

        return $this;
    }

    /**
     * Forces scp to use IPv4 addresses only.
     *
     * @param bool|true $enabled
     *
     * @return $this
     */
    public function ip4Only($enabled = true)
    {
        $this->option(static::OPTION_IP4_ONLY)->enable($enabled);
        $this->option(static::OPTION_IP6_ONLY)->disable();

        return $this;
    }

    /**
     * Forces scp to use IPv6 addresses only.
     *
     * @param bool|true $enabled
     *
     * @return $this
     */
    public function ip6Only($enabled = true)
    {
        $this->option(static::OPTION_IP6_ONLY)->enable($enabled);
        $this->option(static::OPTION_IP4_ONLY)->disable();

        return $this;
    }

    /**
     * Selects batch mode (prevents asking for passwords or passphrases).
     *
     * @param bool|true $enabled
     *
     * @return $this
     */
    public function batchMode($enabled = true)
    {
        $this->option(static::OPTION_BATCH_MODE)->enable($enabled);

        return $this;
    }

    /**
     * Compression enable.
     *
     * Passes the -C flag to ssh(1) to enable compression.
     *
     * @param bool|true $enabled
     *
     * @return $this
     */
    public function compression($enabled = true)
    {
        return $this->updateOption(static::OPTION_COMPRESSION, $enabled);
    }

    /**
     * Selects the cipher to use for encrypting the data transfer.
     *
     * This option is directly passed to ssh(1).
     *
     * @param null $value
     * @param bool $remove
     * @param bool $enabled
     *
     * @return $this
     */
    public function cipher($value = null, $remove = false, $enabled = true)
    {
        return $this->updateOption(static::OPTION_CIPHER, $enabled, $value, $remove);
    }

    /**
     * Specifies an alternative per-user configuration file for ssh.
     *
     * This option is directly passed to ssh(1).
     *
     * @param null $value
     * @param bool $remove
     * @param bool $enabled
     *
     * @return $this
     */
    public function sshConfig($value = null, $remove = false, $enabled = true)
    {
        return $this->updateOption(static::OPTION_SSH_CONFIG, $enabled, $value, $remove);
    }

    /**
     * Selects the file from which the identity (private key) for
     * public key authentication is read.
     *
     * This option is directly passed to ssh(1).
     *
     * @param null $value
     * @param bool $remove
     * @param bool $enabled
     *
     * @return $this
     */
    public function identityFile($value = null, $remove = false, $enabled = true)
    {
        return $this->updateOption(static::OPTION_IDENTITY_FILE, $enabled, $value, $remove);
    }

    /**
     * Limits the used bandwidth, specified in Kbit/s.
     *
     * @param null $value
     * @param bool $remove
     * @param bool $enabled
     *
     * @return $this
     */
    public function limit($value = null, $remove = false, $enabled = true)
    {
        return $this->updateOption(static::OPTION_LIMIT, $enabled, $value, $remove);
    }

    /**
     * Can be used to pass arguments to ssh in the format used in ssh_config(5).
     *
     * This is useful for specifying arguments for which there is no separate scp
     * command-line flag.  For full details of the arguments listed below, and
     * their possible values, see ssh_config(5).
     *
     *     AddressFamily
     *     BatchMode
     *     BindAddress
     *     ChallengeResponseAuthentication
     *     CheckHostIP
     *     Cipher
     *     Ciphers
     *     Compression
     *     CompressionLevel
     *     ConnectionAttempts
     *     ConnectTimeout
     *     ControlMaster
     *     ControlPath
     *     GlobalKnownHostsFile
     *     GSSAPIAuthentication
     *     GSSAPIDelegateCredentials
     *     HashKnownHosts
     *     Host
     *     HostbasedAuthentication
     *     HostKeyAlgorithms
     *     HostKeyAlias
     *     HostName
     *     IdentityFile
     *     IdentitiesOnly
     *     KbdInteractiveDevices
     *     LogLevel
     *     MACs
     *     NoHostAuthenticationForLocalhost
     *     NumberOfPasswordPrompts
     *     PasswordAuthentication
     *     PKCS11Provider
     *     Port
     *     PreferredAuthentications
     *     Protocol
     *     ProxyCommand
     *     PubkeyAuthentication
     *     RekeyLimit
     *     RhostsRSAAuthentication
     *     RSAAuthentication
     *     SendEnv
     *     ServerAliveInterval
     *     ServerAliveCountMax
     *     StrictHostKeyChecking
     *     TCPKeepAlive
     *     UsePrivilegedPort
     *     User
     *     UserKnownHostsFile
     *     VerifyHostKeyDNS
     *
     * @param array $value
     * @param bool  $remove
     * @param bool  $enabled
     *
     * @return $this
     */
    public function sshOptions($value = null, $remove = false, $enabled = true)
    {
        return $this->updateOption(static::OPTION_SSH_OPTIONS, $enabled, $value, $remove);
    }

    /**
     * Specifies the port to connect to on the remote host.
     *
     * Note that this option is written with a capital ‘P’,
     * because -p is already reserved for preserving the
     * times and modes of the file in rcp(1).
     *
     * @param null $value
     * @param bool $remove
     * @param bool $enabled
     *
     * @return $this
     */
    public function port($value = null, $remove = false, $enabled = true)
    {
        return $this->updateOption(static::OPTION_PORT, $enabled, $value, $remove);
    }

    /**
     * Preserves modification times, access times, and modes from the original file.
     *
     * @param bool|true $enabled
     *
     * @return $this
     */
    public function preserveFile($enabled = true)
    {
        return $this->updateOption(static::OPTION_PRESERVE_FILE, $enabled);
    }

    /**
     * Quiet mode: disables the progress meter as well as warning
     * and diagnostic messages from ssh(1).
     *
     * @param bool|true $enabled
     *
     * @return $this
     */
    public function quietMode($enabled = true)
    {
        return $this->updateOption(static::OPTION_QUIET_MODE, $enabled);
    }

    /**
     * Recursively copy entire directories.
     *
     * Note that scp follows symbolic links encountered in
     * the tree traversal.
     *
     * @param bool|true $enabled
     *
     * @return $this
     */
    public function recursive($enabled = true)
    {
        return $this->updateOption(static::OPTION_RECURSIVE, $enabled);
    }

    /**
     * Name of program to use for the encrypted connection.
     *
     * The program must understand ssh(1) arguments.
     *
     * @param null $value
     * @param bool $remove
     * @param bool $enabled
     *
     * @return $this
     */
    public function program($value = null, $remove = false, $enabled = true)
    {
        return $this->updateOption(static::OPTION_PROGRAM, $enabled, $value, $remove);
    }

    /**
     * Verbose mode.
     *
     * Causes scp and ssh(1) to print debugging messages about their progress.
     * This is helpful in debugging connection, authentication, and
     * configuration problems.
     *
     * @param bool|true $enabled
     *
     * @return $this
     */
    public function verbose($enabled = true)
    {
        return $this->updateOption(static::OPTION_VERBOSE, $enabled);
    }
}
