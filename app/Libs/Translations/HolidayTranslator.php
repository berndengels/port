<?php

namespace App\Libs\Translations;

//use Symfony\Component\Translation\Translator;
use Umulmrum\Holiday\Model\Holiday;

class HolidayTranslator
{
    private string $locale = 'de';
    private string $domain = 'holiday';

    /**
     * @param string $locale
     */
    public function __construct(string $locale)
    {
        $this->locale = $locale;
    }

    /**
     * {@inheritdoc}
     */
    public function translateName(Holiday $holiday): string
    {
        return trans($this->domain.'.'.$holiday->getName(), [], $this->locale);
    }

    /**
     * {@inheritdoc}
     */
    public function translate(string $string): string
    {
        return trans($this->domain.'.'.$string, [], $this->locale);
    }
}
