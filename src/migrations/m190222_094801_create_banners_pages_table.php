<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%banners_pages}}`.
 */
class m190222_094801_create_banners_pages_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%banners_pages_urls}}', [
            'id' => $this->primaryKey(11)->unsigned(),
			'banner_id' => $this->integer(11)->unsigned(),
			'url' => $this->string(255),
			'is_through' => $this->tinyInteger(1)->unsigned()->notNull()->defaultValue(0),
        ]);

		$this->createIndex('idx-banner_id', 'banners_pages_urls', 'banner_id');
		$this->createIndex('idx-is_through', 'banners_pages_urls', 'is_through');
		$this->createIndex('idx-url', 'banners_pages_urls', 'url');


		$this->addForeignKey(
			'FK-banners_pages_urls-banner_id-banners-id',
			'banners_pages_urls',
			'banner_id',
			'banners',
			'id',
			'CASCADE'
		);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    	$this->dropForeignKey('FK-banners_pages_urls-banner_id-banners-id', '{{%banners_pages}}');
        $this->dropTable('{{%banners_pages}}');
    }
}
