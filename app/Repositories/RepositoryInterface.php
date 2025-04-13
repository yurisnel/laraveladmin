<?php

namespace App\Repositories;

interface RepositoryInterface
{
    public function all();

    public function findByIdOrFail($id);

    public function findByField($fieldName, $fieldValue);

    public function findByFieldFirst($fieldName, $fieldValue);
    
    public function findWhere(array $where);
    
    public function create(array $attributes);

    public function createList(array $list);

    public function update(array $attributes, $id);

    public function delete($id);

    public function geTableName();

}
