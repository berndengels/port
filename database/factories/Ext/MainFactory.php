<?php
namespace Database\Factories\Ext;

use App\Helper\DateHelper;
use Illuminate\Database\Eloquent\Factories\Factory;

abstract class MainFactory extends Factory
{
    /**
     * Method to generate random date between two dates
     * @param $sStartDate
     * @param $sEndDate
     * @param string $sFormat
     * @return bool|string
     */
    public function randomDate(string $sStartDate, string $sEndDate, $sFormat = 'Y-m-d') {
        return DateHelper::randomDate($sStartDate, $sEndDate, $sFormat);
    }

    public function randomHtmlPart($maxChars = 50)
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

    public function zeroFill($val)
    {
        $val = (string) $val;
        if(strlen($val) < 2 && $val > 0) {
            $val = '0'.$val;
        }
        return $val;
    }
}
