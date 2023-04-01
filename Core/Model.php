<?php

namespace Core;

/**
 * Base model
 *
 * PHP version 8.2
 */
abstract class Model
{
    protected DB $db;

    public function __construct()
    {

    }


    /**
     */
    public function get($id)
    {
    }

    /**
     */
    public function find(int|string $id, string $selectColumns = '*')
    {
    }


    public function all(string $selectColumns = '*')
    {
    }

    public function create(array $array)
    {
    }


    public function update(array $array)
    {
    }

    public function delete($id)
    {

    }

    public function destroy($id)
    {

    }


    public function where(string $column, string $operator, mixed $value, $selectColumns = '*')
    {

    }


}
