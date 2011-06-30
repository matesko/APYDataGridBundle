<?php

/*
 * This file is part of the DataGridBundle.
 *
 * (c) Stanislav Turza <sorien@mail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sorien\DataGridBundle\DataGrid;

use Sorien\DataGridBundle\Column\Column;
use Sorien\DataGridBundle\DataGrid\ColumnsIterator;

class Columns implements \IteratorAggregate, \Countable {

    /**
     * @var Column[]
     */
    private $columns;
    private $primary;

    public function __construct()
    {
        $this->columns = array();
    }

    public function getIterator($showOnlySourceColumns = false)
    {
        return new ColumnsIterator(new \ArrayIterator($this->columns), $showOnlySourceColumns);
    }

    /**
     * Add column, column object have to extend Column
     * @param $column Column
     * @return Grid
     *
     */
    public function addColumn($column)
    {
        if (!$column instanceof Column)
        {
            throw new \InvalidArgumentException('Your column needs to extend class Column.');
        }

        $this->columns[] = $column;
        return $this;
    }

    public final function insertColumn($position, $column)
    {
        $head = array_slice($this->columns, 0, $position);
        $tail = array_slice($this->columns, $position);
        $this->columns = array_merge($head, array($column), $tail);

        return $this;
    }

    public function getColumnById($columnId)
    {
        foreach ($this->columns as $column)
        {
            if ($column->getId() == $columnId)
            {
                return $column;
            }
        }

        throw new \InvalidArgumentException(sprintf('Column with id "%s" doesn\'t exists', $columnId));
    }

    public function setPrimaryColumn($columnId)
    {
        $this->primary = $columnId;
    }

    public function getPrimaryColumn()
    {
        return $this->getColumnById($this->primary);
    }


    /**
     * @todo
     * @return bool
     */
    function showFilters()
    {
        return true;
    }

    /**
     * @todo
     * @return bool
     */
    function showTitles()
    {
        return true;
    }

    public function count()
    {
       return count($this->columns);
    }
}
