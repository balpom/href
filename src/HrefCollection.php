<?php

declare(strict_types=1);

namespace Balpom\Href;

use Psr\Link\LinkProviderInterface;
use Psr\Link\LinkInterface;

class HrefCollection implements HrefCollectionInterface
{
    private LinkInterface|array $link;
    private array $links = [];
    private array $mappings = [];

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

    public function getByMapping(string $uri): Href|false
    {
        if (isset($this->mappings[$uri])) {
            $uri = $this->mappings[$uri];
        }
        return $this->getByLink($uri);
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
        }

        $href = new Href($link, $mapping);
        $uri = $href->link();
        $mapping = $href->mapping();

        if (!isset($this->links[$uri])) {
            $this->links[$uri] = $href;
        } else {
            $oldMapping = $this->links[$uri]->mapping();
            if ($oldMapping <> $mapping) {
                $this->links[$uri] = $href;
            }
        }

        if ($mapping <> $uri && !isset($this->mappings[$mapping])) {
            $key = array_search($uri, $this->mappings);
            if (!empty($key) && isset($this->mappings[$key])) {
                unset($this->mappings[$key]); // Delete old mapping for $uri.
            }
            $this->mappings[$mapping] = $uri;
        }

        return $this;
    }

    public function without(LinkInterface|Href|string $link): static
    {
        if ($link instanceof Href) {
            $mapping = $link->mapping();
            $link = $link->link();
        } else {
            if ($link instanceof LinkInterface) {
                $link = $link->getHref();
            }
            $mapping = $link;
        }

        if (isset($this->links[$link])) {
            unset($this->links[$link]);
        }
        if (isset($this->mappings[$mapping])) {
            unset($this->mappings[$mapping]);
        }

        return $this;
    }
}
