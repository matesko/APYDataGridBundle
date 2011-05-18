<?php

namespace Sorien\DataGridBundle\Tests;

use Sorien\DataGridBundle\Source;
use Sorien\DataGridBundle\Column\Text;
use Sorien\DataGridBundle\Column\Select;
use Sorien\DataGridBundle\Column\Range;

class Users extends Source
{
	function prepare()
	{
		$this->addColumn(new Range('v.id', 'Id', 120));
		$this->addColumn(new Text('v.authors', 'Authors', 200, true, true));
		$this->addColumn(new Select('v.mode', 'a', array('admin' => 'Admin', 'user' => 'User')));
		$this->addColumn(new Text('v.admins', 'Admin', 200, true, true));
	}

	function execute()
	{
		//http://www.doctrine-project.org/docs/orm/2.0/en/reference/query-builder.html
/*		$query = $this->get('doctrine')->getEntityManager();
		$query->select('a');

		foreach ($this->getColumns() as $column)
		{
			if ($column->isSorted())
			{
				$query->orderBy($column->getId(), $column->getOrder());
			}

			if ($column->isFiltred())
			{
				$where = $column->filtersConnected() ? $query->expr()->xand() : $query->expr()->xor();
				foreach ($column->getFilters() as $filter)
				{
					$where->add($column->getId().' '.$filter->getFilterOperator().''.$filter->getFilterValue());
				}

				$query->addWhere($where);
			}
		}

		$query->from('Article', 'a');*/
		//$query->setMaxResults(20);

		$data = array();
		for ($i = 0;$i < 20; $i++)
		{
			$array = array();
			foreach ($this->getColumns() as $column)
			{
				$array[$column->getId()] = $column->getTitle().'-'.$i;
			}
			$data[] = $array;
		}

		$this->setCount(20);
		$this->setTotalCount(50);

		return $data;
		//$query->execute();
	}
}