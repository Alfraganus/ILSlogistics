<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%logistic_companies}}`.
 */
class m230908_175123_create_logistic_companies_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%logistic_companies}}', [
            'id' => $this->primaryKey(),
            'company_name'=>$this->string(255)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%logistic_companies}}');
    }
}
