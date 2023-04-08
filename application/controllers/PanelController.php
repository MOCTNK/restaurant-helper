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
        $this->accountData = $this->account->getData();
        if(!$this->account->isLogin()) {
            View::redirect('/account/login');
        }
        $this->panel = $this->view->getView('panel/panel.php',
            [
                'userName'=> $this->model->getUserName($this->accountData),
                'isAdmin'=> $this->account->isAdmin($this->accountData['id_user']),
                'action' => $this->model->getAction()
            ]
        );
    }

    public function employeeAction() {
        $vars = [
            'panel' => $this->panel,
            'account' => $this->accountData,
            'positions' => $this->account->getUserPosition($this->accountData['id_user'])
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
            'action' => $this->model->getAdminAction()
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
                'action' => $this->model->getAdminAction()
            ]);
            $vars = [
                'panel' => $this->panel,
                'adminPanel' => $this->adminPanel,
            ];
            $this->view->render('Добавление ресторана', $vars);
        }
    }


    public function modulesAction() {
        $this->view->path = '/panel/admin/modules';
        $this->adminPanel = $this->view->getView('panel/admin/panel.php',[
            'action' => $this->model->getAdminAction()
        ]);
        $vars = [
            'panel' => $this->panel,
            'adminPanel' => $this->adminPanel,
        ];
        $this->view->render('Менеджер модулей', $vars);
    }
}