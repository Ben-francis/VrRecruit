<?php

namespace Vreasy\Models;

use Vreasy\Query\Builder;

class Sms extends Base
{
    // Protected attributes should match table columns
    protected $id;
    protected $created_at;
    protected $task_id;
    protected $sid;
    protected $from;
    protected $to;
    protected $body;
   

    public function __construct()
    {
           
        // Validation is done run by Valitron library
        $this->validates(
            'required',
            ['task_id', 'sid', 'from', 'to', 'body']
        );
        $this->validates(
            'date',
            ['created_at']
        );
        $this->validates(
            'integer',
            ['id', 'task_id']
        );
    }
    
   
    public function save()
    {
        // Base class forward all static:: method calls directly to Zend_Db
        if ($this->isValid()) {
            
                static::insert('sms', $this->attributesForDb());
                $this->id = static::lastInsertId();
           
            return $this->id;
        }
    }

    public static function findOrInit($id)
    {
        $task = new Task();
        if ($tasksFound = static::where(['id' => (int)$id])) {
            $task = array_pop($tasksFound);
        }
        return $task;
    }

    public static function guessStatus($body){
        
        //If is no, first letter will always be n, else presume is yes.
        //First strip all weird characters and whitespace, convert to lowercase
        $body=preg_replace('/\s+/', '', $body);
        $body=preg_replace('/[^A-Za-z0-9\-]/', '', $body);
        $body=strtolower($body);
        
        $firstletter=substr($body,0,1);
        if($firstletter =='n') return 'refused';
        return 'accepted';
        
    }

    public static function where($params, $opts = [])
    {
        // Default options' values
        $limit = 0;
        $start = 0;
        $orderBy = ['created_at'];
        $orderDirection = ['ASC'];
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
        $select = "SELECT t.* FROM sms AS t";

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
