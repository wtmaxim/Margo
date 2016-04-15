<?php

namespace Margo\Repository;

use Doctrine\DBAL\Connection;
use Margo\Entity\Formation;

class FormationRepository implements RepositoryInterface
{

    protected $db;

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    /**
     * Saves the category to the database.
     *
     * @param \Margo\Entity\Formation $formation
     */
    public function save($formation)
    {
        $formationData = array(
            'name' => $formation->getNameFormation(),
        );

        if ($formation->getIdFormation()) {

            $this->db->update('formation', $formationData, array('id' => $formation->getIdFormation()));
        }
        else {
            $this->db->insert('formation', $formationData);
            $id = $this->db->lastInsertId();
            $formation->setIdFormation($id);
        }
    }

    /**
     * Deletes formation.
     *
     * @param \Margo\Entity\Formation $formation
     */
    public function delete($formation)
    {
        return $this->db->delete('formation', array('id' => $formation->getIdFormation()));
    }

    /**
     * Returns the total number of category.
     *
     * @return integer The total number of category.
     */
    public function getCount() {
        return $this->db->fetchColumn('SELECT COUNT(id) FROM formation');
    }

    /**
     * Returns an category matching the supplied id.
     *
     * @param integer $id
     *
     * @return \Margo\Entity\Category|false An entity object if found, false otherwise.
     */
    public function find($name)
    {
        $formationData = $this->db->fetchAssoc('SELECT * FROM formation WHERE name = ?', array($name));
        return $formationData ? $this->buildFormation($formationData) : FALSE;
    }

    /**
     * Returns a collection of category, sorted by name.
     *
     * @param integer $limit
     *   The number of $category to return.
     * @param integer $offset
     *   The number of $category to skip.
     * @param array $orderBy
     *   Optionally, the order by info, in the $column => $direction format.
     *
     * @return array A collection of $category, keyed by $category id.
     */
    public function findAll($limit, $offset = 0, $orderBy = array())
    {
        // Provide a default orderBy.
        if (!$orderBy) {
            $orderBy = array('name' => 'ASC');
        }

        $queryBuilder = $this->db->createQueryBuilder();
        $queryBuilder
            ->select('f.*')
            ->from('formation', 'f')
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->orderBy(key($orderBy), current($orderBy));
        $statement = $queryBuilder->execute();
        $formationsData = $statement->fetchAll();
        $formations = array();
        foreach ($formationsData as $formationData) {
            $formationId = $formationData['id'];
            $formations[$formationId] = $this->buildFormation($formationData);
        }
        return $formations;
    }

    /**
     * Instantiates an $formation entity and sets its properties using db data.
     *
     * @param array $formationData
     *   The array of db data.
     *
     * @return \Margo\Entity\Formation
     */
    protected function buildFormation($formationData)
    {
        $formation= new Formation();
        $formation->setIdFormation($formationData['id']);
        $formation->setNameFormation($formationData['name']);
        return $formation;
    }

}