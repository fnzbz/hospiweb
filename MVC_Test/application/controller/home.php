<?php

/**
 * Class Home
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */
class Home extends Controller
{
    /**
     * PAGE: index
     * This method handles what happens when you move to http://yourproject/home/index (which is the default page btw)
     */
    private function getNameIndex($name, $medic)
    {
    	$returnName = '';
    	switch($medic)
    	{
    		case 0:
    			$returnName = $name;
    			break;
    		default:
    			$returnName = 'Dr. '.$name;
    			break;
    	}
    	return $returnName;
    }

    private function getPhotoIndex($avatar, $sex, $medic)
    {
    	$photo_url = '';
    	if(!is_null($avatar))
    		$photo_url = URL . 'assets/uploads' . $avatar;
    	else
    	{
    		switch($sex)
    		{
    			case 1: $photo_url = $medic ? (URL . 'assets/img/mini-man-doctor.png') : (URL . 'assets/img/mini-man.png');
    				break;
    			case 2: $photo_url = $medic ? (URL . 'assets/img/mini-woman-doctor.png') : (URL . 'assets/img/mini-woman.png');
    				break;
    			default: $photo_url = (URL . 'assets/img/mini-unisex.png');
    				break;
    		}
    	}
    	return $photo_url;
    }

    public function index()
    {
    	$index_model = $this->loadModel('IndexModel');
    	if(isset($_SESSION['id']))
    	{
    		$id = $_SESSION['id'];
    		$fetch_model = $index_model->getUserIndexData($id);
    		foreach($fetch_model as $data)
    		{
    			$name_header = $this->getNameIndex($data->utilizator, $data->isMedic);
    			$photo_header = $this->getPhotoIndex($data->avatarName, $data->sex, $data->isMedic);
    		}
    	}
        require 'application/views/home/index.php';
    }
}
