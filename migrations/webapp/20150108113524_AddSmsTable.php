<?php

class AddSmsTable extends Ruckusing_Migration_Base
{
    public function up()
    {
        $sms = $this->create_table('sms', ['id' => false, 'options' => 'Engine=InnoDB']);
        $sms->column(
            'id',
            'integer',
            [
                'primary_key' => true,
                'auto_increment' => true,
                'null' => false
            ]
        );
        $sms->column('created_at','datetime');
        $sms->column('task_id','integer');
        $sms->column('sid','text');
        $sms->column('from','text');
        $sms->column('to','text');
        $sms->column('body','text');
        $sms->finish();
    }//up()

    public function down()
    {
    }//down()
}
