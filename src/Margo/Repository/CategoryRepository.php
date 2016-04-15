<?php

namespace Margo\Repository;

use Doctrine\DBAL\Connection;
use Margo\Entity\Category;

class CategoryRepository implements RepositoryInterface
{

    protected $db;

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    /**
     * Saves the category to the database.
     *
     * @param \Margo\Entity\Category $category
     */
    public function save($category)
    {
        $categoryData = array(
            'name' => $category->getCategName(),
            'formation' => $category->getFormation(),
        );

        if ($category->getCategId()) {

            $this->db->update('category', $categoryData, array('id' => $category->getCategId()));
        }
        else {
            $this->db->insert('category', $categoryData);
            $id = $this->db->lastInsertId();
            $category->setCategId($id);
        }
    }

    /**
     * Deletes category.
     *
     * @param \Margo\Entity\Category $category
     */
    public function delete($classe)
    {
        return $this->db->delete('category', array('id' => $classe->getCategId()));
    }

    /**
     * Returns the total number of category.
     *
     * @return integer The total number of category.
     */
    public function getCount() {
        return $this->db->fetchColumn('SELECT COUNT(id) FROM category');
    }

    /**
     * Returns an category matching the supplied id.
     *
     * @param integer $id
     *
     * @return \Margo\Entity\Category|false An entity object if found, false otherwise.
     */
    public function find($id)
    {
        $categoryData = $this->db->fetchAssoc('SELECT * FROM category WHERE id = ?', array($id));
        return $categoryData ? $this->buildCategory($categoryData) : FALSE;
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
            ->select('c.*')
            ->from('category', 'c')
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->orderBy(key($orderBy), current($orderBy));
        $statement = $queryBuilder->execute();
        $categorysData = $statement->fetchAll();
        $categorys = array();
        foreach ($categorysData as $categoryData) {
            $categoryId = $categoryData['id'];
            $categorys[$categoryId] = $this->buildCategory($categoryData);
        }
        return $categorys;
    }

    /**
     * Instantiates an $category entity and sets its properties using db data.
     *
     * @param array $categoryData
     *   The array of db data.
     *
     * @return \Margo\Entity\Category
     */
    protected function buildCategory($categoryData)
    {
        $category = new Category();
        $category->setCategId($categoryData['id']);
        $category->setCategName($categoryData['name']);
        $category->setFormation($categoryData['formation']);
        return $category;
    }

}