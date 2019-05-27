<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{

    private $cats;
    private $categoryChild;
    private $res = [];
    private $categories = [];
    private $ids = [];

    private function getChildrenIds($id) {
        $result = [];
        foreach ($this->categoryChild as $c) {
            if ($c['id_category'] == $id) {
                $result[] = $c['id_child'];
            }
        }
        return $result;
    }

    private function formNestedNavigation($id, $offset, $path, $depth) {
        foreach ($this->getChildrenIds($id) as $child) {
            $this->res[] = [$offset, $this->categories[$child]['name'], $path.$this->categories[$child]['alias'], $depth + 1];
            $this->formNestedNavigation($child, $offset + 4, $path.$this->categories[$child]['alias'], $depth + 1);
        }
    }

    public function actionIndex()
    {
        $this->cats = (new \yii\db\Query())->select(['*'])->from('categories')->all();
        $this->categoryChild = (new \yii\db\Query())->select(['*'])->from('category_child')->all();

        foreach ($this->cats as $cat) {
            $this->categories[$cat['id']] = $cat;
            $this->ids[] = $cat['id'];
        }

        foreach ($this->categoryChild as $c) {
            if (($key = array_search($c['id_child'], $this->ids)) != NULL) {
                unset($this->ids[$key]);
            }
        }
    
        foreach ($this->ids as $id) {
            $this->res[] = [0, $this->categories[$id]['name'], $this->categories[$id]['alias'], 0];
            $this->formNestedNavigation($id, 4, $this->categories[$id]['alias'], 0);
        }
        
        $oneLevelNested = array_filter($this->res, function($val){ return $val[3] <= 1; });

        return $this->render('index', ['categories' => $this->res, 'oneLevelNestedCategories' => $oneLevelNested]);
    }
}
