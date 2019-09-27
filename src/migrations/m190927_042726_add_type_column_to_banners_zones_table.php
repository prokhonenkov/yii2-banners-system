<?php

use yii\db\Migration;

/**
 * Handles adding type to table `{{%banners_zones}}`.
 */
class m190927_042726_add_type_column_to_banners_zones_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
    	$this->addColumn('banners_zones', 'type', $this->tinyInteger(1)->unsigned()->defaultValue(\prokhonenkov\bannerssystem\models\Zone::TYPE_ROTATE));
    	$this->createIndex('idx-type', 'banners_zones', 'type');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
