<?php

namespace App\Helper\CustomSoftDeletes;

use Closure;

class Builder extends \Illuminate\Database\Eloquent\Builder
{
    /**
     * Add a join clause to the query.
     *
     * @param  string  $table
     * @param  Closure|string  $first
     * @param  string|null  $operator
     * @param  string|null  $second
     * @param  bool  $withTrashed
     * @param  string  $type
     * @param  bool  $where
     * @return \Illuminate\Database\Eloquent\Builder|$this
     */
    public function join(
        $table,
        $first,
        $operator = null,
        $second = null,
        $type = 'inner',
        $where = false,
        $withTrashed = false
    ) {
        if (!$withTrashed) {
            return parent::join($table, $first, $operator, $second, $type, $where)
                ->where("$table.deleted_at", "=", null);
        }

        return parent::join($table, $first, $operator, $second, $type, $where);
    }
}
