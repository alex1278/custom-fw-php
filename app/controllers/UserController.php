<?php

namespace app\controllers;


use app\models\User;
use fw\core\base\View;

class UserController extends AppController
{
    /**
     * метод регистрации нового пользователя
     */
    public function signupAction(){
        if(!empty($_POST)){
            $user = new User();
            $data = $_POST;
            $user->load($data);
            if(!$user->validate($data) || !$user->checkUnique()){
                $user->getErrors();

                // запоминаем данные которые пришли постом и возвращаем их если не пройдена валидация
                $_SESSION['form_data'] = $data;
                redirect();
            }
            $user->attributes['password'] = password_hash($user->attributes['password'], PASSWORD_DEFAULT);
            if($user->save('user')){
                $_SESSION['success'] = "Вы успешно зарегестрированы!";
            }else{
                $_SESSION['error'] = "Ошибка! Попробуйте позже.";
            }
            redirect();
        }
        View::setMeta('Registration');
    }

    /**
     * авторизация пользователя
     */
    public function loginAction(){
        if(!empty($_POST)){
            $user = new User();
            if($user->login()){
                $_SESSION['success'] = "Вы успешно авторизованы!";
            }else{
                $_SESSION['error'] = "Пароль/логин не совпадают.";
            }
            redirect();
        }
        View::setMeta('Login');
    }

    /**
     * выход пользователя, убиваем сессию для данного пользователя
     */
    public function logoutAction(){
        if(isset($_SESSION['user'])){
            unset($_SESSION['user']);
            redirect('/user/login');
        }
    }


}