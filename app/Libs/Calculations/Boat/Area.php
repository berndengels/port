<?php

namespace App\Libs\Calculations\Boat;

use Exception;

class Area
{
    protected $boardArea;
    protected $underwaterArea;
    protected $percentKeelLength;

    public function __construct(
        protected string $boatType,
        protected float $length,
        protected float $lengthWaterline,
        protected float $width,
        protected float $draft,
        protected $boardHeight = null,
        protected $lengthKeel = null
    )
    {
        if($this->lengthKeel && $this->lengthKeel > 0) {
            $this->percentKeelLength = round($this->lengthKeel * 100 / $this->lengthWaterline);
        }
        $this->calculate();
    }

    public function calculate()
    {
        switch($this->boatType) {
            case 'motor':
                $this->underwaterArea = $this->base();
                break;
            case 'sail':
            default:
                $this->underwaterArea = $this->calculateSailingBoatArea();
                break;
        }
        $this->boardArea = ($this->length + $this->width) * 2 * $this->boardHeight;
        return $this;
    }

    private function base() {
        // LWL * (Breite + Tiefgang)
        return $this->lengthWaterline * ($this->width + $this->draft);
    }

    private function calculateSailingBoatArea()
    {
        if(! $this->percentKeelLength) {
            throw new Exception('no keel length given');
        }
        // Kurzkieler
        if($this->percentKeelLength < 50) {
            // 0.5 * LWL * (B + Tg)
            return 0.5 * $this->base();
        }
        // Langkieler
        else {
            // 0.75 * LWL * (B + Tg)
            return 0.75 * $this->base();
        }

        return null;
    }

    /**
     * @return mixed
     */
    public function getUnderwaterArea()
    {
        return $this->underwaterArea;
    }

    /**
     * @return mixed
     */
    public function getBoardArea()
    {
        return $this->boardArea;
    }
}
