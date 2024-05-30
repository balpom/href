<?php

declare(strict_types=1);

namespace Balpom\Href;

use Psr\Link\LinkProviderInterface;
use Psr\Link\LinkInterface;

class HrefCollection implements HrefCollectionInterface
{
    private LinkInterface|array $link;
    private array $links = [];

    public function __construct(LinkProviderInterface|Href|string|array $links = [])
    {
        if ($links instanceof Href) {
            $this->with($links);
        } else {
            if ($links instanceof LinkProviderInterface) {
                $links = $links->getLinks();
            }
            if (is_string($links)) {
                $links = [$links];
            }
            foreach ($links as $link) {
                $uri = $link->getHref();
                if (empty($link)) {
                    continue;
                }
                $this->with($uri);
            }
        }
    }

    public function getAll(): array
    {
        return array_values($this->links);
    }

    public function getByLink(string $uri): Href|false
    {
        return isset($this->links[$uri]) ? $this->links[$uri] : false;
    }

    public function getByMapping(string $uri): array
    {
        $result = [];
        foreach ($this->links as $href) {
            if ($uri === $href->mapping()) {
                $result[] = $href;
            }
        }

        return $result;
    }

    public function with(LinkInterface|Href|string $link, LinkInterface|string|null $mapping = null): static
    {
        if ($link instanceof Href) {
            if (empty($mapping)) {
                $mapping = $link->mapping();
            }
            $link = $link->link();
        }
        if ($link instanceof LinkInterface) {
            $link = $link->getHref();
            if (empty($mapping)) {
                $mapping = $link;
            }
        }

        $href = new Href($link, $mapping);
        $mapping = $href->mapping();

        if (!isset($this->links[$link])) {
            $this->links[$link] = $href;
        } else {
            $oldMapping = $this->links[$link]->mapping();
            if ($oldMapping <> $mapping) {
                $this->links[$link] = $href;
            }
        }

        return $this;
    }

    public function without(LinkInterface|Href|string $link): static
    {
        if ($link instanceof Href) {
            $link = $link->link();
        } else {
            if ($link instanceof LinkInterface) {
                $link = $link->getHref();
            }
        }

        if (isset($this->links[$link])) {
            unset($this->links[$link]);
        }

        return $this;
    }
}
