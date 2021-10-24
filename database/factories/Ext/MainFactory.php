<?php
namespace Database\Factories\Ext;

use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Factory;

abstract class MainFactory extends Factory
{
    protected $model;
    protected $parentModel;

    /**
     * @return Collection
     */
    protected function getParents(array $cols = null) {
        if(!$this->parentModel) {
            return null;
        }
        if($cols) {
            return ($this->parentModel)::all($cols);
        }
        return ($this->parentModel)::all();
    }

    /**
     * Method to generate random date between two dates
     * @param $sStartDate
     * @param $sEndDate
     * @param string $sFormat
     * @return bool|string
     */
    protected function randomDate($sStartDate, $sEndDate, $sFormat = 'Y-m-d H:i:s') {
        // Convert the supplied date to timestamp
        $fMin = strtotime($sStartDate);
        $fMax = strtotime($sEndDate);

        // Generate a random number from the start and end dates
        $fVal = mt_rand($fMin, $fMax);

        // Convert back to the specified date format
        return date($sFormat, $fVal);
    }

    protected function randomHtmlPart($maxChars = 50)
    {
        $count = rand(5, 10);
        $i = 0;
        $ret = '';
        while ($i < $count) {
            $text = $this->faker->text($maxChars);
            $ret .= "$text<br>";
            $i++;
        }
        return $ret;
    }
}
