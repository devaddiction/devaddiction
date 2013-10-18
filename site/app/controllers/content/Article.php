<?php

namespace App\Content;

use JsonSerializable;

/**
 * Representation of a single Article and its related data.
 */
class Article extends \Kazan\Articler\Article\Article
{

    /**
     * @var string
     */
    protected $downloadLink;

    /**
     * @var string
     */
    protected $demoLink;


    /**
     * Gets the value of download link.
     *
     * @return string
     */
    public function getDownloadLink()
    {
        return $this->downloadLink;
    }

    /**
     * Sets the value of title.
     *
     * @param string $downloadLink the downloadLink
     *
     * @return self
     */
    public function setDownloadLink($downloadLink)
    {
        $this->downloadLink = $downloadLink;

        return $this;
    }

    /**
     * Gets the value of demo link.
     *
     * @return string
     */
    public function getDemoLink()
    {
        return $this->demoLink;
    }

    /**
     * Sets the value of demo link.
     *
     * @param string $demoLink the demoLink
     *
     * @return self
     */
    public function setDemoLink($demoLink)
    {
        $this->demoLink = $demoLink;

        return $this;
    }

    /**
     * Get the JSON serialized
     * @return
     */
    public function jsonSerialize()
    {
        $data = parent::jsonSerialize();
        $data['downloadLink'] = $this->downloadLink;
        $data['demoLink'] = $this->demoLink;
        return $data;
    }
}
