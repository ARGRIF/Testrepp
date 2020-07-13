<?php

namespace application\models;

use application\core\Model;

class Main extends Model {

    public $error;

    public function contactValidate($post)
    {
        $nameLen = iconv_strlen($post['name']);
        $textLen = iconv_strlen($post['text']);
        if ($nameLen < 3 or $nameLen > 20) {
            $this->error = ' Имя должно содержать от 3 до 20 символов ';
            return false;
        } else if (!filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
            $this->error = ' Email указан не верно ';
            return false;
        } else if ($textLen < 20 or $textLen > 200){
            $this->error = ' сообщение должно быть от 20 до 200 символов ';
            return false;
        }
        return true;
    }

    public function postsCount() {
        return $this->db->column('SELECT COUNT(id) FROM posts');
    }

    public function postsList($route) {
        $max = 10;
        $params = [
            'max' => $max,
            'start' => (($route['page'] ?? 1) - 1) * $max,
        ];

        return $this->db->row('SELECT * FROM posts ORDER BY id DESC LIMIT :start, :max', $params);
    }
}
