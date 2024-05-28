<?php

declare(strict_types=1);

namespace Balpom\Href;

/**
 * Collection of unique Href objects
 */
interface HrefCollectionInterface
{

    /**
     * Returns all Href objects from collection.
     */
    public function getAll(): iterable;

    /**
     * Returns Href object by link.
     */
    public function getByLink(string $uri): Href|false;

    /**
     * Returns Href object by link mapping.
     */
    public function getByMapping(string $uri): Href|false;
}
