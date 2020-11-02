<?php

namespace application\controllers;

use application\core\Controller;
use application\lib\Pagination;
use application\models\Admin;

class MainController extends Controller {

    public function indexAction() {
        $pagination = new Pagination($this->route, $this->model->postsCount());
        $vars = [
            'pagination' => $pagination->get(),
            'list' => $this->model->postsList($this->route),
        ];
        $this->view->render('Главная страница', $vars);
    }

    public function aboutAction() {
        $this->view->render('Обо мне');
    }

    public function contactAction() {
        if(!empty($_POST)) {
            if (!$this->model->contactValidate($_POST)){
                $this->view->message('error', $this->model->error);
            }
            mail('max@mail.com', 'Sub', $_POST['name'].'|'.$_POST['email'].'|'.$_POST['text']);
            $this->view->message('success', 'Сообщение отправлено');
        }
        $this->view->render('Контакты');
    }

    public function postAction() {

        $adminModel = new Admin;
        if(!$adminModel->isPostExists($this->route['id'])) {
            $this->view->errorCode(404);
        }
            $vars = [
                'data' => $adminModel->postData($this->route['id'])[0],
                'comments_list' => $this->model->commentsList($this->route['id']),
            ];
        if(!empty($_POST)) {
            if (!$this->model->postCommentValidate($_POST)){
                $this->view->message('error', $this->model->error);
            } else {
                    $id = $this->model->postCommentGet($_POST, $this->route['id']);
                    if(!$id){
                        $this->view->message('success', 'Ошыбка обработки запроса');
                    }
                $this->view->message('success', 'Сообщение отправлено');
            }
        }
        $this->view->render('Пост', $vars);
    }



}