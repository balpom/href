<?php

declare(strict_types=1);

namespace Balpom\Href;

interface HrefInterface
{

    public function link(): string;

    public function mapping(): string;
}
