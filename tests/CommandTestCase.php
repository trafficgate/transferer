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

    public function setUp(): void
    {
        $this->determineEmptyQuotesForSymfonyProcess();
    }

    /**
     * Symfony/process returns either '' or "" depending on version for empty arguments.
     *
     * Versions less than or equal to 4.1.6 return ''.
     * Versions greather than or equal to 4.1.7 return "".
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

        if (version_compare('4.1.7', $symfonyProcessVersion, '<')) {
            $this->emptyQuotes = '""';
        }
    }
}
