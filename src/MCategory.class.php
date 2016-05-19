<?php
/*
 *
 * Make the CRUD operations for Categories
 * 
 */

require 'category.class.php';

// Category Manager
class MCategory
{
    private $_db; // Instance of PDO

    public function __construct($db)
    {
        $this->_db = $db;
    }

    // Add a Category to the database
    public function add(Category $cat)
    {
        $q = $this->_db->prepare('INSERT INTO categories SET cid = :cid, cname = :cname');
        $q->bindValue(':cid', $cat->getCid(), PDO::PARAM_INT);
        $q->bindValue(':cname', $cat->getCname(), PDO::PARAM_STR);
        return $q->execute();
    }

    // Delete a Category from the database
    public function delete(Category $cat)
    {
        $this->_db->exec('DELETE FROM categories WHERE cid = '.$cat->getCid());
    }

    // Return the Category with the id $id
    public function getOne($id)
    {
        $q = $this->_db->prepare('SELECT cid, cname FROM categories WHERE cid = :cid');
        $q->bindValue(':cid', $id, PDO::PARAM_INT);
        $q->setFetchMode(PDO::FETCH_CLASS, 'Category', array("cid", "cname"));
        $q->execute();
        return $q->fetch();
    }

    // Return an array of all the categories
    public function getAll()
    {
        $stmt = $this->_db->prepare('SELECT cid, cname FROM categories ORDER BY cname');
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Category', array("cid", "cname"));
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Update a Category in the database
    public function update(Category $cat)
    {
        $q = $this->_db->prepare('UPDATE categories SET cname = :cname WHERE cid = :cid');
        $q->bindValue(':cid', $cat->getCid(), PDO::PARAM_INT);
        $q->bindValue(':cname', $cat->getCname(), PDO::PARAM_STR);
        $q->execute();
    }

    // Return the number of listings attached to this Category
    public function getListCountFromCat($id)
    {
        $q = $this->_db->prepare('SELECT id FROM listings WHERE cat = :cid');
        $q->bindValue(':cid', $id, PDO::PARAM_INT);
        $q->execute();
        return $q->rowCount();
    }
    
    // Return the number of categories
    public function getCatCount()
    {
        $q = $this->_db->prepare('SELECT COUNT(cid) FROM categories');
        $q->execute();
        return $q->fetch()['COUNT(cid)'];
    }
    
    // Attaches an instance of PDO to the manager
    public function setDb(PDO $db)
    {
        $this->_db = $db;
    }
}
?>
