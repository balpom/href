<?php

declare(strict_types=1);

namespace Balpom\Href;

use Psr\Link\LinkInterface;

class Href implements HrefInterface
{
    private string $link;
    private string|null $mapping;

    public function __construct(LinkInterface|string $link, LinkInterface|string|null $mapping = null)
    {
        if ($link instanceof LinkInterface) {
            $link = $link->getHref();
        }
        $link = trim($link);
        if (empty($link)) {
            throw new HrefException('Link must be not empty!');
        }
        $this->link = $link;

        if ($mapping instanceof LinkInterface) {
            $mapping = $mapping->getHref();
        }
        $mapping = trim($mapping);
        if (empty($mapping)) {
            $this->mapping = $this->link;
        } else {
            $this->mapping = $mapping;
        }
    }

    public function link(): string
    {
        return $this->link;
    }

    public function mapping(): string
    {
        return $this->mapping;
    }
}
