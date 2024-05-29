<?php

declare(strict_types=1);

namespace Balpom\Href;

use Psr\Link\LinkInterface;

class Href implements HrefInterface
{
    private string $link;
    private string|null $mapping;

    public function __construct(LinkInterface|string|null $link, LinkInterface|string|null $mapping = null)
    {
        if ($link instanceof LinkInterface) {
            $link = $link->getHref();
        }
        if (is_string($link)) {
            $link = trim($link);
        }
        if (empty($link)) {
            throw new HrefException('Link must be not empty!');
        }
        $this->link = $link;

        if ($mapping instanceof LinkInterface) {
            $mapping = $mapping->getHref();
        }
        if (is_string($mapping)) {
            $mapping = trim($mapping);
        }
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
