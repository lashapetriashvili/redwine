<?php

namespace Redwine\Helper;

class Stub
{
    /**
     * Content Path
     *
     * @var string
     */
    protected $path;

    /**
     * Replace
     *
     * @var string
     */
    protected $replace;

    /**
     * Set Content Path
     *
     * @param $path
     * @return $this
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Set Replace
     *
     * @param $raplace
     * @return $this
     */
    public function setReplace($raplace)
    {
        $this->replace = $raplace;

        return $this;
    }

    public function getContent()
    {
        return file_get_contents($this->path);
    }
}
