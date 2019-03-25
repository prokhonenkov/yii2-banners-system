<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%banners}}`.
 */
class m190222_085314_create_banners_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%banners}}', [
            'id' => $this->primaryKey(11)->unsigned(),
			'title' => $this->string(255)->notNull(),
			'banner_dir' => $this->string(255)->notNull(),
			'html' => $this->text(),
			'link' => $this->string(255),
			'is_active' => $this->tinyInteger(1)->defaultValue(0)->unsigned()->notNull(),
			'zone_id' => $this->tinyInteger(3)->unsigned()->notNull(),
			'created_at' => $this->dateTime()->notNull(),
			'updated_at' => $this->dateTime()->null(),
        ]);

		$this->createIndex('idx-is_active', 'banners', 'is_active');
		$this->createIndex('idx-created_at', 'banners', 'created_at');
		$this->createIndex('idx-zone_id', 'banners', 'zone_id');

		$this->addForeignKey(
			'FK-banners-zone_id-banners_zones-id',
			'banners','zone_id',
			'banners_zones',
			'id',
			'CASCADE',
			'NO ACTION'
		);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    	$this->dropForeignKey('FK-banners-zone_id-banners_zones-id', '{{%banners}}');
        $this->dropTable('{{%banners}}');
    }
}
