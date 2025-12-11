<?php

use yii\db\Migration;

class m251211_084552_add_admin_field_to_usuario extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('usuario', 'admin', $this->boolean()->defaultValue(false)->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('usuario', 'admin');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m251211_084552_add_admin_field_to_usuario cannot be reverted.\n";

        return false;
    }
    */
}
