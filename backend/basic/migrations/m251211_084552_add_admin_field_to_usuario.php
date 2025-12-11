<?php

use yii\db\Migration;

class m251211_084552_add_admin_field_to_usuario extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('usuario', 'admin', $this->boolean()->defaultValue(false));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('usuario', 'admin');
    }
}