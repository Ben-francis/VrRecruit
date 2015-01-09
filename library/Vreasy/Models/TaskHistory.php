<?php

namespace Vreasy\Models;

use Vreasy\Query\Builder;

class TaskHistory extends Base
{
    // Protected attributes should match table columns
    protected $id;
    protected $task_id;
    protected $changed_at;
    protected $status;
   

    public function __construct()
    {
        // Validation is done run by Valitron library
        $this->validates(
            'required',
            ['task_id', 'status']
        );
        $this->validates(
            'date',
            ['changed_at']
        );
        $this->validates(
            'integer',
            ['id']
        );
    }

    public function save()
    {
        // Base class forward all static:: method calls directly to Zend_Db
        if ($this->isValid()) {
            $this->changed_at = gmdate(DATE_FORMAT);
             
            static::insert('task_history', $this->attributesForDb());
            $this->id = static::lastInsertId();
            
            
            return $this->id;
        }
    }

    public static function findOrInit($id)
    {
       $task = new TaskHistory();
        if ($tasksFound = static::where(['task_id' => (int)$task_id])) {
            $task = array_pop($tasksFound);
            return $task;
        }
        return task;
    }
    
   
    
  
    
    public static function where($params, $opts = [])
    {
        // Default options' values
        $limit = 0;
        $start = 0;
        $orderBy = ['changed_at'];
        $orderDirection = ['desc'];
        extract($opts, EXTR_IF_EXISTS);
        $orderBy = array_flatten([$orderBy]);
        $orderDirection = array_flatten([$orderDirection]);

        // Return value
        $collection = [];
        // Build the query
        list($where, $values) = Builder::expandWhere(
            $params,
            ['wildcard' => true, 'prefix' => 't.']);

        // Select header
        $select = "SELECT t.* FROM task_history AS t";

        // Build order by
        foreach ($orderBy as $i => $value) {
            $dir = isset($orderDirection[$i]) ? $orderDirection[$i] : 'ASC';
            $orderBy[$i] = "`$value` $dir";
        }
        $orderBy = implode(', ', $orderBy);

        $limitClause = '';
        if ($limit) {
            $limitClause = "LIMIT $start, $limit";
        }

        $orderByClause = '';
        if ($orderBy) {
            $orderByClause = "ORDER BY $orderBy";
        }
        if ($where) {
            $where = "WHERE $where";
        }

        $sql = "$select $where $orderByClause $limitClause";
        if ($res = static::fetchAll($sql, $values)) {
            foreach ($res as $row) {
                $collection[] = static::instanceWith($row);
            }
        }
        return $collection;
    }
}
