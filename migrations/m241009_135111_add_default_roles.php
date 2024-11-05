<?php

use yii\db\Migration;
use common\models\Role;
use app\modules\specialsection\classes\Section;

/**
 * Class m241009_135111_add_default_roles
 */
class m241009_135111_add_default_roles extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sections = Section::getSections();
        $roles = [];
        foreach ($sections as $section) {
            $roles[] = ['editor_' . $section];
        }

        \Yii::$app->db->createCommand()
                     ->batchInsert(
                         Role::tableName(),
                         ['name'],
                         $roles
                     )
                     ->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241009_135111_add_default_roles cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241009_135111_add_default_roles cannot be reverted.\n";

        return false;
    }
    */
}