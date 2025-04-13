<?php

namespace App\Console\Commands\ybr;

class Field
{

    private $data;

    function __construct($pdata)
    {
        $this->data = $pdata;
    }

    public function getName()
    {
        return $this->data["name"];
    }
    public function getLabel()
    {
        return ucfirst($this->data["name"]);
    }

    public function param($name)
    {
        return $this->data[$name];
    }

    function getConstField($tabla)
    {
        return "const " . strtoupper($this->getName()) . " = '" . $tabla . "." . $this->getName() . "' ;\n\n";
    }

    function getFillable()
    {
        return "'" . $this->getName() . "'";
    }

    function getFieldForm($tpl)
    {
        $html = file_get_contents(dirname(__FILE__) . "/tpl/$tpl/form_field.tpl");
        $atrributes = "";

        if ($this->param("null") == "false") {
            $atrributes = 'required="true"';
        }

        $html = preg_replace(["/NAME/", "/LABEL/", "/ATRRIBUTES/"], [$this->getName(), $this->getLabel(), $atrributes], $html);
        return $html . "\n";
    }

    function getDetails($tpl)
    {
        $html = file_get_contents(dirname(__FILE__) . "/tpl/$tpl/detail_line.tpl");
        $html = preg_replace(["/NAME/", "/LABEL/"], [$this->getName(), $this->getLabel()], $html);
        return $html . "\n";
    }

    function getTh($tpl)
    {
        //return  '<th><a href="' . $tableName . '/order/' . $this->getName() . '" class="linkAjax">' . ucfirst($this->getName()) . '</a></th>';
        //return  "<th>" . ucfirst($this->getName()) . "</th>" ;
        //return "'" . $this->getName() . "'";

        $html = file_get_contents(dirname(__FILE__) . "/tpl/$tpl/table_th.tpl");
        $html = preg_replace(["/NAME/", "/LABEL/"], [$this->getName(), $this->getLabel()], $html);
        return $html;
    }

    function getTd($tpl)
    {
        //return "<td>{{ item." . $this->getName() . " }}</td>" ;
        //return "{data: '" . $this->getName() . "'}";
        $html = file_get_contents(dirname(__FILE__) . "/tpl/$tpl/table_td.tpl");
        $html = preg_replace(["/NAME/", "/LABEL/"], [$this->getName(), $this->getLabel()], $html);
        return $html;
    }


    function getFieldMigration($tbfk)
    {
        $name = $this->getName();
        if (in_array($name, ['created_at', 'updated_at', 'deleted_at'])) return;

        $type = $this->data['type'];
        $size = $this->data['size'];
        $null = $this->data['null'];
        $default = $this->data['default'];
        $isKey = $this->data['isKey'];
        $auto_increment = isset($this->data['auto_increment']) ? $this->data['auto_increment'] : false;
        $field = "";
        $newline = "\n\t\t\t";

        if (!empty($tbfk[$name])) {

            $field = $newline . "\$table->unsignedInteger('" . $name . "');";
            // $field.= $newline."\$table->foreign('".$name."')->references('".$fk['refColum']."')->on('".$fk['refTb']."');"; //->onDelete('cascade')

        } else {

            if ($auto_increment) {
                $field = "increments('" . $name . "')";
            } else
                switch ($type) {
                    case "boolean":
                        $field = "boolean('" . $name . "')";
                        break;
                    case "char":
                        $field = "char('" . $name . "',$size)";
                        break;
                    case "time":
                        $field = "time('" . $name . "')";
                        break;
                    case "date":
                        $field = "date('" . $name . "')";
                        break;
                    case "datetime":
                        $field = "dateTime('" . $name . "')";
                        break;
                    case "timestamp":
                        $field = "timestamp('" . $name . "')";
                        break;
                    case "decimal":
                        $field = "decimal('" . $name . "',$size,2)";
                        break;
                    case "double":
                        $field = "double('" . $name . "',$size,2)";
                        break;
                    case "int":
                    case "integer":
                        $field = "integer('" . $name . "')";
                        break;
                    case "tinyint":
                        $field = "tinyInteger('" . $name . "')";
                        break;
                    case "float":
                        $field = "float('" . $name . "')";
                        break;
                    case "text":
                        $field = "text('" . $name . "')";
                        break;
                    default:
                    case "varchar":
                        $field = "string('" . $name . "',$size)";
                        break;
                }

            if ($default) {
                $field .= "->default('" . $default . "')";
            }
            if ($null == "true" && !$isKey) {
                $field .= "->nullable()";
            }

            $field = $newline . "\$table->" . $field . ";";
        }

        /*if($isKey){
            $field="\n \$table->primary('".$name."')".";\n";
        }*/

        return $field;
    }

    function getObjField($tbfk)
    {

        if (!empty($tbfk[$this->getName()])) {
            $fk = $tbfk[$this->getName()];
            $clase = 'listf';
            //$add=", 'tbname'=>'".$fk['refTb']."' ,'tbvalue'=>'".$fk['refColum']."' ,'tblabel'=>'".$fk['refColum']."'";
            $add = ", 'tbname'=>'" . $fk['refTb'] . "'";
        } else {
            $clase = 'text';
            $add = '';
        }

        $cadObj = "new " . $clase . "(array('name'=>'" . $this->getName() . "','label'=>'" . ucwords($this->getName()) . "',  'type'=>'" . $this->data['type'] . "',	'size'=>'" . $this->data['size'] . "','null'=>'" . $this->data['null'] . "' " . $add . ")),\n";

        return     $cadObj;
    }
}
