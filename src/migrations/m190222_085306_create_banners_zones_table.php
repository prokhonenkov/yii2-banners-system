<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%banners_zones}}`.
 */
class m190222_085306_create_banners_zones_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%banners_zones}}', [
			'title' => $this->string(255),
			'width' => $this->smallInteger()->unsigned(),
			'height' => $this->smallInteger()->unsigned(),
			'is_active' => $this->tinyInteger(1)->defaultValue(0)->notNull()->unsigned(),
        ]);

		$this->execute('ALTER TABLE `banners_zones` ADD `id` TINYINT(3) UNSIGNED NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (`id`);');
		$this->createIndex('idx-is_active', 'banners_zones', 'is_active');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%banners_zones}}');
    }
}
