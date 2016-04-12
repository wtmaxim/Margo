<?php

namespace Margo\Repository;

use Doctrine\DBAL\Connection;
use Margo\Entity\Teacher;

/**
 * Artist repository
 */
class ProfRepository implements RepositoryInterface
{
    /**
     * @var \Doctrine\DBAL\Connection
     */
    protected $db;

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    /**
     * Saves the etudiant to the database.
     *
     * @param \Margo\Entity\Prof $prof
     */
    public function save($prof)
    {
        $profData = array(
            'name' => $prof->getName(),
            'firstname' => $prof->getFirstName(),
            'idSubject' => $prof->getIdSubject(),
        );

        if ($prof->getTeacherId()) {

            $this->db->update('teacher', $profData, array('id' => $prof->getTeacherId()));
        }
        else {
            $this->db->insert('teacher', $profData);
            $id = $this->db->lastInsertId();
            $prof->setTeacherId($id);
        }
    }

    /**
     * Deletes etudiant.
     *
     * @param \Margo\Entity\Student $etudiant
     */
    public function delete($prof)
    {
        return $this->db->delete('teacher', array('id' => $prof->getTeacherId()));
    }

    /**
     * Returns the total number of etudiant.
     *
     * @return integer The total number of etudiant.
     */
    public function getCount() {
        return $this->db->fetchColumn('SELECT COUNT(id) FROM teacher');
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
        $profData = $this->db->fetchAssoc('SELECT * FROM teacher WHERE id = ?', array($id));
        return $profData ? $this->buildTeacher($profData) : FALSE;
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
            ->select('t.*')
            ->from('teacher', 't')
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->orderBy(key($orderBy), current($orderBy));
        $statement = $queryBuilder->execute();
        $profsData = $statement->fetchAll();
        $profs = array();
        foreach ($profsData as $profData) {
            $profId = $profData['id'];
            $profs[$profId] = $this->buildTeacher($profData);
        }
        return $profs;
    }

    /**
     Recuperer eventuel prof dans une matiere
     *
     */

    public function selectOneByIdSubject($idSubject)
    {
        $profs = $this->db->fetchAssoc('SELECT * FROM teacher WHERE idSubject = ?', array($idSubject));
        return $profs;
    }

    /**
     * Instantiates an $etudiant entity and sets its properties using db data.
     *
     * @param array $etudiantData
     *   The array of db data.
     *
     * @return \Margo\Entity\Etudiant
     */
    protected function buildTeacher($profData)
    {

        $prof = new Teacher();
        $prof->setTeacherId($profData['id']);
        $prof->setName($profData['name']);
        $prof->setFirstName($profData['firstName']);
        $prof->setIdSubject($profData['idSubject']);
        return $prof;
    }
}
