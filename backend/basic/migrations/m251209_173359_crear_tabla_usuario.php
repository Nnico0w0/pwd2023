<?php

use yii\db\Migration;

class m251209_173359_crear_tabla_usuario extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('usuario', [
            'id' => $this->primaryKey(),
            'username' => $this->string(80)->notNull()->unique(),
            'name' => $this->string(80)->notNull(),
            'password' => $this->string(255),
            'authkey' => $this->string(255),
            'accesstoken' => $this->string(255),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('usuario');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m251209_173359_crear_tabla_usuario cannot be reverted.\n";

        return false;
    }
    */
}
