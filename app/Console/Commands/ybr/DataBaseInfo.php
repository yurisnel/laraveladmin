<?php

namespace App\Console\Commands\ybr;

use DB;
use Illuminate\Support\Facades\Config;

class DataBaseInfo
{

    public static  function getTables()
    {
        $bdName = Config::get("database.connections." . Config::get("database.default") . ".database");

        $sql = "SHOW TABLES FROM " . $bdName;
        $result = DB::select($sql);
        $data = array();
        foreach ($result as $row) {
            $row = ((array)$row);
            foreach ($row as $k => $v)
                $data[] = $v;
        }

        return $data;
    }

    public static  function getFields($tbName)
    {
        /*para obtener los nombre lo los campos de la tabla*/
        /*$query="SELECT * FROM ".$this->tb_nombre." LIMIT 0,1";
        $result=$this->server->Ejecutar($query);

        $this->campos=$this->server->NombreCampos($result);*/

        $sql = "SHOW COLUMNS FROM " . $tbName;
        $result = DB::select($sql);
        $fields = array();

        foreach ($result as $row) {
            $data = [];
            $data['name'] = $row->Field;
            $data['default'] = $row->Default;

            if ($row->Null == 'NO')
                $data['null'] = 'false';
            else
                $data['null'] = 'true';

            $patron = "/^(.+)\((.+)\)$/";
            $asunto = $row->Type;
            preg_match($patron, $asunto, $coincid);


            $data['type'] = !empty($coincid[1]) ? $coincid[1] : $row->Type;
            $data['size'] = !empty($coincid[2]) ? $coincid[2] : 50;
            $data['isKey'] = false;

            if ($row->Key == 'PRI') {
                $data['isKey'] = true;

                if ($row->Extra == 'auto_increment') {
                    $data['auto_increment'] = true;
                    $data['null'] = 'true'; // no es obligatorio entrarlo
                }
            }

            $fields[$row->Field] = $data;
        }

        return $fields;
    }

    public static function getForeignKeys()
    {

        $bdName = Config::get("database.connections." . Config::get("database.default") . ".database");

        $sql = "SELECT table_name,column_name,referenced_table_name,  referenced_column_name FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
WHERE table_schema = '" . $bdName . "'   and referenced_column_name!='Null'";

        $result = DB::select($sql);

        $data = array();

        foreach ($result as $row) {
            $row = (array)$row;
            $data[$row['table_name']][$row['column_name']] = array('refTb' => $row['referenced_table_name'], 'refColum' => $row['referenced_column_name']);
        }

        return $data;
    }
}
