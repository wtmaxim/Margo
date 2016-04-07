<?php

namespace Margo\Repository;

use Doctrine\DBAL\Connection;
use Margo\Entity\Category;
use Margo\Entity\Student;

/**
 * Artist repository
 */
class EtudiantRepository implements RepositoryInterface
{
    /**
     * @var \Doctrine\DBAL\Connection
     */
    protected $db;
    protected $categoryRepository;

    public function __construct(Connection $db, $categoryRepository)
    {
        $this->db = $db;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Saves the etudiant to the database.
     *
     * @param \Margo\Entity\Etudiant $etudiant
     */
    public function save($etudiant)
    {
        $etudiantData = array(
            'name' => $etudiant->getNom(),
            'firstname' => $etudiant->getPrenom(),
            'idcategory' => $etudiant->getId(),
        );

        if ($etudiant->getId()) {

            $this->db->update('etudiants', $etudiantData, array('etudiant_id' => $etudiant->getId()));
        }
        else {
            $this->db->insert('etudiants', $etudiantData);
            $id = $this->db->lastInsertId();
            $etudiant->setId($id);
        }
    }

    /**
     * Deletes etudiant.
     *
     * @param \Margo\Entity\$etudiant $etudiant
     */
    public function delete($etudiant)
    {
        return $this->db->delete('etudiants', array('etudiant_id' => $etudiant->getId()));
    }

    /**
     * Returns the total number of etudiant.
     *
     * @return integer The total number of etudiant.
     */
    public function getCount() {
        return $this->db->fetchColumn('SELECT COUNT(id) FROM student');
    }

    /**
     * Returns an etudiant matching the supplied id.
     *
     * @param integer $id
     *
     * @return \Margo\Entity\Etudiant|false An entity object if found, false otherwise.
     */
    public function find($id)
    {
        $etudiantData = $this->db->fetchAssoc('SELECT * FROM etudiants WHERE etudiant_id = ?', array($id));
        return $etudiantData ? $this->buildEleve($etudiantData) : FALSE;
    }

    /**
     * Returns a collection of etudiant, sorted by name.
     *
     * @param integer $limit
     *   The number of $etudiant to return.
     * @param integer $offset
     *   The number of $etudiant to skip.
     * @param array $orderBy
     *   Optionally, the order by info, in the $column => $direction format.
     *
     * @return array A collection of $etudiant, keyed by $etudiant id.
     */
    public function findAll($limit, $offset = 0, $orderBy = array())
    {
        // Provide a default orderBy.
        if (!$orderBy) {
            $orderBy = array('name' => 'ASC');
        }

        $queryBuilder = $this->db->createQueryBuilder();
        $queryBuilder
            ->select('e.*')
            ->from('student', 'e')
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->orderBy(key($orderBy), current($orderBy));
        $statement = $queryBuilder->execute();
        $etudiantsData = $statement->fetchAll();
        $etudiants = array();
        foreach ($etudiantsData as $etudiantData) {
            $etudiantId = $etudiantData['id'];
            $etudiants[$etudiantId] = $this->buildEtudiant($etudiantData);
        }
        return $etudiants;
    }

    /**
     * Instantiates an $etudiant entity and sets its properties using db data.
     *
     * @param array $etudiantData
     *   The array of db data.
     *
     * @return \Margo\Entity\Etudiant
     */
    protected function buildEtudiant($etudiantData)
    {

        $category = $this->categoryRepository->find($etudiantData['id']);

        $etudiant = new Student();
        $etudiant->setStudentId($etudiantData['id']);
        $etudiant->setName($etudiantData['name']);
        $etudiant->setFirstName($etudiantData['firstName']);
        $etudiant->setCategory($category);
        return $etudiant;
    }
}
