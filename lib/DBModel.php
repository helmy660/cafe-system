<?php

class DBModel{
    public function attributes(){

        $sqlString = array();

        foreach ($this->dbFields as $field){
            if(is_int($this->$field) || is_double($this->$field)){
                $sqlString [] = $field."=".$this->$field;
            }else{
                $sqlString [] = $field."='".$this->$field."'";
            }
        }
        return implode( "," , $sqlString );
    }
    public static function read($sql, $type = PDO::FETCH_ASSOC, $class = null)
    {
        global $dbh;
        $results = $dbh->query($sql);
        if ($results) {
            if (null !== $class && $type == PDO::FETCH_CLASS) {
                $data = $results->fetchAll($type, $class);
                if(count($data) == 1) {
                    $data = array_shift($data);
                }
            } else {
                $data = $results->fetchAll($type);
            }
            return $data;
        } else {
            return false;
        }
    }

    private function add()
    {
        global $dbh;
        $sql = "INSERT INTO ".$this->tableName." SET ".$this->attributes();
        echo $sql;
        $affectedRows = $dbh->exec($sql);

        if ($affectedRows != false) {
            $this->id = $dbh->lastInsertId();
        } else {
            return false;
        }
        return $this->id;
    }

    public function update()
    {
        global $dbh;
        $sql = "UPDATE " . $this->tableName." SET ".$this->attributes() .
                 ' WHERE id ='. $this->id;
        $affectedRows = $dbh->exec($sql);
        return $affectedRows != false ? true : false;
    }

    public function delete()
    {
        global $dbh;
        $sql = "DELETE FROM " . $this->tableName . ' WHERE id ='.$this->id;
        $affectedRows = $dbh->exec($sql);

        return $affectedRows != false ? true : false;
    }
    public function delOrder()
    {
        global $dbh;
        $sql = "DELETE FROM " . $this->tableName . ' WHERE order_id = ' . $this->order_id;
        $affectedRows = $dbh->exec($sql);
        return $affectedRows != false ? true : false;
    }

    public function delFromUser()
    {
        global $dbh;
        $sql = "DELETE FROM " . $this->tableName . ' WHERE id = ' . $this->id . ' AND user_id = ' . $this->user_id;
        echo $sql;
        $affectedRows = $dbh->exec($sql);
        return $affectedRows != false ? true : false;
    }
    public function save()
    {
        return ($this->id === null) ? $this->add() : $this->update();
    }
}
 