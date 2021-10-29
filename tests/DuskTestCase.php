<?php
namespace Tests;

use App\Models\AdminUser;
use App\Models\Boat;
use App\Models\BoatDates;
use App\Models\BoatGuest;
use App\Models\Caravan;
use App\Models\Customer;
use Carbon\Carbon;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\WebDriverCapabilityType;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverDimension;
use Laravel\Dusk\Browser;
use Laravel\Dusk\TestCase as BaseTestCase;
use Intervention\Image\ImageManagerStatic as StaticImage;
use Intervention\Image\Image;

abstract class DuskTestCase extends BaseTestCase
{
    use CreatesApplication;

    public static $screenshotWidth 			= 1920;
    public static $screenshotThumbWidth 	= 200;
    public static $screenshotCompression	= 60;
    /**
     * @var string
     */
    private static $screenPath;
    protected $screenName;

    /**
     * @var Customer
     */
    protected $customer;
    /**
     * @var AdminUser
     */
    protected $user;
    /**
     * @var Caravan
     */
    protected $caravan;
    /**
     * @var BoatGuest
     */
    protected $guestBoat;
    /**
     * @var Boat
     */
    protected $boat;
    /**
     * @var Carbon
     */
    protected $from;
    /**
     * @var Carbon
     */
    protected $until;

    /**
     * Prepare for Dusk test execution.
     *
     * @beforeClass
     * @return void
     */
    public static function prepare()
    {
        if (! static::runningInSail()) {
            static::startChromeDriver();
        }
    }

    /**
     * Create the RemoteWebDriver instance.
     *
     * @return RemoteWebDriver
     */
    protected function driver()
    {
        $options = (new ChromeOptions)->addArguments(collect([
            '--window-size=1920,1080',
            '--no-sandbox',
            '--ignore-certificate-errors',
        ])->unless($this->hasHeadlessDisabled(), function ($items) {
            return $items->merge([
                '--disable-gpu',
                '--headless',
            ]);
        })->all());

        return RemoteWebDriver::create(
            $_ENV['DUSK_DRIVER_URL'] ?? 'http://localhost:9515',
            DesiredCapabilities::chrome()
            ->setCapability(ChromeOptions::CAPABILITY, $options)
            ->setCapability(WebDriverCapabilityType::ACCEPT_SSL_CERTS, true)
            ->setCapability('acceptInsecureCerts', true)
        );
    }

    /**
     * Determine whether the Dusk command has disabled headless mode.
     *
     * @return bool
     */
    protected function hasHeadlessDisabled()
    {
        return isset($_SERVER['DUSK_HEADLESS_DISABLED']) ||
               isset($_ENV['DUSK_HEADLESS_DISABLED']);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = AdminUser::whereEmail('test@test.com')->first();
        $this->customer = Customer::whereCustomerType('permanent')->first();
        self::$screenPath = app()->basePath() . '/tests/Browser/screenshots';
    }

    /**
     * @return AdminUser
     */
    protected function user()
    {
        return $this->user;
    }

    /**
     * @return Customer
     */
    protected function customer()
    {
        return $this->customer;
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        // your code goes here
    }

    protected function captureFailuresFor($browsers)
    {
        $browsers->each(function (Browser $browser, $key) {
            $body = $browser->driver->findElement(WebDriverBy::tagName('body'));
            if (!empty($body)) {
                $currentSize = $body->getSize();
                $size = new WebDriverDimension($currentSize->getWidth(), $currentSize->getHeight());
                $browser->driver->manage()->window()->setSize($size);
            }
            $file = 'failure-'.$this->getName().'-'.$key;
            $browser->screenshot($file);
            @chmod(self::$screenPath . '/' . $file, 0666);
        });
    }

    public static function createJpeg( $screenName, $removeOrigial = true ) {
        $publicPath		= storage_path('/app/public/reports/images');
        $screenFullPath = self::$screenPath .'/'.$screenName . '.png';
        $thumbPath		= $publicPath . '/thumbs';
        $fileToSave 	= $publicPath.'/'.$screenName.'.jpg';

        $img = StaticImage::make($screenFullPath)
            ->widen(static::$screenshotWidth)
            ->encode('jpg', static::$screenshotCompression)
            ->save($fileToSave)
        ;

        @chmod($fileToSave, 0666);
        self::createJpegThumbnail( $img, $thumbPath );

        if($removeOrigial) {
            unlink($screenFullPath);
        }

        return $img;
    }

    public static function createJpegThumbnail( Image $img, $path ) {
        $file = $path.'/'.$img->filename.'.'.$img->extension;
        $img = StaticImage::make($img->basePath())
            ->widen(static::$screenshotThumbWidth)
            ->save($file)
        ;
        @chmod($file, 0666);
        return $img;
    }

}
