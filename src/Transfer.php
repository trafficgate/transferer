<?php

namespace Trafficgate\Transferer;

use LogicException;
use Trafficgate\Shell\ShellCommand;
use Trafficgate\Transferer\Util\DataSourceName;

/**
 * Class Transfer.
 *
 * A transfer consists of a command and two arguments: source and destination.
 * Any class that extends a transfer can add any number of options that it
 * prefers, but these arguments cannot be changed.
 */
abstract class Transfer extends ShellCommand
{
    /** The source for the transfer. */
    const ARGUMENT_SOURCE      = 'source';

    /** The destination for the transfer. */
    const ARGUMENT_DESTINATION = 'destination';

    /**
     * The arguments for the shell command.
     *
     * @var array
     */
    private $transferArguments = [
        self::ARGUMENT_SOURCE,
        self::ARGUMENT_DESTINATION,
    ];

    /**
     * Transfer constructor.
     *
     * Ensure that arguments are only source and destination.
     */
    final public function __construct()
    {
        $this->arguments = $this->transferArguments;

        parent::__construct();

        if ($this->arguments !== $this->transferArguments) {
            throw new LogicException('Cannot override arguments!');
        }
    }

    /**
     * Set the source.
     *
     * @param string      $source
     * @param string|null $host
     * @param string|null $user
     *
     * @return $this
     */
    final public function source($source, $host = null, $user = null)
    {
        $source = DataSourceName::join($source, $host, $user);

        return $this->updateArgument(static::ARGUMENT_SOURCE, $source);
    }

    /**
     * Set the destination.
     *
     * @param string      $destination
     * @param string|null $host
     * @param string|null $user
     *
     * @return $this
     */
    final public function destination($destination, $host = null, $user = null)
    {
        $destination = DataSourceName::join($destination, $host, $user);

        return $this->updateArgument(static::ARGUMENT_DESTINATION, $destination);
    }

    /**
     * Transfer the file from source to destination.
     *
     * Syntactical sugar for runOnce().
     *
     * @see \Trafficgate\Shell\ShellCommand::runOnce()
     *
     * @param int|null $idleTimeout
     *
     * @return bool
     */
    final public function transfer($idleTimeout = null)
    {
        return $this->runOnce($idleTimeout);
    }

    /**
     * Transfer the file from source to destination.
     * Makes use of retry logic and yields results.
     *
     * Syntactical sugar for runMulti().
     *
     * @see \Trafficgate\Shell\ShellCommand::runMulti()
     *
     * @param int|null $idleTimeout
     *
     * @return bool[]
     */
    final public function transferMulti($idleTimeout = null)
    {
        yield $this->runMulti($idleTimeout);
    }
}
