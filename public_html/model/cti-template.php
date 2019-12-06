<?php

namespace CTI;

class CtiTemplate implements \JsonSerializable
{
    private $name;
    private $fileName;
    private $texts;

    public function __construct($name = '', $filename = '', $texts = []) {
        $this->name = $name;
        $this->fileName = $filename;
        $this->texts = $texts;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
    }

    public function getFileName()
    {
        return $this->fileName;
    }

    public function setTexts($texts)
    {
        $this->texts = $texts;
    }

    public function getTexts()
    {
        return $this->texts;
    }

    public function jsonSerialize() {
        $serializedTexts = [];

        foreach ($this->texts as $text) {
            array_push($serializedTexts, $text->jsonSerialize());
        }

        return [
            'name' => $this->name,
            'fileName' => $this->fileName,
            'texts' => $serializedTexts
        ];
    }
}

?>