<?php

namespace App\Controllers;

use App\Core\App;
use App\Models\Auth;

/**
 * Class AuthController
 * @package App\Controllers
 */
class AuthController extends BaseController
{
    /**
     * Страница логина
     */
    public function actionIndex() : void
    {
        if ($this->isAuth()) {
            App::getInstance()->redirect('account');
            return;
        }

        $this->render("auth/login", [
            "title" => "Login page"
        ]);
    }

    /**
     * ToDo: Добавить поддержку Ajax запросов
     * Обработка формы авторизации
     */
    public function actionLogin() : void
    {
        if ($this->isAuth()) {
            App::getInstance()->redirect('account');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['login'])) {

            if ((new Auth())->login($_POST['login'], $_POST['pass'])) {
                App::getInstance()->redirect('account');
                return;
            }
        }
        // ToDo: Надо показывать ошибки вместе редиректа
        App::getInstance()->redirect('auth');
    }

    /**
     * Логаут
     */
    public function actionLogout() : void
    {
        if ($this->isAuth()) {
            (new Auth())->logout();
        }

        App::getInstance()->redirect();
    }

}