<?php

namespace Core;

use Carbon\Carbon;
use Doctrine\DBAL\Exception;

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
        $this->db = App::db();
    }

    /**
     */
    public function get($id): Redirect|array
    {
        try {
            $data = $this->db->createQueryBuilder()->select('*')
                ->from($this->table)
                ->where("id = ?")
                ->setParameter(0, $id)
                ->orWhere('deleted_at  IS NULL')
                ->fetchAllAssociative();

            return [
                'data' => [
                    'code' => $data ? 200 : 404,
                    'items' => $data ?? []
                ]
            ];
        } catch (\Exception $e) {
            return Redirect::route('/error', ['error_messages' => (array)$e->getMessage()]);
        }
    }

    /**
     */
    public function find(int|string $id, string $selectColumns = '*'): array|Redirect
    {
        try {
            $data = $this->db->createQueryBuilder()->select($selectColumns)
                ->from($this->table)
                ->where("id = ?")
                ->setParameter(0, $id)
                ->fetchAssociative();
            if ($data === false) {
                return Redirect::route('/404');
            }
            return $data ?? [];
        } catch (\Exception $e) {
            return Redirect::route('/error', ['error_messages' => (array)$e->getMessage()]);
        }

    }


    public function all(string $selectColumns = '*'): Redirect|array
    {
        try {
            $data = $this->db->createQueryBuilder()
                ->select($selectColumns)
                ->from($this->table)
                ->fetchAllAssociative();

            return $this->filterOutSoftDeletes($data) ?? [];
        } catch (\Exception $e) {
            return Redirect::route('/error', ['error_messages' => (array)$e->getMessage()]);
        }
    }

    /**
     * @param array $array
     * @return Redirect|array
     */
    public function create(array $array): Redirect|array
    {
        try {
            $appendDates = [
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ];
            $array = array_merge($appendDates, $array);

            $this->db->beginTransaction();
            $this->db->insert($this->table, $array);
            $this->db->commit();

            return $this->findLastInserted();

        } catch (\Exception $e) {
            return Redirect::route('/error', ['error_messages' => (array)$e->getMessage()]);
        }
    }

    /**
     * @param array $array
     * @return Redirect|array
     */
    public function update(array $array): Redirect|array
    {
        try {
            $appendDates = [
                'updated_at' => Carbon::now()->toDateTimeString(),
            ];
            $data = array_merge($appendDates, $array[0]);
            $this->db->beginTransaction();
            $query = $this->db->update($this->table, $data, ['id' => $array['id']]);
            $this->db->commit();

            return [
                'data' => [
                    'message' => $query ? "$this->table updated successfully" : "Error updating $this->table",
                    'code' => $query ? 200 : 400
                ]];
        } catch (\Exception $e) {
            return Redirect::route('/error', ['error_messages' => (array)$e->getMessage()]);
        }
    }

    /**
     */
    public function delete($id): Redirect|array
    {
        try {
            $appendDates = [
                'updated_at' => Carbon::now()->toDateTimeString(),
                'deleted_at' => Carbon::now()->toDateTimeString(),
            ];
            $this->db->beginTransaction();
            $list = $this->db->update($this->table, $appendDates, ['id' => $id]);
            $this->db->commit();

            return [
                'data' => [
                    'code' => $list ? 204 : 400,
                    'message' => $list ? "$this->table deleted successfully" : "Error deleting $this->table"
                ]
            ];
        } catch (\Exception $e) {
            return Redirect::route('/error', ['error_messages' => (array)$e->getMessage()]);
        }
    }

    /**
     */
    public function destroy($id): Redirect|array
    {
        try {
            $destroyed = $this->db->delete($this->table, ['id' => $id]);

            return [
                'data' => [
                    'code' => $destroyed ? 200 : 400,
                    'message' => $destroyed ? "$this->table destroyed permanently" : "Error destroying $this->table"
                ]];
        } catch (\Exception $e) {
            return Redirect::route('/error', ['error_messages' => (array)$e->getMessage()]);
        }
    }


    public function where(string $column, string $operator, mixed $value, $selectColumns = '*'): Redirect|array|false
    {
        try {
            $data = $this->db->createQueryBuilder()->select($selectColumns)
                ->from($this->table)
                ->where("$column $operator ?")
                ->setParameter(0, $value)
                ->fetchAllAssociative();

            return $this->filterOutSoftDeletes($data) ?? [];

        } catch (\Exception $e) {
            return Redirect::route('/error', ['error_messages' => (array)$e->getMessage()]);
        }
    }

    public function whereLogin(string $column, string $operator, string|int $value, $selectColumns = '*'): array|Redirect|false
    {
        try {
            $data = $this->db->createQueryBuilder()->select($selectColumns)
                ->from($this->table)
                ->where("$column $operator ?")
                ->setParameter(0, $value)
                ->fetchAssociative();

            return $data ?? [];

        } catch (\Exception $e) {
            return Redirect::route('/error', ['error_messages' => (array)$e->getMessage()]);
        }
    }

    /**
     * @throws Exception
     */
    public function findLastInserted(): false|array
    {
        return $this->db->createQueryBuilder()
            ->select('*')
            ->from($this->table)
            ->orderBy('id', 'DESC')
            ->fetchAssociative();

    }

    private function filterOutSoftDeletes(array $data): array
    {
        return array_filter($data, function ($query) {
            if (array_key_exists('deleted_at', $query)) {
                return $query['deleted_at'] === null;
            }
            return $query;
        });
    }

}
