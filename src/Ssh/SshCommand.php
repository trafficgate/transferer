<?php

namespace Trafficgate\Ssh;

use Trafficgate\Shell\ShellCommand;

/**
 * Class SshCommand.
 *
 * ssh (SSH client) is a program for logging into a remote machine and for executing
 * commands on a remote machine. It is intended to replace rlogin and rsh, and provide
 * secure encrypted communications between two untrusted hosts over an insecure network.
 * X11 connections and arbitrary TCP ports can also be forwarded over the secure channel.
 *
 * ssh connects and logs into the specified hostname (with optional user name).
 * The user must prove his/her identity to the remote machine using one of several methods
 * depending on the protocol version used.
 *
 * If command is specified, it is executed on the remote host instead of a login shell.
 */
class SshCommand extends ShellCommand
{
    /** @see quietMode() */
    const OPTION_QUIET_MODE = '-q';

    /** @see configOptions() */
    const OPTION_CONFIG_OPTIONS = '-o=*';

    /** @see host() */
    const ARGUMENT_HOST = 'host';

    /** @see remoteCommand() */
    const ARGUMENT_COMMAND = 'command';

    /** Default options */
    const DEFAULT_QUIET_MODE     = true;
    const DEFAULT_CONFIG_OPTIONS = [
        'BatchMode yes',
        'StrictHostKeyChecking no',
        'UserKnownHostsFile /dev/null',
    ];

    /**
     * The SSH command.
     *
     * @var string
     */
    protected $command = 'ssh';

    /**
     * The options for the SSH command.
     *
     * @var array
     */
    protected $options = [
        self::OPTION_QUIET_MODE,
        self::OPTION_CONFIG_OPTIONS,
    ];

    /**
     * The arguments for the SSH command.
     *
     * @var array
     */
    protected $arguments = [
        self::ARGUMENT_HOST,
        self::ARGUMENT_COMMAND,
    ];

    /**
     * Set default options.
     */
    public function __construct()
    {
        parent::__construct();

        $this->quietMode(self::DEFAULT_QUIET_MODE);

        foreach (self::DEFAULT_CONFIG_OPTIONS as $configOption) {
            $this->configOptions($configOption);
        }
    }

    /**
     * Quiet mode. Causes most warning and diagnostic messages to be suppressed.
     *
     * @param bool $enabled
     *
     * @return $this
     */
    public function quietMode($enabled = true)
    {
        return $this->updateOption(self::OPTION_QUIET_MODE, $enabled);
    }

    /**
     * Can be used to give options in the format used in the configuration file.
     * This is useful for specifying options for which there is no separate
     * command-line flag. For full details of the options listed below,
     * and their possible values, see ssh_config(5).
     *
     *     AddressFamily
     *     BatchMode
     *     BindAddress
     *     ChallengeResponseAuthentication
     *     CheckHostIP
     *     Cipher
     *     Ciphers
     *     ClearAllForwardings
     *     Compression
     *     CompressionLevel
     *     ConnectionAttempts
     *     ConnectTimeout
     *     ControlMaster
     *     ControlPath
     *     DynamicForward
     *     EscapeChar
     *     ExitOnForwardFailure
     *     ForwardAgent
     *     ForwardX11
     *     ForwardX11Trusted
     *     GatewayPorts
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
     *     LocalCommand
     *     LocalForward
     *     LogLevel
     *     MACs
     *     NoHostAuthenticationForLocalhost
     *     NumberOfPasswordPrompts
     *     PasswordAuthentication
     *     PermitLocalCommand
     *     Port
     *     PreferredAuthentications
     *     Protocol
     *     ProxyCommand
     *     PubkeyAuthentication
     *     RekeyLimit
     *     RemoteForward
     *     RhostsRSAAuthentication
     *     RSAAuthentication
     *     SendEnv
     *     ServerAliveInterval
     *     ServerAliveCountMax
     *     SmartcardDevice
     *     StrictHostKeyChecking
     *     TCPKeepAlive
     *     Tunnel
     *     TunnelDevice
     *     UsePrivilegedPort
     *     User
     *     UserKnownHostsFile
     *     VerifyHostKeyDNS
     *     VisualHostKey
     *     XAuthLocation
     *
     * @param array $value
     * @param bool  $remove
     * @param bool  $enabled
     *
     * @return $this
     */
    public function configOptions($value, $remove = false, $enabled = true)
    {
        return $this->updateOption(static::OPTION_CONFIG_OPTIONS, $enabled, $value, $remove);
    }

    /**
     * ssh connects and logs into the specified hostname (with optional user name).
     * The user must prove his/her identity to the remote machine using one of several methods
     * depending on the protocol version used.
     *
     * @param string $host
     *
     * @return $this
     */
    public function host($host)
    {
        return $this->updateArgument(self::ARGUMENT_HOST, $host);
    }

    /**
     * If command is specified, it is executed on the remote host instead of a login shell.
     *
     * @param string $command
     *
     * @return $this
     */
    public function remoteCommand($command)
    {
        return $this->updateArgument(self::ARGUMENT_COMMAND, $command);
    }
}
