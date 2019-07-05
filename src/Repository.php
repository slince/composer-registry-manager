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
     * Repository homepage.
     *
     * @var string
     */
    protected $homepage;

    /**
     * Repository author.
     *
     * @var string
     */
    protected $author;

    public function __construct($name, $url, $homepage = null, $author = null)
    {
        $this->name = $name;
        $this->url = $url;
        $this->homepage = $homepage;
        $this->author = $author;
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
     * @param string $homepage
     */
    public function setHomepage($homepage)
    {
        $this->homepage = $homepage;
    }

    /**
     * @param string $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
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
    public function getHomepage()
    {
        return $this->homepage;
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
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
            'homepage' => $this->homepage,
            'author' => $this->author,
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
        $homepage = isset($data['homepage']) ? $data['homepage'] : '';
        $author = isset($data['author']) ? $data['author'] : '';

        return new static($data['name'], $data['url'], $homepage, $author);
    }
}
