<?php

    namespace App\Models;

    use mysqli;

    class BaseModel
    {
        protected static $tableName;
        protected static $connection;
        protected static $fillable = [];

        protected static function getConnection(): mysqli
        {
            if(!self::$connection) {
                self::$connection = new mysqli('localhost', 'root', '', 'mvc');
            }
            return self::$connection;
        }

        protected static function getTableName(): string
        {
            if(empty(static::$tableName)) {
                $className = static::class;
                $className = explode('\\', $className);
                $className = array_pop($className);
                $className = strtolower($className);
                $tableName = $className."s";
            } else {
                $tableName = static::$tableName;
            }
            return $tableName;
        }

        public static function selectAll(): array
        {
            $connection = self::getConnection();
            $tableName = static::getTableName();
            $res = $connection->query("SELECT * FROM ".$tableName);
            $arr = [];
            while($row = $res->fetch_object(static::class)){ // like Product::class
                $arr[] = $row;
            }
            return $arr;
        }

        /**
         *
         * @return object|\stdClass
         * @var mysqli $connection
         */

        public static function findById($id) {

            $connection = self::getConnection();

            $sql = 'select * from '.static::getTableName(). ' where id=?';
            $smth = $connection->prepare($sql);

            $tableName = static::getTableName();
            $smth->bind_param('i', $id);
            $smth->execute();
            $result = $smth->get_result();

            return $result->fetch_object(static::class);
        }


        public function save() {
            $connection = self::getConnection();
            $tableName = static::getTableName();

            if(isset($this->id) && !empty($this->$id)) {
                // update query
            } else {
                $fields = implode(' , ', static::$fillable);
                $values = [];

                foreach(static::$fillable as $attributeName) {
                    $values[] = $this->{$attributeName} ?? null;
                }
                $values = "'" . implode("' , '", $values) . "'";
                $sql = "insert into {$tableName} ({$fields}) values ({$values})";
                print_r($sql);
                $connection->query($sql);

                if($connection->insert_id) {
                    $this->id = $connection->insert_id;
                }
            }


        }




    }