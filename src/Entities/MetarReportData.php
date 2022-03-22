<?php

namespace FsHub\Sdk\Entities;

use FsHub\Sdk\Types\Common;

class MetarReportData
{
    /**
     * METAR retrieval error detected.
     * @var bool
     */
    public bool $error = false;

    /**
     * The raw airport METAR report.
     * @var string
     */
    public string $report = Common::DEFAULT_STRING_VALUE;
}
