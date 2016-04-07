<?php

namespace Margo\Repository;

use Doctrine\DBAL\Connection;

use Margo\Entity\Teacher;

/**
 * Artist repository
 */
class TeacherRepository implements RepositoryInterface
{
    /**
     * @var \Doctrine\DBAL\Connection
     */
    protected $db;

    protected $subjectRepository;

    public function __construct(Connection $db, $subjectRepository)
    {
        $this->db = $db;
        $this->subjectRepository = $subjectRepository;
    }

    /**
     * Saves the etudiant to the database.
     *
     * @param \Margo\Entity\Etudiant $etudiant
     */
    public function save($etudiant)
    {
        $etudiantData = array(
            'name' => $etudiant->getName(),
            'firstname' => $etudiant->getFirstName(),
            'idCategory' => $etudiant->getIdCategory(),
        );

        if ($etudiant->getStudentId()) {

            $this->db->update('student', $etudiantData, array('id' => $etudiant->getStudentId()));
        }
        else {
            $this->db->insert('student', $etudiantData);
            $id = $this->db->lastInsertId();
            $etudiant->setStudentId($id);
        }
    }

    /**
     * Deletes etudiant.
     *
     * @param \Margo\Entity\Teacher $teacher
     */
    public function delete($teacher)
    {
        return $this->db->delete('teacher', array('id' => $teacher->getId()));
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
        $teacherData = $this->db->fetchAssoc('SELECT * FROM teacher WHERE id = ?', array($id));
        return $teacherData ? $this->buildTeacher($teacherData) : FALSE;
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
        $teachersData = $statement->fetchAll();
        $teachers = array();
        foreach ($teachersData as $teacherData) {
            $teacherId = $teacherData['id'];
            $teachers[$teacherId] = $this->buildTeacher($teacherData);
        }
        return $teachers;
    }

    /**
     * Instantiates an $etudiant entity and sets its properties using db data.
     *
     * @param array $etudiantData
     *   The array of db data.
     *
     * @return \Margo\Entity\Etudiant
     */
    protected function buildTeacher($teacherData)
    {



        $teacher = new Teacher();
        $teacher->setId($teacherData['id']);
        $teacher->setName($teacherData['name']);
        $teacher->setFirstName($teacherData['firstName']);
        return $teacher;
    }
}
