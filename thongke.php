<?php
include('includes/header.php'); 
include('includes/navbar.php'); 
include('includes/db.php');


class IVisualLoadConfiguration {
    public $accessToken;
    public $embedUrl;
    public $id;
    public $pageName;
    public $tokenType;
    public $type;
    public $visualName;

    public function __construct(
        $pageName,
        $type,
        $visualName,
        $accessToken = null,
        $embedUrl = null,
        $id = null,
        $tokenType = null
    ) {
        $this->accessToken = $accessToken;
        $this->embedUrl = $embedUrl;
        $this->id = $id;
        $this->pageName = $pageName;
        $this->tokenType = $tokenType;
        $this->type = $type;
        $this->visualName = $visualName;
    }
}

include('includes/scripts.php');
include('includes/footer.php');
?>