<?php

namespace OCA\RestTagApi\Service;

use OCP\DB\QueryBuilder\IQueryBuilder;
use OCP\IDBConnection;

class DBTagService {

	/**
	 * @var IDBConnection
	 */
	private $connection;

	/**
	 * DBTagService constructor.
	 *
	 * @param IDBConnection $connection
	 */
	public function __construct(IDBConnection $connection) {
		$this->connection = $connection;
	}

    public function getTagsStats() {
        // the sql request : 
        //   select t.name, count(t.id) nb 
        //   from oc_systemtag t join oc_systemtag_object_mapping m 
        //     on t.id = m.systemtagid 
        //   group by t.id order by count(t.id) desc

		$builder = $this->connection->getQueryBuilder();
        $query = $builder->selectAlias($builder->createFunction('COUNT(t.id)'), 'nb')
            ->selectAlias('t.name', 'name')
            ->from('systemtag', 't')
            ->innerJoin('t', 'systemtag_object_mapping', 'm', $builder->expr()->eq('t.id', 'm.systemtagid'))
            ->groupBy('t.id')
            ->orderBy('nb', 'desc');
        $result = $query->execute(); 
        return $result->fetchAll();
    }
}
