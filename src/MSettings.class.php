<?php
/*
 *
 * Make the CRUD operations for Settings
 *
 */

// Settings Manager
class MSettings
{
    private $_db; // Instance of PDO

    public function __construct($db)
    {
        $this->_db = $db;
    }

    // Returns an array with the category of the Listing with the id $id
    // Maybe modify the method to return a Category object instead of an array
    public function select()
    {
        $q = $this->_db->prepare('SELECT email, imgdir, imgurl, imgtype, linktarget FROM settings WHERE loggin = :login') ;
        $q->bindValue(':login', $_SESSION['myLogin'], PDO::PARAM_INT);
        $q->execute();
        return $q->fetch(PDO::FETCH_ASSOC);
    }
    
    
    // Update a listing in the database
    public function update(array $newSet)
    {
        $q = $this->_db->prepare('UPDATE settings SET email = :email, imgdir = :imgdir, imgurl = :imgurl, imgtype = :imgtype, linktarget = :linktarget WHERE loggin = :loggin');
        $q->bindValue(':email', $newSet['email'], PDO::PARAM_STR);
        $q->bindValue(':imgdir', $newSet['imgDir'], PDO::PARAM_STR);
        $q->bindValue(':imgurl', $newSet['imgurl'], PDO::PARAM_STR);
        $q->bindValue(':imgtype', $newSet['imgType'], PDO::PARAM_STR);
        $q->bindValue(':linktarget', $newSet['linkTarget'], PDO::PARAM_BOOL);
        $q->bindValue(':loggin', $_SESSION['myLogin'], PDO::PARAM_STR);
        $q->execute();
    }

    // Update the password
    public function changePassword($newHash)
    {
        $q = $this->_db->prepare('UPDATE settings SET loggin = :url, cat = :cat, name = :name, img = :img WHERE id = :id');
        $q->bindValue(':cat', $fl->setCat(), PDO::PARAM_INT);
        $q->bindValue(':url', $fl->setUrl(), PDO::PARAM_STR);
        $q->bindValue(':name', $fl->setName(), PDO::PARAM_STR);
        $q->bindValue(':img', $fl->setImg(), PDO::PARAM_STR);
        $q->execute();
    }
    
    // Get the email address
    public function getEmail($login)
    {
        $q = $this->_db->prepare('SELECT email FROM settings WHERE loggin = :login') ;
        $q->bindValue(':login', $login, PDO::PARAM_INT);
        $q->execute();
        return $q->fetch(PDO::FETCH_ASSOC);
    }
    
    // Attaches an instance of PDO to the manager
    public function setDb(PDO $db)
    {
        $this->_db = $db;
    }
}
?>
