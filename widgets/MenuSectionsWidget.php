<?php
namespace app\modules\specialsection\widgets;

use yii\base\Widget;

use app\modules\specialsection\classes\Section;
class MenuSectionsWidget extends Widget
{

    const TYPE_LIST = 'htmlUl';
    const TYPE_SELECT = 'htmlSelect';

    public $userRoles = [];

    public $items = [];


    public $type = '';

    // constr

    public function run()
    {
        $baseSectionUrl = '/specialsection/section/';
        // $menuItems = [];
        // $sections = Section::getSections();

        // foreach ($sections as $section) {
        //     $url = $baseSectionUrl . $section;
        //     $menuItems[$section] = $url;
        // }
        
        // $filteredMenuItems = [];
        // foreach ($menuItems as $key => $url) {
        //     if (in_array($key, $this->userRoles)) {
        //         $filteredMenuItems[$key] = $url;
        //     }
        // }

        if ($this->type == self::TYPE_LIST){
            return $this->render('list', [
                'menuItems' => $this->items
            ]); 
        } else if($this->type == self::TYPE_SELECT) {
            return $this->render('select', [
                'menuItems' => $this->items
            ]);
        } 

        return $this->render('not type widget');
    }
    //public function run()
    //{
    //    return $this->render("menu_sections");
    //}
}