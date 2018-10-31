<?php

namespace Cocorico\CoreBundle\Helper;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploadHelper
{
    /**
     * @var UploadedFile
     */
    private $file;

    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $name;

    public function __construct(UploadedFile $file, string $path, string $name)
    {
        $this->file = $file;
        $this->path = $path;
        $this->name = $name;
    }

    /**
     * Upload file
     */
    public function upload()
    {
        if ($this->file === null) {
            return;
        }

        $this->file->move($this->path, $this->name);
    }
}
