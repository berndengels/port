<?php
namespace Tests;

use Exception;
use Carbon\Carbon;
use App\Models\AdminUser;
use App\Models\Boat;
use App\Models\GuestBoat;
use App\Models\Caravan;
use App\Models\Customer;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\WebDriverCapabilityType;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverDimension;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Cache;
use Laravel\Dusk\Browser;
use Laravel\Dusk\TestCase as BaseTestCase;
use Intervention\Image\ImageManagerStatic as StaticImage;
use Intervention\Image\Image;

abstract class DuskTestCase extends BaseTestCase
{
    protected $useHeadless = true;
    protected $dbConnectionName = 'demo';
    protected $useNotTearDown = false;
    public static $screenshotWidth 			= 1200;
    public static $screenshotHeight 		= 1600;
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
     * @var GuestBoat
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
    protected $screenDirectory;

    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';
        $app->make(Kernel::class)->bootstrap();
        return $app;
    }

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

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('cache:clear');
        Cache::clear();
        $this->artisan('snapshot:load --force port_testing --env=testing');
        $this->user = AdminUser::on('demo')->whereEmail('admin@test.loc')->first();
//        $this->customer = Customer::on('demo')->whereType('permanent')->first();
        $this->customer = Customer::on('demo')->whereEmail('kunde@test.loc')->first();
        self::$screenPath = app()->basePath() . '/tests/Browser/screenshots';
    }

    protected function tearDown(): void
    {
        if($this->useNotTearDown) {
            return;
        }
        parent::tearDown();
    }

    /**
     * @return AdminUser
     */
    protected function user(): AdminUser
    {
        return $this->user;
    }

    /**
     * @return Customer
     */
    protected function customer(): Customer
    {
        return $this->customer;
    }

    /**
     * Create the RemoteWebDriver instance.
     *
     * @return RemoteWebDriver
     */
    protected function driver()
    {
        $options = (new ChromeOptions)->addArguments(collect([
            '--window-size=' . static::$screenshotWidth. ',' . static::$screenshotHeight,
            '--no-sandbox',
            '--ignore-certificate-errors',
        ])->unless(! $this->useHeadless, function ($items) {
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

    protected function captureFailuresFor($browsers)
    {
        $browsers->each(function (Browser $browser, $key) {
            try {
                $main = $browser->driver->findElement(WebDriverBy::tagName('main'));
                if (!empty($main)) {
                    $currentSize = $main->getSize();
                    $size = new WebDriverDimension($currentSize->getWidth(), $currentSize->getHeight());
                    $browser->driver->manage()->window()->setSize($size);
                }
                $file = 'failure-'.$this->getName().'-'.$key;
                $browser->screenshot($file);
                @chmod(self::$screenPath . '/' . $file, 0666);
            } catch(Exception $e) {
                dump($e->getMessage());
            }
        });
    }

    public function createJpeg( $screenName, $removeOrigial = true ) {
        $publicPath		= storage_path('/app/public/reports/images');
        $screenFullPath = self::$screenPath .'/'.$screenName . '.png';
        $thumbPath		= $publicPath . '/thumbs';
        $fileToSave 	= $publicPath.'/'.$screenName.'.jpg';

        try {
            $size = $this->driver()->manage()->window()->fullscreen()->getSize();
            $img = StaticImage::make($screenFullPath)->resize($size);
            $img->encode('jpg', static::$screenshotCompression)->save($fileToSave);
            @chmod($fileToSave, 0666);
            $this->createJpegThumbnail( $img, $thumbPath );

            if($removeOrigial) {
                unlink($screenFullPath);
            }

            return $img;
        } catch(Exception $e) {
            return null;
        }
    }

    public function createJpegThumbnail( Image $img, $path ) {
        $file = $path.'/'.$img->filename.'.'.$img->extension;
        $img = StaticImage::make($img->basePath())
            ->widen(static::$screenshotThumbWidth)
            ->save($file)
        ;
        @chmod($file, 0666);
        return $img;
    }
}
