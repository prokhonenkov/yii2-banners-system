<?php 
class PageUrlTest extends \Codeception\Test\Unit
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
	 * @return \prokhonenkov\bannerssystem\models\PageUrl
	 */
    public function testBatchUpdate()
    {
		$bannerId = \prokhonenkov\bannerssystem\models\Banner::find()->select('id')->scalar();

		$result = \prokhonenkov\bannerssystem\models\PageUrl::batchUpdate(
			$bannerId,
			[
				[
					'url' => 'some.lnk',
					'is_through' => 1
				]
			]
		);

		$this->assertTrue($result);

		$this->assertTrue(\prokhonenkov\bannerssystem\models\PageUrl::find()
			->where(['banner_id' => $bannerId])
			->exists());

		$result = \prokhonenkov\bannerssystem\models\PageUrl::batchUpdate(
			$bannerId,
			[]
		);

		$this->assertTrue($result);

		$this->assertFalse(\prokhonenkov\bannerssystem\models\PageUrl::find()
			->where(['banner_id' => $bannerId])
			->exists());
    }
}