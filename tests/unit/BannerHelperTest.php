<?php 
class BannerHelperTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

	public static function callMethod($name, array $args) {
    	$obj = new \prokhonenkov\bannerssystem\helpers\BannerHelper();
		$class = new \ReflectionClass($obj);
		$method = $class->getMethod($name);
		$method->setAccessible(true);
		return $method->invokeArgs($obj, $args);
	}

    // tests

    public function testGetUploadHtml()
    {
    	try {
			$this->callMethod('getUploadHtml', [
				'url' => 'uploa/240x400.zip',
				'width' => '240',
				'height' => '400'
			]);
		} catch (\Exception $e) {
    		$this->assertEquals('Unable to unpack archive', $e->getMessage());
		}

		try {
			$this->callMethod('getUploadHtml', [
				'url' => 'upload/240x400-empty.zip',
				'width' => '240',
				'height' => '400'
			]);
		} catch (\Exception $e) {
    		$this->assertEquals('The archive is missing index.html', $e->getMessage());
		}

		$indexHtml = sprintf('%s/%s/index.html',
			\Yii::$app->getModule('bannersSystem')->uploadDir,
			'upload'
		);
		try {
			unlink($indexHtml);
		} catch (\Exception $e) {

		}

		$result = $this->callMethod('getUploadHtml', [
			'url' => 'upload/240x400.zip',
			'width' => '240',
			'height' => '400'
		]);

    	$this->assertTrue(file_exists($indexHtml));

		$this->assertIsString($result);
		$this->assertTrue(strpos($result, 'iframe') !== false);
		$this->assertTrue(strpos($result, 'width="240px"') !== false);
		$this->assertTrue(strpos($result, 'height="400px"') !== false);

		$result = $this->callMethod('getUploadHtml', [
			'url' => 'upload/banner-240.png',
		]);

		$this->assertTrue(strpos($result, 'img') !== false);
		$this->assertTrue(strpos($result, 'width="240px"') === false);
		$this->assertTrue(strpos($result, 'height="400px"') === false);
    }

    public function testGetUploadDir()
	{
		$this->assertIsString(\prokhonenkov\bannerssystem\helpers\BannerHelper::getUploadDir());
		$this->assertEquals(\Yii::$app->getModule('bannersSystem')->uploadDir, \prokhonenkov\bannerssystem\helpers\BannerHelper::getUploadDir());
	}

	public function testGetUploadUrl()
	{
		$this->assertIsString(\prokhonenkov\bannerssystem\helpers\BannerHelper::getUploadUrl());
		$this->assertEquals(\Yii::$app->getModule('bannersSystem')->uploadUrl, \prokhonenkov\bannerssystem\helpers\BannerHelper::getUploadUrl());
	}
}