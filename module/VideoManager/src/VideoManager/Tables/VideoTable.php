<?php

namespace VideoManager\Tables;

use VideoManager\Models\Video;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Where as WherePredicate;

class VideoTable
{
    const DATETIME_FORMAT = 'Y-m-d';

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function save(Video $video)
    {
        if (!$video->videoId) {
            $data = $video->getArrayCopy();
            unset($data['videoId']);
            if ($this->tableGateway->insert($data)) {
                return $this->tableGateway->getLastInsertValue();
            }
        } else {
            $retstat = $this->tableGateway->update(
                $video->getArrayCopy(),
                array('videoId' => (int)$video->videoId)
            );
            if ($retstat) {
                return $retstat;
            }
        }

        return false;
    }

    public function delete($videoId)
    {
        if (!empty($videoId)) {
            return $this->tableGateway->delete(array(
                'videoId' => (int)$videoId
            ));
        }
    }

    public function fetchById($videoId)
    {
        if (!empty($videoId)) {
            $select = $this->tableGateway->getSql()->select();
            $select->where(array(
                'videoId' => (int)$videoId
            ));
            $results = $this->tableGateway->selectWith($select);
            if ($results->count() == 1) {
                return $results->current();
            }
        }

        return false;
    }

    public function fetchMostRecent($limit = 5)
    {
        $select = $this->tableGateway->getSql()->select();
        $select->limit((int)$limit)
               ->order('releaseDate DESC');
        $results = $this->tableGateway->selectWith($select);

        return $results->buffer();
    }

    public function fetchByDateRange(
        \DateTime $startDate = null, \DateTime $endDate = null
    ){
        $select = $this->tableGateway->getSql()->select();
        $where = new WherePredicate;

        if (!is_null($startDate)) {
            $where->greaterThanOrEqualTo(
                'releaseDate', $startDate->format(self::DATETIME_FORMAT)
            );
        }

        if (!is_null($endDate)) {
            $where->lessThanOrEqualTo(
                'releaseDate', $endDate->format(self::DATETIME_FORMAT)
            );
        }

        $select->where($where)->order('releaseDate DESC');

        $results = $this->tableGateway->selectWith($select);

        return $results->buffer();
    }

    public function fetchByDirector($director)
    {
        $select = $this->tableGateway->getSql()->select();
        $where = new WherePredicate();

        $select->join(
            'tbldirectors',
            $this->tableGateway->getTable() . '.directorId',
            array(
                'firstName', 'lastName', 'dateOfBirth', 'nationality'
            ),
            \Zend\Db\Sql\Select::JOIN_LEFT
        );

        if (is_int($director)) {
            $where->equalTo(
                $this->tableGateway->getTable() . '.directorId',
                $director
            );
        }

        if (is_string($director)) {
            $where->like('firstName', $director . '%')
                  ->or
                  ->like('lastName', $director . '%');
        }

        $select->where($where)->order('releaseDate DESC');
        $results = $this->tableGateway->selectWith($select);

        return $results->buffer();
    }
}

