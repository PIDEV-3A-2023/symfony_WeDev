<?php

namespace App\Form;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\HttpFoundation\File\File;

class StringToFileTransformer implements DataTransformerInterface
{
    public $veloImagesDirectory;

    public function __construct(string $veloImagesDirectory)
    {
        $this->veloImagesDirectory = $veloImagesDirectory;
    }

    public function transform($value)
    {
        return null;
    }

    public function reverseTransform($value)
    {
        if (!$value) {
            return null;
        }

        $filename = $value;
        $filePath = $this->veloImagesDirectory.'/'.$filename;

        try {
            $file = new File($filePath);
        } catch (\Exception $e) {
            throw new TransformationFailedException(sprintf(
                'Unable to read file "%s"',
                $filePath
            ));
        }

        return $file;
    }
}
