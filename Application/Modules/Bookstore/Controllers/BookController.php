<?php

namespace Application\Modules\Bookstore\Controllers;

use Application\Core\Controller;

class BookController extends Controller
{
    public function listAction()
    {
        $list = $this->getEntityManager()->getModel('Bookstore:Book')->findAll();
        echo json_encode($list);
    }

    public function bookAction(int $id) {

    }

    public function filteredListAction(array $parameters) {

    }

    public function addAction() {

    }

    public function editAction(int $id) {

    }

    public function editTitleAction(int $id, string $newTitle) {

    }

    public function editAuthorsAction(int $id) {

    }

    public function editGenresAction(int $id) {

    }

    public function deleteAction(int $id) {

    }

}