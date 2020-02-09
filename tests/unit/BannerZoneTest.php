<?php 
class BannerZoneTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
	/**
	 * @var \prokhonenkov\bannerssystem\BannerZone
	 */
    private $zone;
    
    protected function _before()
    {
    	$this->zone = \prokhonenkov\bannerssystem\BannerZone::getInstance();
    }

    protected function _after()
    {
    }

    // tests
    public function testSetZone()
    {

		$html = $this->zone->setZoneById(1, []);
		$this->assertIsString($html);
		$this->assertTrue(strpos($html, 'banner-system hidden') !== false);
    }

    public function testGetZoneIds()
	{
		$this->assertIsArray($this->zone->getZoneIds());
	}
}