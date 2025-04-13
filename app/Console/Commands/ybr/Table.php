<?php

namespace App\Console\Commands\ybr;

use Illuminate\Support\Str;


class Table
{
    protected $tbname, $tableTh, $tableTd, $formFields, $formFillable, $details;
    protected $tbkey, $objfs, $constFields, $fieldMigration;
    protected $tplVersion;
    static $foreignKeys;
    static $fathers;
    static $childrens;


    public function getNameTable()
    {
        return $this->tbname;
    }

    public function getNameTableUppercase()
    {
        return ucfirst($this->tbname);
    }

    public function getNameTableSingular()
    {
        $nameSing = Str::singular(Str::snake($this->tbname));
        return $nameSing;
    }

    public function getNameModel()
    {
        return ucfirst($this->getNameTableSingular());
    }

    function __construct($tbName, $tplVersion = 'frontier')
    {
        $this->tbname = $tbName;
        $this->tplVersion = $tplVersion;
        if (!self::$fathers && !self::$childrens) {

            $foreignKeys = DataBaseInfo::getForeignKeys();
            $fathers = [];
            $childrens = [];
            foreach ($foreignKeys as $tb => $ref) {
                foreach ($ref as $key => $value) {
                    $refTb = $value['refTb'];
                    $fathers[$tb][$refTb] = array($key, $value['refColum']);
                    $childrens[$refTb][$tb] = array($value['refColum'], $key);
                }
            }

            $fathers = $fathers;
            $childrens = $childrens;
        }

        $data = DataBaseInfo::getFields($tbName);

        $this->tableTh = "\n";
        $this->tableTd = "\n";
        $this->formFields = "\n";
        $this->details = "\n";
        $sepItem = "";
        foreach ($data as $dataCmp) {
            $isKey = $dataCmp['isKey'];

            $field = new Field($dataCmp);
            $fieldName = $field->getName();
            if ($isKey) {
                $this->tbkey = $field->getName();
            }

            if (!in_array($fieldName, ['created_at', 'updated_at', 'deleted_at'])) {
                if (!$isKey) {
                    $this->formFields .= $field->getFieldForm($tplVersion);
                    $this->formFillable .= ($this->formFillable ? $sepItem : '') . $field->getFillable();
                }

                $this->tableTh .= $sepItem . $field->getTh($tplVersion);
                $this->tableTd .= $sepItem . $field->getTd($tplVersion);
            }

            if (!in_array($fieldName, ['deleted_at'])) {
                $this->details .= $field->getDetails($tplVersion);
            }

            $sepItem = ", "; // "\n"


            $this->constFields .= $field->getConstField($this->tbname);

            if (!empty($foreignKeys[$tbName])) {
                $this->objfs .= $field->getObjField($foreignKeys[$tbName]);
                $this->fieldMigration .= $field->getFieldMigration($foreignKeys[$tbName]);
            }
        }
        $this->constFields .= "const ALL='" . $this->tbname . ".*' ;" . "\n\n";
    }

    public function createMigration()
    {
        $html = file_get_contents(dirname(__FILE__) . "/tpl/migration.tpl");
        $html = preg_replace(["/NAME_MODEL/", "/TABLE_FIELDS/"], [$this->getNameModel(), $this->fieldMigration], $html);
        return $html;
    }

    public function createModel()
    {
        $html = file_get_contents(dirname(__FILE__) . "/tpl/model.tpl");
        $html = preg_replace(["/NAME_MODEL/", "/FILLABLE/"], [$this->getNameModel(), $this->formFillable], $html);
        return $html;
    }

    public function createRepository()
    {
        $html = file_get_contents(dirname(__FILE__) . "/tpl/repository.tpl");
        $html = preg_replace(["/NAME_MODEL/"], [$this->getNameModel()], $html);
        return $html;
    }

    public function createController()
    {
        $html = file_get_contents(dirname(__FILE__) . "/tpl/controller.tpl");
        $html = preg_replace(["/NAME_TABLE/", "/NAME_MODEL/"], [$this->getNameTable(), $this->getNameModel()], $html);
        return $html;
    }

    public function createRoutes()
    {
        $html = file_get_contents(dirname(__FILE__) . "/tpl/routes.tpl");
        $html = preg_replace(["/NAME_TABLE/", "/NAME_MODEL/"], [$this->getNameTable(), $this->getNameModel()], $html);
        return $html;
    }

    public function createSeeder()
    {
        $html = file_get_contents(dirname(__FILE__) . "/tpl/seeder.tpl");
        $html = preg_replace(["/NAME_TABLE/", "/NAME_MODEL/"], [$this->getNameTable(), $this->getNameModel()], $html);
        return $html;
    }

    public function createCreate()
    {
        $tplVersion = $this->tplVersion;
        $html = file_get_contents(dirname(__FILE__) . "/tpl/$tplVersion/create.tpl");
        $html = preg_replace(["/NAME_TABLE/", "/NAME_MODEL/"], [$this->getNameTable(), $this->getNameModel()], $html);
        return $html;
    }

    public function createEdit()
    {
        $tplVersion = $this->tplVersion;
        $html = file_get_contents(dirname(__FILE__) . "/tpl/$tplVersion/edit.tpl");
        $html = preg_replace(["/NAME_TABLE/", "/NAME_MODEL/"], [$this->getNameTable(), $this->getNameModel()], $html);
        return $html;
    }

    public function createForm()
    {
        $tplVersion = $this->tplVersion;
        $html = file_get_contents(dirname(__FILE__) . "/tpl/$tplVersion/form.tpl");
        $html = preg_replace(["/NAME_MODEL/", "/FORM_FIELDS/"], [$this->getNameModel(), $this->formFields], $html);
        return $html;
    }

    public function createShow()
    {
        $tplVersion = $this->tplVersion;
        $html = file_get_contents(dirname(__FILE__) . "/tpl/$tplVersion/show.tpl");
        $html = preg_replace(["/NAME_TABLE/", "/NAMEs_TABLE/", "/NAME_MODEL/", "/DATA_FIELDS/"], [$this->getNameTable(), $this->getNameTableSingular(), $this->getNameModel(), $this->details], $html);
        return $html;
    }

    public function createIndex()
    {
        $tplVersion = $this->tplVersion;
        $html = file_get_contents(dirname(__FILE__) . "/tpl/$tplVersion/index.tpl");
        $html = preg_replace(["/NAME_TABLE/", "/NAME_MODEL/", "/TABLE_TH/", "/TABLE_TD/"], [$this->getNameTable(), $this->getNameModel(), $this->tableTh, $this->tableTd], $html);
        return $html;
    }
}
