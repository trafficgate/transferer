<?php

namespace Trafficgate\Transferer;

use PackageVersions\Versions;
use PHPUnit\Framework\TestCase;

class CommandTestCase extends TestCase
{
    /**
     * Empty quotes to use for symfony/process test comparators.
     *
     * @var string
     */
    public $emptyQuotes;

    public function setUp()
    {
        $this->determineEmptyQuotesForSymfonyProcess();
    }

    /**
     * Symfony/process returns either '' or "" depending on version.
     *
     * Versions less than or equal to 3.4.X return ''.
     * Versions greather than or equal to 4.0.0 return "".
     */
    private function determineEmptyQuotesForSymfonyProcess()
    {
        $this->emptyQuotes = "''";

        $symfonyProcessVersion = substr(
            explode(
                '@',
                Versions::getVersion('symfony/process')
            )[0],
            1
        );

        if (version_compare('4.0.0', $symfonyProcessVersion, '<')) {
            $this->emptyQuotes = '""';
        }
    }
}
