<?php

namespace Application\Modules\Bookstore\Controllers;

use Application\Core\Controller;

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
        echo json_encode($list);
    }

    /**
     * GET /api/v1/books/:id
     *
     * @param int $id
     * @return void
     */
    public function bookAction(int $id) {

    }

    /**
     * GET /api/v1/books/?param1=value1&param2=value2
     *
     * @param array $parameters
     * @return void
     */
    public function filteredListAction(array $parameters) {

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
        $absentAuthors = array_diff($book['authors'], $author->findAll());
        $authorsIDs = [];
        foreach ($absentAuthors as $i => $absentAuthor) {
            $authorsIDs[$i] = $author->insert([
                'id' => $author->calculateNextID(),
                'name' => $absentAuthor,
            ]);
        }
        $genre = $this->getEntityManager()->getModel('Bookstore:Genre');
        $absentGenres = array_diff($book['genres'], $genre->findAll());
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
        return json_encode($bookEntity->findOne($bookId));
    }

    /**
     * PUT /api/v1/books
     *
     * @param int $id
     * @return void
     */
    public function editAction(int $id) {

    }

    /**
     * PATCH /api/v1/books
     *
     * @param int $id
     * @param string $newTitle
     * @return void
     */
    public function editTitleAction(int $id, string $newTitle) {

    }

    /**
     * PATCH /api/v1/books
     *
     * @param int $id
     * @return void
     */
    public function editAuthorsAction(int $id) {

    }

    /**
     * PATCH /api/v1/books
     *
     * @param int $id
     * @return void
     */
    public function editGenresAction(int $id) {

    }

    /**
     * DELETE /api/v1/books/:id
     *
     * @param int $id
     * @return void
     */
    public function deleteAction(int $id) {

    }

}