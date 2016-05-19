<?php
// List
class Listing
{
    private $id;
    private $name;
    private $url;
    private $img;
    private $cat;

    public function __construct() {}

    //!\\ Must remake this method with an array in parameters
    public function hydrate($n, $u, $im, $ci, $i=0)
    {
        $this->name = $n;
        $this->url = $u;
        $this->img = $im;
        $this->cat = $ci;
        $this->id = $i;
    }

    public function getId()
    {
        return $this->id;
    }
    
    public function setId($newid)
    {
        $newid = (int) $newid;
        
        // Verifying that the new id isn't negative
        if ($newid >= 0)
        {
            $this->id = $newid;
        }
    }

    public function getCat()
    {
        return $this->cat;
    }

    public function setCat($newCat)
    {
        $this->cat = $newCat;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl(string $newUrl)
    {
        $this->url = $newUrl;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName(string $newName)
    {
        $this->name = $newName;
    }

    public function getImg()
    {
        return $this->img;
    }

    public function setImg(string $newImg)
    {
        $this->img = $newImg;
    }
}
?>
