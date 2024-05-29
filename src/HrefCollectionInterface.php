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
     * Returns Href objects by link mapping.
     * (Several different links may share a common mapping (canonical page)).
     */
    public function getByMapping(string $uri): iterable;
}
