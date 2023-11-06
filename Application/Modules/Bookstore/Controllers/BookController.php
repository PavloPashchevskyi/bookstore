<?php

namespace Application\Modules\Bookstore\Controllers;

use Application\Core\Controller;
use Application\Core\Exceptions\ModelNotFoundException;

class BookController extends Controller
{
    /**
     * GET /api/v1/books
     *
     * @return void
     * @throws \Application\Core\Exceptions\ModelClassNotDefinedException
     * @throws \Application\Core\Exceptions\ModelNotFoundException
     */
    public function listAction()
    {
        $list = $this->getEntityManager()->getModel('Bookstore:Book')->findAll();
        $this->view->render($list);
    }

    /**
     * POST /api/v1/books
     *
     * @return void
     */
    public function addAction() {
        $requestData = file_get_contents('php://input');
        $book = json_decode($requestData, true);
        $author = $this->getEntityManager()->getModel('Bookstore:Author');
        if (!array_key_exists('authors', $book)) {
            throw new ModelNotFoundException('Bookstore', 'Author');
        }
        $absentAuthors = array_diff($book['authors'], array_map(function ($a) {
            return $a['name'];
        }, $author->findAll()));
        $authorsIDs = [];
        foreach ($absentAuthors as $i => $absentAuthor) {
            $authorsIDs[$i] = $author->insert([
                'id' => $author->calculateNextID(),
                'name' => $absentAuthor,
            ]);
        }
        $genre = $this->getEntityManager()->getModel('Bookstore:Genre');
        if (!array_key_exists('genres', $book)) {
            throw new ModelNotFoundException('Bookstore', 'Genres');
        }
        $absentGenres = array_diff($book['genres'], array_map(function ($a) {
            return $a['name'];
        }, $genre->findAll()));
        $genresIDs = [];
        foreach ($absentGenres as $i => $absentGenre) {
            $genresIDs[$i] = $genre->insert([
                'id' => $genre->calculateNextID(),
                'name' => $absentGenre,
            ]);
        }
        $bookEntity = $this->getEntityManager()->getModel('Bookstore:Book');
        $bookId = $bookEntity->insert([
            'id' => $bookEntity->calculateNextID(),
            'title' => $book['title'],
            'published_year' => $book['published_year'],
        ]);
        $bookAuthor = $this->getEntityManager()->getModel('Bookstore:BookAuthor');
        foreach ($authorsIDs as $authorID) {
            $bookAuthor->insert([
                'id' => $bookAuthor->calculateNextID(),
                'book_id' => $bookId,
                'author_id' => $authorID,
            ]);
        }
        $bookGenre = $this->getEntityManager()->getModel('Bookstore:BookGenre');
        foreach ($genresIDs as $genreID) {
            $bookGenre->insert([
                'id' => $bookGenre->calculateNextID(),
                'book_id' => $bookId,
                'genre_id' => $genreID,
            ]);
        }
        $this->view->render($bookEntity->findAll());
    }

    /**
     * PATCH /api/v1/books
     *
     * @param int $id
     * @param string $newTitle
     * @return void
     * @throws ModelNotFoundException
     */
    public function editTitleAction() {
        $requestData = file_get_contents('php://input');
        $book = json_decode($requestData, true);
        if (!array_key_exists('id', $book) || !array_key_exists('title', $book)) {
            throw new ModelNotFoundException('Bookstore', 'Book');
        }
        $this->getEntityManager()->getModel('Bookstore:Book')
            ->update(['title' => $book['title']], ['id' => $book['id']]);
        return $this->view
            ->render($this->getEntityManager()->getModel('Bookstore:Book')->findOne($book['id']));
    }

    /**
     * PATCH /api/v1/books
     *
     * @param int $id
     * @return void
     * @throws ModelNotFoundException
     */
    public function editPublishedYearAction() {
        $requestData = file_get_contents('php://input');
        $book = json_decode($requestData, true);
        if (!array_key_exists('id', $book) || !array_key_exists('published_year', $book)) {
            throw new ModelNotFoundException('Bookstore', 'Book');
        }
        $this->getEntityManager()->getModel('Bookstore:Book')
            ->update(['published_year' => $book['published_year']], ['id' => $book['id']]);
        return $this->view
            ->render($this->getEntityManager()->getModel('Bookstore:Book')->findOne($book['id']));
    }

    /**
     * DELETE /api/v1/books
     *
     * @param int $id
     * @return void
     */
    public function deleteAction() {
        $requestData = file_get_contents('php://input');
        $book = json_decode($requestData, true);
        if (!array_key_exists('id', $book)) {
            throw new ModelNotFoundException('Bookstore', 'BookAuthor');
        }
        $this->getEntityManager()->getModel('Bookstore:BookAuthor')->delete(['book_id' => $book['id']]);
        $this->getEntityManager()->getModel('Bookstore:BookGenre')->delete(['book_id' => $book['id']]);
        $this->getEntityManager()->getModel('Bookstore:Book')->delete($book);
        $this->view->render($this->getEntityManager()->getModel('Bookstore:Book')->findAll());
    }

}