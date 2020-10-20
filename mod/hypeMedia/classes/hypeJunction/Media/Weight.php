<?php

namespace hypeJunction\Media;

use Elgg\Database\Clauses\WhereClause;
use Elgg\Database\QueryBuilder;
use hypeJunction\Lists\SorterInterface;

class Weight implements SorterInterface {

	/**
	 * {@inheritdoc}
	 */
	public static function id() {
		return 'weight';
	}

	/**
	 * {@inheritdoc}
	 */
	public static function build($direction = null) {

		$sorter = function (QueryBuilder $qb) use ($direction) {
			$qb->orderBy('frs.weight', $direction);
		};

		return new WhereClause($sorter);
	}
}