<?php 
class BannerTest extends \Codeception\Test\Unit
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

    // tests

	/**
	 * @return \prokhonenkov\bannerssystem\models\Banner
	 */
    public function testValidate()
    {
		$banner = \Codeception\Stub::make(\prokhonenkov\bannerssystem\models\Banner::class, ['afterSave' => function(){

		}]);

    	$banner->scenario = 'create';
    	$this->assertFalse($banner->validate());

    	$banner->title = 'banner';
    	$this->assertFalse($banner->validate());

    	$banner->banner_dir = uniqid();
		$this->assertFalse($banner->validate());

		$banner->html = 'some html';
		$this->assertFalse($banner->validate());

		$banner->zone_id = 0;
		$this->assertFalse($banner->validate());

		$banner->zone_id = \prokhonenkov\bannerssystem\models\Zone::find()->select('id')->scalar();
		$this->assertTrue($banner->validate());

		$banner->link = 'http://some.lnk';

		return $banner;
	}

	/**
	 * @param \prokhonenkov\bannerssystem\models\Banner $banner
	 * @return \prokhonenkov\bannerssystem\models\Banner
	 * @depends testValidate
	 */
	public function testSave(\prokhonenkov\bannerssystem\models\Banner $banner)
	{
		$this->assertTrue($banner->save());

		return $banner;
	}

	/**
	 * @param \prokhonenkov\bannerssystem\models\Banner $banner
	 * @depends testSave
	 */
	public function testGetBannersByZoneIds(\prokhonenkov\bannerssystem\models\Banner $banner)
	{
		$this->assertTrue(is_array($banner->getBannersByZoneIds(\prokhonenkov\bannerssystem\models\Zone::find()->select('id')->scalar())));
	}

	/**
	 * @param \prokhonenkov\bannerssystem\models\Banner $banner
	 * @throws \yii\db\Exception
	 * @depends testSave
	 */
	public function testSetViews(\prokhonenkov\bannerssystem\models\Banner $banner)
	{
		\prokhonenkov\bannerssystem\models\Banner::setViews(...[$banner->id, $banner->id]);

		$stat = \prokhonenkov\bannerssystem\models\Statistics::find()
			->where([
				'banner_id' => $banner->id
			])
		->count();

		$this->assertTrue((int)$stat === 2);

		\prokhonenkov\bannerssystem\models\Statistics::deleteAll(['banner_id' => $banner->id]);
	}

	/**
	 * @param \prokhonenkov\bannerssystem\models\Banner $banner
	 * @depends testSave
	 */
	public function testSetClick(\prokhonenkov\bannerssystem\models\Banner $banner)
	{
		\prokhonenkov\bannerssystem\models\Banner::setClick($banner->id);

		$stat = \prokhonenkov\bannerssystem\models\Statistics::find()
			->where([
				'banner_id' => $banner->id
			])
			->count();

		$this->assertTrue((int)$stat === 1);

		\prokhonenkov\bannerssystem\models\Statistics::deleteAll(['banner_id' => $banner->id]);
	}

	/**
	 * @param \prokhonenkov\bannerssystem\models\Banner $banner
	 * @depends testSave
	 */
	public function testDelete(\prokhonenkov\bannerssystem\models\Banner $banner)
	{
		$this->assertTrue((bool)$banner->delete());
	}
}