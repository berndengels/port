<?php

namespace App\Libs\Translations;

use Umulmrum\Holiday\Model\Holiday;
use Umulmrum\Holiday\Model\HolidayList;
use Umulmrum\Holiday\Translator\NullTranslator;
use Umulmrum\Holiday\Translator\SymfonyBridgeTranslator;
use Umulmrum\Holiday\Translator\TranslatorInterface;
use Umulmrum\Holiday\Formatter\HolidayFormatterInterface;

class LocaleNameFormatter implements HolidayFormatterInterface
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    public function __construct(string $locale = null)
    {
        $this->translator = new HolidayTranslator($locale);
    }

    public function format(Holiday $holiday, array $options = []): string
    {
        return $this->translator->translateName($holiday);
    }

    public function formatList(HolidayList $holidayList, array $options = [])
    {
        $result = [];

        foreach ($holidayList->getList() as $holiday) {
            $result[] = $this->translator->translateName($holiday);
        }

        return $result;
    }
}
