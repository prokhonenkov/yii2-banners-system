<?php 
class ZoneTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /** @var \prokhonenkov\bannerssystem\models\Zone */
    private $zone;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testValidate()
    {
		$zone = new \prokhonenkov\bannerssystem\models\Zone();
		$this->assertFalse($zone->validate());

		$zone->title = 'TestZone';
		$this->assertTrue($zone->validate());

		$zone->is_active = \prokhonenkov\bannerssystem\helpers\BannerHelper::STATUS_ACTIVE;
		$zone->type = \prokhonenkov\bannerssystem\models\Zone::TYPE_ROTATE;

		$zone->width = 'qwe';
		$zone->height = 'asd';
		$this->assertFalse($zone->validate());
		$this->assertTrue(count($zone->errors) === 2);

		$zone->width = 100;
		$zone->height = 100;
		$this->assertTrue($zone->validate());

		return $zone;
	}

	/**
	 * @depends testValidate
	 */
	public function testSave(\prokhonenkov\bannerssystem\models\Zone $zone)
	{
		$this->assertTrue($zone->save());

		return $zone;
	}

	/**
	 * @param \prokhonenkov\bannerssystem\models\Zone $zone
	 * @depends testSave
	 */
	public function testGetForDropDown(\prokhonenkov\bannerssystem\models\Zone $zone)
	{
		$dd = $zone->getForDropDown();
		$this->assertTrue(!empty($dd));
		$this->assertTrue(is_array($dd));
	}

	/**
	 * @param \prokhonenkov\bannerssystem\models\Zone $zone
	 * @depends testSave
	 */
	public function testDelete(\prokhonenkov\bannerssystem\models\Zone $zone)
	{
		$this->assertTrue((bool)$zone->delete());
	}
}