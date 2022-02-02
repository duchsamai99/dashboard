<?php
/*
*   08.11.2019
*   RenderFromDatabaseData
*/

Namespace App\MenuBuilder;
use App\MenuBuilder\MenuBuilder;

class RenderFromDatabaseDataSiteMenu{

    private $mb; // MenuBuilder
    private $data;

    public function __construct(){
        $this->mb = new MenuBuilder();
    }

    private function addTitle($data){
        $this->mb->addTitle($data['smeAutoID'], $data['smeName'], false, 'coreui', $data['sequence']);
    }

    private function addLink($data){
        //if($data['smeParent_id'] !== NULL){
            $this->mb->addLink($data['smeAutoID'], $data['smeName'], $data['smeHref'], $data['smeIcon'], 'coreui', $data['sequence']);
        //}
    }

    private function dropdownLoop($id){
        for($i = 0; $i<count($this->data); $i++){
            if($this->data[$i]['parent_id'] == $id){
                if($this->data[$i]['slug'] === 'dropdown'){
                    $this->addDropdown($this->data[$i]);
                }elseif($this->data[$i]['slug'] === 'link'){
                    $this->mb->addLink($this->data[$i]['smeAutoID'], $this->data[$i]['smeName'], $this->data[$i]['smeHref'], $this->data[$i]['smeIcon'], 'coreui', $this->data[$i]['sequence']);
                }else{
                    $this->addTitle($this->data[$i]);
                }
            }
        }
    }
    private function addDropdown($data){
        $this->mb->beginDropdown($data['smeAutoID'], $data['smeName'], $data['smeIcon'], 'coreui', $data['sequence']);
        $this->dropdownLoop($data['smeAutoID']);
        $this->mb->endDropdown();
    }

    private function mainLoop(){
        for($i = 0; $i<count($this->data); $i++){
            switch($this->data[$i]['smeSlug']){
                case 'title':
                    $this->addTitle($this->data[$i]);
                break;
                case 'link':
                    $this->addLink($this->data[$i]);
                break;
                case 'dropdown':
                    //if($this->data[$i]['smeParent_id'] == null){
                        $this->addDropdown($this->data[$i]);
                    //}
                break;
            }
        }
    }

    /***
     * $data - array
     * return - array
     */
    public function render($data){
        if(!empty($data)){
            $this->data = $data;
            $this->mainLoop();
        }
        return $this->mb->getResult();
    }

}