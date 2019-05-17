<?php

namespace Trafficgate\Transferer;

use PackageVersions\Versions;
use PHPUnit\Framework\TestCase;

class CommandTestCase extends TestCase
{
    /**
     * Symfony/process returns either '' or "" depending on version.
     *
     * Versions less than or equal to 3.4.X return ''.
     * Versions greather than or equal to 4.0.0 return "".
     *
     * @var string
     */
    public $emptyQuotes;

    public function setUp()
    {
        $this->emptyQuotes = "''";

        $symfonyProcessVersion = Versions::getVersion('symfony/process');

        if (preg_match('/^v4/', $symfonyProcessVersion)) {
            $this->emptyQuotes = '""';
        }
    }
}
