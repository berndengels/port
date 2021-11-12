<?php

namespace App\Libs\Calculations\Boat;

class Area
{
    protected $area;
    protected $percentKeelLength;

    public function __construct(
        protected string $boatType,
        protected float $lengthWaterline,
        protected float $lengthKeel,
        protected float $width,
        protected float $draft
    )
    {
        $this->percentKeelLength = round($this->lengthKeel * 100 / $this->lengthWaterline);
        $this->calculateArea();
    }

    public function calculateArea()
    {
        switch($this->boatType) {
            case 'motor':
                $this->area = $this->base();
                break;
            case 'sail':
            default:
                $this->area = $this->calculateSailingBoat();
                break;
        }
        return $this;
    }

    private function base() {
        // LWL * (Breite + Tiefgang)
        return $this->lengthWaterline * ($this->width + $this->draft);
    }

    private function calculateSailingBoat()
    {
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
    public function getArea()
    {
        return $this->area;
    }
}
