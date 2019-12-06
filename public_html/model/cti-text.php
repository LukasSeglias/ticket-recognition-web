<?php

namespace CTI;

class CtiText implements \JsonSerializable {
    private $key;
    private $topLeft;
    private $bottomRight;

    public function __construct($key = '', $topLeft = null, $bottomRight = null) {
        $this->key = $key;
        $this->topLeft = $topLeft;
        $this->bottomRight = $bottomRight;
    }

    public function getKey() {
        return $this->key;
    }

    public function setKey($key) {
        $this->key = $key;
    }

    public function getTopLeft() {
        return $this->topLeft;
    }

    public function setTopLeft($topLeft) {
        $this->topLeft = $topLeft;
    }

    public function getBottomRight() {
        return $this->bottomRight;
    }

    public function setBottomRight($bottomRight) {
        $this->bottomRight = $bottomRight;
    }

    public function jsonSerialize() {
        return [
          'key' => $this->key,
          'topLeft' => $this->topLeft->jsonSerialize(),
          'bottomRight' => $this->bottomRight->jsonSerialize()
        ];
    }
}

?>