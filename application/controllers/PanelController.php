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
        $vars = [
            'panel' => $this->panel
        ];
        $this->view->render('Панель администратора', $vars);
    }
}