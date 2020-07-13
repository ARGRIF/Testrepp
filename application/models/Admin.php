<?php

namespace application\models;

use application\core\Model;
use Imagick;

class Admin extends Model
{

    public $error;

    public function loginValidate($post) {
        $config = require 'application/config/admin.php';
        if ($config['login'] != $post['login'] or $config['password'] != $post['password'] ) {
            $this->error = 'Логин или пароль указан не верно';
            return false;
        }
        return true;
    }

    public function postValidate($post, $type) {
        $nameLen = iconv_strlen($post['name']);
        $descriptionLen = iconv_strlen($post['description']);
        $textLen = iconv_strlen($post['text']);
        if ($nameLen < 3 or $nameLen > 100) {
            $this->error = ' Название должно содержать от 3 до 100 символов ';
            return false;
        } elseif ($descriptionLen < 3 or $descriptionLen > 100) {
            $this->error = ' Описание должно содержать от 3 до 100 символов ';
            return false;
        } elseif ($textLen < 10 or $textLen > 5000){
            $this->error = ' Текст должно быть от 10 до 5000 символов ';
            return false;
        }

        if(empty($_FILES['img']['tmp_name']) and $type == 'add') {
            $this->error = 'Изображение не выбрано';
            return false;
        }
        return true;
    }

    public function postAdd($post) {

        $params = [
            'id' => null,
            'name' => $post['name'],
            'description' => $post['description'],
            'text' => $post['text'],
            'date' => $post['date'],

        ];
        $this->db->query('INSERT INTO `posts` VALUES (:id, :name, :description, :text, :date)', $params);
        return $this->db->lastInsertId();
    }

    public function postEdit($post, $id) {

        $params = [
            'id' => $id,
            'name' => $post['name'],
            'description' => $post['description'],
            'text' => $post['text'],
            'date' => $post['date'],

        ];
        $this->db->query('UPDATE posts SET name = :name, description = :description, text = :text, date = :date WHERE id = :id ', $params);
    }

    public function postUploadImage($path, $id) {

        $img = new Imagick($path);
        $img->setImageCompressionQuality(100);
        $img->cropThumbnailImage(1080, 300);
        $img->writeImage('F:/OSPanel/domains/blog/public/materials/'.$id.'.jpg');
        //move_uploaded_file($img, 'public/materials/'.$id.'.jpg');
    }

    public function isPostExists($id) {
        $params = [
            'id' => $id
        ];
        return $this->db->column('SELECT id FROM posts WHERE id = :id', $params);
    }

    public function postDelete($id) {
        $params = [
            'id' => $id
        ];
      $this->db->column('DELETE FROM posts WHERE id = :id', $params);
      unlink('public/materials/'.$id.'.jpg');
    }

    public  function postData($id) {
        $params = [
            'id' => $id
        ];
        return $this->db->row('SELECT * FROM posts WHERE id = :id', $params);
    }

}
