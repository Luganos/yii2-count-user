<?php


use yii\db\Schema;
use yii\db\Migration;


class m130524_201443_init extends Migration
{
    public function up()
    {

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
		
        //Table contains current date(tbl_data)
        $this->createTable('{{%tbl_data}}', [
            'id' => Schema::TYPE_PK,
            'YMD' => Schema::TYPE_DOUBLE,
        ], $tableOptions);
		
        //Table contains ip - address  of users(tbl_ips)
        $this->createTable('{{%tbl_ips}}', [
            'id' => Schema::TYPE_PK,
            'ip_address' => Schema::TYPE_STRING . '(25)',
        ], $tableOptions);
		
       
        //Table contains list of visitors day by day(tbl_visits)
        $this->createTable('{{%tbl_visits}}', [
            'visit_id' => Schema::TYPE_PK,
            'data' => Schema::TYPE_DATE,
            'hosts' => Schema::TYPE_INTEGER . '(12)',
            'views' => Schema::TYPE_INTEGER . '(12)',
        ], $tableOptions);


        $this->insert('{{%tbl_data}}', [
            'YMD' => time(),
        ]);

    }
    public function down()
    {
        $this->dropTable('{{%tbl_data}}');
        $this->dropTable('{{%tbl_visits}}');
        $this->dropTable('{{%tbl_ips}}');

    }
}
