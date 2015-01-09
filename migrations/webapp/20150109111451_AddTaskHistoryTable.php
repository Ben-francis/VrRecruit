<?php

class AddTaskHistoryTable extends Ruckusing_Migration_Base
{
    public function up()
    {   $task_history = $this->create_table('task_history', ['id' => false, 'options' => 'Engine=InnoDB']);
        $task_history->column(
            'id',
            'integer',
            [
                'primary_key' => true,
                'auto_increment' => true,
                'null' => false
            ]
        );
        $task_history->column('changed_at','datetime');
        $task_history->column('task_id','integer');
        $task_history->column('status','text');
        $task_history->finish();
    }//up()

    public function down()
    {
    }//down()
}
