<?php

namespace application\controllers;

use application\core\Controller;
use application\core\View;
use application\lib\Loader;
use application\models\Account;

class PanelController extends Controller
{
    private $account;
    private $accountData;
    private $panel;
    private $adminPanel;
    public function __construct($route)
    {
        parent::__construct($route);
        if(!Loader::check()) {
            View::redirect('/installer/setup');
        }
        $this->account = new Account();
        if(!$this->account->isLogin()) {
            View::redirect('/account/login');
        }
        $this->accountData = $this->account->getData();
        $this->accountData['positions'] = $this->account->getUserPosition($this->accountData['id_user']);
        $this->accountData['is_admin'] = $this->account->isAdmin($this->accountData['id_user']);
        $this->panel = $this->view->getView('panel/panel.php',
            [
                'userName'=> $this->model->getUserName($this->accountData),
                'isAdmin'=> $this->accountData['is_admin'],
                'action' => $this->route['panel']
            ]
        );
    }

    public function employeeAction() {
        //debug($this->model->getMenuItemEmployee($this->accountData['is_admin'], $this->accountData['positions']));
        //debug($this->account->getUserPosition($this->accountData['id_user']));
        $vars = [
            'panel' => $this->panel,
            'account' => $this->accountData,
            'menuEmployee' => $this->model->getMenuItemEmployee($this->accountData['is_admin'], $this->accountData['positions'])
        ];
        $this->view->render('Панель сотрудника', $vars);
    }

    public function adminAction() {
        View::redirect('/panel/admin/restaurants');
        $this->adminPanel = $this->view->getView('panel/admin/panel.php');
        $vars = [
            'panel' => $this->panel,
            'adminPanel' => $this->adminPanel,
        ];
        $this->view->render('Панель администратора', $vars);
    }

    public function restaurantsAction() {
        $this->view->path = '/panel/admin/restaurants';
        $this->adminPanel = $this->view->getView('panel/admin/panel.php',[
            'action' => $this->route['actionpanel']
        ]);
        $vars = [
            'panel' => $this->panel,
            'adminPanel' => $this->adminPanel,
            'restaurantsList' =>$this->model->getRestaurantsList()
        ];
        $this->view->render('Менеджер ресторанов', $vars);
    }

    public function addRestaurantAction() {
        if(!empty($_POST)) {
            if(isset($_POST['action']) && $_POST['action'] == "addRestaurant") {
                $this->model->addRestaurant($_POST);
            }
        } else {
            $this->view->path = '/panel/admin/restaurants/addRestaurant';
            $this->view->pathAfterBody = '/panel/admin/restaurants/addRestaurant';
            $this->adminPanel = $this->view->getView('panel/admin/panel.php',[
                'action' => $this->route['actionpanel']
            ]);
            $vars = [
                'panel' => $this->panel,
                'adminPanel' => $this->adminPanel,
            ];
            $this->view->render('Добавление ресторана', $vars);
        }
    }

    public function infoRestaurantAction() {
        if(!$this->model->existRestaurant($this->route['id'])) {
            View::errorCode(404);
        }
        $this->view->path = '/panel/admin/restaurants/infoRestaurant';
        $this->adminPanel = $this->view->getView('panel/admin/panel.php',[
            'action' => $this->route['actionpanel']
        ]);
        $vars = [
            'panel' => $this->panel,
            'adminPanel' => $this->adminPanel,
            'restaurantsData' => $this->model->getRestaurantById($this->route['id']),
            'menuAdmin' => $this->view->getView('panel/admin/restaurants/menuAdmin.php',[
                'idRestaurant' => $this->route['id'],
                'items' => $this->model->getMenuAdmin()
            ])
        ];
        $this->view->render('Ресторан', $vars);
    }

    public function actionRestaurantAction() {
        if(!$this->model->existRestaurant($this->route['id'])) {
            View::errorCode(404);
        }
        if(!$this->model->existActionRestaurant($this->route['idaction'])) {
            View::errorCode(404);
        }
        $this->view->path = '/panel/admin/restaurants/actionRestaurant';
        $this->adminPanel = $this->view->getView('panel/admin/panel.php',[
            'action' => $this->route['actionpanel']
        ]);
        $itemMenuAdmin = $this->model->getMenuAdminById($this->route['idaction']);
        $moduleData = $this->model->getModule($itemMenuAdmin['id_module']);
        $this->view->pathHead = '../modules/'.$moduleData['name'].'/views/admin';
        $this->view->pathAfterBody = '../modules/'.$moduleData['name'].'/views/admin';
        $vars = [
            'panel' => $this->panel,
            'adminPanel' => $this->adminPanel,
            'view' => $this->view->getViewModule($moduleData['name'].'/views/admin/'.$itemMenuAdmin['action'].'.php'),
            'menuAdmin' => $this->view->getView('panel/admin/restaurants/menuAdmin.php',[
                'idRestaurant' => $this->route['id'],
                'idAction' => $this->route['idaction'],
                'items' => $this->model->getMenuAdmin()
            ])
        ];
        $this->view->render($itemMenuAdmin['name'], $vars);
    }


    public function modulesAction() {
        if(!empty($_POST)) {
            if(isset($_POST['action']) && $_POST['action'] == "getModuleList") {
                $list = $this->model->getModulesListDir();
                $this->model->getModulesListAction(
                    $_POST,
                    $list,
                    $this->view->getView('panel/admin/modules/moduleList.php', ['modulesList' => $list])
                );
            }
            if(isset($_POST['action']) && $_POST['action'] == "initModule") {
                $this->model->initModule($_POST);
            }
        } else {
            $this->view->path = '/panel/admin/modules';
            $this->adminPanel = $this->view->getView('panel/admin/panel.php',[
                'action' => $this->route['actionpanel']
            ]);
            $this->view->pathAfterBody = '/panel/admin/modules';
            //debug($this->model->getModulesListDir());
            $vars = [
                'panel' => $this->panel,
                'adminPanel' => $this->adminPanel,
                'modulePanel' => $this->view->getView('panel/admin/modules/panel.php'),
                'modulesList' => $this->model->getModulesListDir()
            ];
            $this->view->render('Менеджер модулей', $vars);
        }
    }
}