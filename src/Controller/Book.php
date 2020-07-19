<?php

namespace Snowdog\Academy\Controller;

use Snowdog\Academy\Model\Book as BookModel;
use Snowdog\Academy\Model\BookManager;
use Snowdog\Academy\Model\BorrowManager;
use Snowdog\Academy\Model\User;
use Snowdog\Academy\Model\UserManager;

class Book
{
    private BorrowManager $borrowManager;
    private User $user;
    private BookManager $bookManager;

    public function __construct(BorrowManager $borrowManager, UserManager $userManager, BookManager $bookManager)
    {
        if (!isset($_SESSION['login'])) {
            header('Location: /');
            return;
        }

        $this->user = $userManager->getByLogin($_SESSION['login']);
        if (!$this->user->getId()) {
            header('Location: /');
            return;
        }

        $this->borrowManager = $borrowManager;
        $this->bookManager = $bookManager;
    }

    public function borrow(int $id): void
    {
        $book = $this->bookManager->getBookById($id);
        if ($book instanceof BookModel && $book->isForAdults() && !$this->user->isAdult()) {
            $_SESSION['flash'] = 'This book is for adult users only!';
        } else if ($this->borrowManager->create($this->user->getId(), $id)) {
            $_SESSION['flash'] = 'You have successfully borrowed a book!';
        } else {
            $_SESSION['flash'] = 'There was an error while borrowing a book';
        }

        header('Location: /my_books');
    }

    public function return(int $id): void
    {
        if ($this->borrowManager->return($this->user->getId(), $id)) {
            $_SESSION['flash'] = 'You have successfully returned a book!';
        } else {
            $_SESSION['flash'] = 'There was an error while returning a book';
        }

        header('Location: /my_books');
    }
}
