<?php

declare(strict_types=1);

/*
 * This file is part of the slince/composer-registry-manager package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slince\Crm;

class Repository
{
    /**
     * Repository name.
     *
     * @var string
     */
    protected $name;

    /**
     * Repository url.
     *
     * @var string
     */
    protected $url;

    /**
     * Repository location.
     *
     * @var string
     */
    protected $location;

    public function __construct($name, $url, $location = null)
    {
        $this->name = $name;
        $this->url = $url;
        $this->location = $location;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getLocation(): ?string
    {
        return $this->location;
    }

    /**
     * @param string $location
     */
    public function setLocation(string $location)
    {
        $this->location = $location;
    }

    /**
     * convert to array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'url' => $this->url,
            'location' => $this->location
        ];
    }

    /**
     * Create a repository instance.
     *
     * @param array $data
     *
     * @return static
     *@throws \InvalidArgumentException
     *
     */
    public static function create(array $data): Repository
    {
        if (empty($data['name']) || empty($data['url'])) {
            throw new \InvalidArgumentException('Repository data must contain key [name] and [url]');
        }
        $data['location'] = $data['location'] ?? null;
        return new static($data['name'], $data['url'], $data['location']);
    }
}
