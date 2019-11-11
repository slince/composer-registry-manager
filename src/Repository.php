<?php

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
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param string $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * convert to array.
     *
     * @return array
     */
    public function toArray()
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
     * @throws \InvalidArgumentException
     *
     * @return static
     */
    public static function create($data)
    {
        if (empty($data['name']) || empty($data['url'])) {
            throw new \InvalidArgumentException('Repository data must contain key [name] and [url]');
        }
        $data['location'] = isset($data['location']) ? $data['location'] : null;
        return new static($data['name'], $data['url'], $data['location']);
    }
}
