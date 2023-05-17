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

    public function actionEmployeeAction() {
        if(!$this->model->existActionEmployee($this->route['id_action'])) {
            View::errorCode(404);
        }
        $menuItem = $this->model->getMenuItemEmployee($this->accountData['is_admin'], $this->accountData['positions']);
        $checkAction = false;
        foreach($menuItem as $item) {
            if($item['id'] == $this->route['id_action']) {
                $checkAction = true;
                break;
            }
        }
        if(!$checkAction) {
            View::errorCode(404);
        }
        $itemMenuEmployee = $this->model->getMenuEmployeeById($this->route['id_action']);
        $moduleData = $this->model->getModule($itemMenuEmployee['id_module']);
        if(!empty($_POST)) {
            $path = '\application\modules\\'.$moduleData['name'].'\\'.ucfirst($moduleData['name']).'Module';
            $module = new $path();
            $module->action($_POST, $this->accountData);
        } else {
            $this->view->path = '/panel/employee/actionEmployee';

            $vars = [
                'panel' => $this->panel,
                'view' => $this->view->getViewModule($moduleData['name'].'/views/employee/'.$itemMenuEmployee['action'].'.php'),
                'moduleName' => $moduleData['name'],
                'idAction' => $this->route['id_action'],
                'actionName' => $itemMenuEmployee['action']
            ];
            $this->view->render($itemMenuEmployee['name'], $vars);
        }
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
        if(!empty($_POST)) {
            if(isset($_POST['action']) && $_POST['action'] == "windowFormAddRestaurant") {
                $viewForm = $this->view->getView('panel/admin/restaurants/addRestaurant.php');
                $this->model->getWindowFormAddRestaurant($viewForm);
            }
        } else {
            $this->view->path = '/panel/admin/restaurants';
            $this->view->pathAfterBody = '/panel/admin/restaurants/addRestaurant';
            $this->adminPanel = $this->view->getView('panel/admin/panel.php', [
                'action' => $this->route['action_panel']
            ]);
            $vars = [
                'panel' => $this->panel,
                'adminPanel' => $this->adminPanel,
                'restaurantsList' => $this->model->getRestaurantsList()
            ];
            $this->view->render('Менеджер ресторанов', $vars);
        }
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
                'action' => $this->route['action_panel']
            ]);
            $vars = [
                'panel' => $this->panel,
                'adminPanel' => $this->adminPanel,
            ];
            $this->view->render('Добавление ресторана', $vars);
        }
    }

    public function infoRestaurantAction() {
        if(!$this->model->existRestaurant($this->route['id_restaurant'])) {
            View::errorCode(404);
        }
        $this->view->path = '/panel/admin/restaurants/infoRestaurant';
        $this->adminPanel = $this->view->getView('panel/admin/panel.php',[
            'action' => $this->route['action_panel']
        ]);
        $vars = [
            'panel' => $this->panel,
            'adminPanel' => $this->adminPanel,
            'restaurantsData' => $this->model->getRestaurantById($this->route['id_restaurant']),
            'menuAdmin' => $this->view->getView('panel/admin/restaurants/menuAdmin.php',[
                'idRestaurant' => $this->route['id_restaurant'],
                'items' => $this->model->getMenuAdmin()
            ])
        ];
        $this->view->render('Ресторан', $vars);
    }

    public function actionRestaurantAction() {
        if(!$this->model->existRestaurant($this->route['id_restaurant'])) {
            View::errorCode(404);
        }
        if(!$this->model->existActionRestaurant($this->route['id_action'])) {
            View::errorCode(404);
        }
        $itemMenuAdmin = $this->model->getMenuAdminById($this->route['id_action']);
        $moduleData = $this->model->getModule($itemMenuAdmin['id_module']);
        if(!empty($_POST)) {
            $path = '\application\modules\\'.$moduleData['name'].'\\'.ucfirst($moduleData['name']).'Module';
            $module = new $path();
            $module->action($_POST, $this->accountData, $this->model->getRestaurantById($this->route['id_restaurant']));
        } else {
            $this->view->path = '/panel/admin/restaurants/actionRestaurant';
            $this->adminPanel = $this->view->getView('panel/admin/panel.php',[
                'action' => $this->route['action_panel']
            ]);
            $vars = [
                'panel' => $this->panel,
                'adminPanel' => $this->adminPanel,
                'view' => $this->view->getViewModule($moduleData['name'].'/views/admin/'.$itemMenuAdmin['action'].'.php'),
                'idRestaurant' => $this->route['id_restaurant'],
                'moduleName' => $moduleData['name'],
                'actionName' => $itemMenuAdmin['action'],
                'idAction' => $this->route['id_action'],
                'menuAdmin' => $this->view->getView('panel/admin/restaurants/menuAdmin.php',[
                    'idRestaurant' => $this->route['id_restaurant'],
                    'idAction' => $this->route['id_action'],
                    'items' => $this->model->getMenuAdmin()
                ])
            ];
            $this->view->render($itemMenuAdmin['name'], $vars);
        }
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
            if(isset($_POST['action']) && $_POST['action'] == "disableModule") {
                $this->model->disableModule($_POST);
            }
        } else {
            $this->view->path = '/panel/admin/modules';
            $this->adminPanel = $this->view->getView('panel/admin/panel.php',[
                'action' => $this->route['action_panel']
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

    private function getWindowFormAddRestaurant() {
        $this->view->getView('panel/admin/restaurants/addRestaurant.php');
    }
}