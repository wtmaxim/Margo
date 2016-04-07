<?php

namespace Margo\Repository;

use Doctrine\DBAL\Connection;
use Margo\Entity\Teacher;

/**
 * teacher repository
 */
class TeacherRepository implements RepositoryInterface
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
     * Saves the teacher to the database.
     *
     * @param \Margo\Entity\Teacher $teacher
     */
    public function save($teacher)
    {
        $teachersData = array(
            'name' => $teacher->getNom(),
            'firstname' => $teacher->getPrenom(),
            'idSubject' => $teacher->getIdSubject(),
        );

        if ($teacher->getId()) {

            $this->db->update('etudiants', $teachersData, array('teacher' => $teacher->getId()));
        }
        else {
            $this->db->insert('teacher', $teachersData);
            $id = $this->db->lastInsertId();
            $teacher->setId($id);
        }
    }

    /**
     * Deletes teacher.
     *
     * @param \Margo\Entity\Teacher $teacher
     */
    public function delete($teacher)
    {
        return $this->db->delete('teacher', array('id' => $teacher->getTeacherId()));
    }

    /**
     * Returns the total number of Teachers.
     *
     * @return integer The total number of teachers.
     */
    public function getCount() {
        return $this->db->fetchColumn('SELECT COUNT(id) FROM teacher');
    }

    /**
     * Returns a teacher matching the supplied id.
     *
     * @param integer $id
     *
     * @return \Margo\Entity\Teacher|false An entity object if found, false otherwise.
     */
    public function find($id)
    {
        $teachersData = $this->db->fetchAssoc('SELECT * FROM teacher WHERE id = ?', array($id));
        return $teachersData ? $this->buildTeacher($teachersData) : FALSE;
    }

    /**
     * Returns a collection of teacher, sorted by name.
     *
     * @param integer $limit
     *   The number of $teacher to return.
     * @param integer $offset
     *   The number of $teacher to skip.
     * @param array $orderBy
     *   Optionally, the order by info, in the $column => $direction format.
     *
     * @return array A collection of $teacher, keyed by $teacher id.
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
     * Instantiates an $teacger entity and sets its properties using db data.
     *
     * @param array $teacherData
     *   The array of db data.
     *
     * @return \Margo\Entity\Teacher
     */
    protected function buildTeacher($teacherData)
    {
        $teacher = new Teacher();
        $teacher->setTeacherId($teacherData['id']);
        $teacher->setTeacherFirstName($teacherData['firstName']);
        $teacher->setTeacherName($teacherData['name']);
        $teacher->setIdSubject($teacherData['idSubject']);
        return $teacher;
    }
}
