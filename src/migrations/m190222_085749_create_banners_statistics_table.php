<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%banners_statistics}}`.
 */
class m190222_085749_create_banners_statistics_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%banners_statistics}}', [
            'id' => $this->primaryKey(11)->unsigned(),
			'banner_id' => $this->integer(11)->unsigned(),
			'action' => $this->tinyInteger(1)->unsigned()->defaultValue(0)->notNull(),
			'created_at' => $this->dateTime()->notNull(),
        ]);

		$this->createIndex('idx-banner_id', 'banners_statistics', 'banner_id');
		$this->createIndex('idx-created_at', 'banners_statistics', 'created_at');
		$this->createIndex('idx-action', 'banners_statistics', 'action');

		$this->addForeignKey(
			'FK-banners_statistics-banner_id-banners-id',
			'banners_statistics',
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
    	$this->dropForeignKey('FK-banners_statistics-banner_id-banners-id', '{{%banners_statistics}}');
        $this->dropTable('{{%banners_statistics}}');
    }
}
