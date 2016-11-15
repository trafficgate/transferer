<?php

namespace Trafficgate\Daemon;

use Trafficgate\Transfer\RsyncTransfer;

class RsyncDaemon extends RsyncTransfer
{
    /** run rsync in daemon mode */
    const OPTION_DAEMON = '--daemon+ : run rsync in daemon mode';

    /** specify alternate rsyncd.conf file */
    const OPTION_CONFIG = '--config= : specify alternate rsyncd.conf file';

    /** -M : override global daemon config parameter */
    const OPTION_DPARAM = '--dparam=* : override global daemon config parameter';

    /** do not detach from the file parent */
    const OPTION_NO_DETACH = '--no-detach : do not detach from the file parent';

    public function initialize()
    {
        $options = [
            static::OPTION_DAEMON,
            static::OPTION_CONFIG,
            static::OPTION_DPARAM,
            static::OPTION_NO_DETACH,
        ];

        $this->options = array_unique(array_merge($this->options, $options));
    }

    /**
     * This  tells  rsync  that  it  is  to  run as a daemon.  The daemon you start running may be accessed using an rsync client using the
     * host::module or rsync://host/module/ syntax.
     *
     * If standard input is a socket then rsync will assume that it is being run via inetd, otherwise it will detach from the current  ter-
     * minal  and  become  a  background  daemon.   The daemon will read the config file (rsyncd.conf) on each connect made by a client and
     * respond to requests accordingly.  See the rsyncd.conf(5) man page for more details.
     *
     * @param bool $enable
     *
     * @return $this
     */
    final public function daemon($enable = true)
    {
        return $this->updateOption(static::OPTION_DAEMON, $enable);
    }

    /**
     * By default rsync will bind to the wildcard address when run as a daemon with the --daemon option.  The --address option  allows  you
     * to  specify  a  specific  IP address (or hostname) to bind to.  This makes virtual hosting possible in conjunction with the --config
     * option.  See also the "address" global option in the rsyncd.conf manpage.
     *
     * @param null $address
     * @param bool $remove
     * @param bool $enable
     *
     * @return $this
     */
    public function address($address = null, $remove = false, $enable = true)
    {
        return parent::address($address, $remove, $enable);
    }

    /**
     * This option allows you to specify the maximum transfer rate for the data the daemon sends over the socket.   The  client  can  still
     * specify  a  smaller  --bwlimit  value,  but no larger value will be allowed.  See the client version of this option (above) for some
     * extra details.
     *
     * @param $rate
     * @param bool $remove
     * @param bool $enable
     *
     * @return $this
     */
    public function bwLimit($rate = null, $remove = false, $enable = true)
    {
        return parent::bwLimit($rate, $remove, $enable);
    }

    /**
     * This specifies an alternate config file than the default.  This is only  relevant  when  --daemon  is  specified.   The  default  is
     * /etc/rsyncd.conf  unless  the  daemon is running over a remote shell program and the remote user is not the super-user; in that case
     * the default is rsyncd.conf in the current directory (typically $HOME).
     *
     * @param $file
     * @param bool $remove
     * @param bool $enable
     *
     * @return $this
     */
    public function config($file = null, $remove = false, $enable = true)
    {
        return $this->updateOption(static::OPTION_CONFIG, $enable, $file, $remove);
    }

    /**
     * This option can be used to set a daemon-config parameter when starting up rsync in daemon mode.  It  is  equivalent  to  adding  the
     * parameter  at  the  end of the global settings prior to the first module’s definition.  The parameter names can be specified without
     * spaces, if you so desire.  For instance:.
     *
     *     rsync --daemon -M pidfile=/path/rsync.pid
     *
     * @param $override
     * @param bool $remove
     * @param bool $enable
     *
     * @return $this
     */
    public function dparam($override = null, $remove = false, $enable = true)
    {
        return $this->updateOption(static::OPTION_DPARAM, $enable, $override, $remove);
    }

    /**
     * When running as a daemon, this option instructs rsync to not detach itself and become a background process.  This option is required
     * when  running as a service on Cygwin, and may also be useful when rsync is supervised by a program such as daemontools or AIX’s Sys-
     * tem Resource Controller.  --no-detach is also recommended when rsync is run under a debugger.  This option has no effect if rsync is
     * run from inetd or sshd.
     *
     * @param bool $enable
     *
     * @return $this
     */
    public function noDetach($enable = true)
    {
        return $this->updateOption(static::OPTION_NO_DETACH, $enable);
    }

    /**
     * This  specifies an alternate TCP port number for the daemon to listen on rather than the default of 873.  See also the "port" global
     * option in the rsyncd.conf manpage.
     *
     * @param $port
     * @param bool $remove
     * @param bool $enable
     *
     * @return $this
     */
    public function port($port = null, $remove = false, $enable = true)
    {
        return parent::port($port, $remove, $enable);
    }

    /**
     * This option tells the rsync daemon to use the given log-file name instead of using the "log file" setting in the config file.
     *
     * @param $file
     * @param bool $remove
     * @param bool $enable
     *
     * @return $this
     */
    public function logFile($file = null, $remove = false, $enable = true)
    {
        return parent::logFile($file, $remove, $enable);
    }

    /**
     * This option tells the rsync daemon to use the given FORMAT string instead of using the "log format" setting in the config file.   It
     * also enables "transfer logging" unless the string is empty, in which case transfer logging is turned off.
     *
     * @param $format
     * @param bool $remove
     * @param bool $enable
     *
     * @return $this
     */
    public function logFileFormat($format = null, $remove = false, $enable = true)
    {
        return parent::logFileFormat($format, $remove, $enable);
    }

    /**
     * This overrides the socket options setting in the rsyncd.conf file and has the same syntax.
     *
     * @param null $list
     * @param bool $remove
     * @param bool $enable
     *
     * @return $this
     */
    public function sockopts($list = null, $remove = false, $enable = true)
    {
        return parent::sockopts($list, $remove, $enable);
    }

    /**
     * This  option  increases the amount of information the daemon logs during its startup phase.  After the client connects, the daemon’s
     * verbosity level will be controlled by the options that the client used and the "max verbosity" setting in the module’s  config  sec-
     * tion.
     *
     * @param bool $enable
     *
     * @return $this
     */
    public function verbose($enable = true)
    {
        return parent::verbose($enable);
    }

    /**
     * Tells rsync to prefer IPv4/IPv6 when creating the incoming sockets that the rsync daemon will use to listen for connections.  One of
     * these options may be required in older versions of Linux to work around an IPv6 bug in the kernel (if you see an "address already in
     * use" error when nothing else is using the port, try specifying --ipv6 or --ipv4 when starting the daemon).
     *
     * If  rsync  was complied without support for IPv6, the --ipv6 option will have no effect.  The --version output will tell you if this
     * is the case.
     *
     * @param bool $enable
     *
     * @return $this
     */
    public function ipv4($enable = true)
    {
        return parent::ipv4($enable);
    }

    /**
     * @see ipv4()
     *
     * @param bool $enable
     *
     * @return $this
     */
    public function ipv6($enable = true)
    {
        return parent::ipv6($enable);
    }

    /**
     * When specified after --daemon, print a short help page describing the options available for starting an rsync daemon.
     *
     * @param bool $enable
     *
     * @return $this
     */
    public function help($enable = true)
    {
        return parent::help($enable);
    }
}
