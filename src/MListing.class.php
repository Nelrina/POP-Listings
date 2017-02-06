<?php
/*
 *
 * Make the CRUD operations for Listings
 *
 */
require 'listing.class.php';

// Listing Manager
class MListing
{
    private $_db; // Instance of PDO

    public function __construct($db)
    {
        $this->_db = $db;
    }

    // Add a Listing to the database
    public function add(Listing $fl)
    {
        $q = $this->_db->prepare('INSERT INTO listings SET id = :id, name = :name, url = :url, img = :img, cat = :cid');
        $q->bindValue(':id',   $fl->getId(), PDO::PARAM_INT);
        $q->bindValue(':name', $fl->getName(), PDO::PARAM_STR);
        $q->bindValue(':url',  $fl->getUrl(), PDO::PARAM_STR);
        $q->bindValue(':img',  $fl->getImg(), PDO::PARAM_STR);
        $q->bindValue(':cid',  $fl->getCat(), PDO::PARAM_INT);
        $q->execute();
    }

    // Delete a Listing from the database
    public function delete(Listing $fl)
    {
        $q = $this->_db->prepare('DELETE FROM listings WHERE id = :id') ;
        $q->bindValue(':id', $fl->getId(), PDO::PARAM_INT);
        $q->execute();
    }

    // Returns an array with the category of the Listing with the id $id
    // Maybe modify the method to return a Category object instead of an array
    public function getCategory($id)
    {
        $q = $this->_db->prepare('SELECT cname, cid FROM categories WHERE cid = :id') ;
        $q->bindValue(':id', $id, PDO::PARAM_INT);
        $q->execute();
        return $q->fetch(PDO::FETCH_ASSOC);
    }

    // Return an array of all the Listings of the database
    public function getAll()
    {
        $stmt = $this->_db->prepare('SELECT l.id, l.name, l.url, l.img, c.cid AS cat FROM listings AS l, categories AS c WHERE l.cat = c.cid ORDER BY l.id') ;
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Listing', array("id", "name", "url", "img", "cat")) ;
        $stmt->execute() ;
        return $stmt->fetchAll();
    }

    // Return an array of all the Listings from one category with the id $id
    public function getAllFromOneCategory($id)
    {
        $stmt = $this->_db->prepare('SELECT l.id, l.name, l.url, l.img, c.cid AS cat FROM listings AS l, categories AS c WHERE l.cat = c.cid ORDER BY l.id') ;
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Listing', array("id", "name", "url", "img", "cat")) ;
        $stmt->execute() ;
        return $stmt->fetchAll();
    }

    // Return the Listing with the id $id
    public function getOne($id)
    {
        $q = $this->_db->prepare('SELECT id, name, url, img, cat FROM listings WHERE id = :id') ;
        $q->bindValue(':id', $id, PDO::PARAM_INT);
        $q->setFetchMode(PDO::FETCH_CLASS, 'Listing', array("id", "name", "url", "img", "cat")) ;
        $q->execute();
        return $q->fetch();
    }

    // Update a listing in the database
    public function update(Listing $fl)
    {
        $q = $this->_db->prepare('UPDATE listings SET url = :url, cat = :cat, name = :name, img = :img WHERE id = :id');
        $q->bindValue(':cat', $fl->getCat(), PDO::PARAM_INT);
        $q->bindValue(':url', $fl->getUrl(), PDO::PARAM_STR);
        $q->bindValue(':name', $fl->getName(), PDO::PARAM_STR);
        $q->bindValue(':img', $fl->getImg(), PDO::PARAM_STR);
        $q->bindValue(':id',   $fl->getId(), PDO::PARAM_INT);
        $q->execute();
    }

    // Delete image from Listing
    public function deleteImg(Listing $fl)
    {
        $q = $this->_db->prepare('UPDATE listings SET img = :img WHERE id = :id');
        $q->bindValue(':img', "", PDO::PARAM_STR);
        $q->bindValue(':id',   $fl->getId(), PDO::PARAM_INT);
        $q->execute();
    }

    // Return the number of listings
    public function getListCount()
    {
        $q = $this->_db->prepare('SELECT COUNT(id) FROM listings');
        $q->execute();
        return $q->fetch()['COUNT(id)'];
    }

    // Return the last joined listing
    public function getLast()
    {
        $q = $this->_db->prepare('SELECT * FROM listings ORDER BY id DESC LIMIT 1') ;
        $q->setFetchMode(PDO::FETCH_CLASS, 'Listing', array("id", "name", "url", "img", "cat")) ;
        $q->execute();
        return $q->fetch();
    }

    // Return a random joined listing
    public function getRandom()
    {
        $rd = rand(0, $this->getListCount()-1);
        $q = $this->_db->prepare('SELECT * FROM listings') ;
        $q->setFetchMode(PDO::FETCH_CLASS, 'Listing', array("id", "name", "url", "img", "cat")) ;
        $q->execute();
        $tabList = $q->fetchAll();
        return $tabList[$rd];
    }

    // Attaches an instance of PDO to the manager
    public function setDb(PDO $db)
    {
        $this->_db = $db;
    }
}
?>
