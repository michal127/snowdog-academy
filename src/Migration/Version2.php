<?php

namespace Snowdog\Academy\Migration;

use Snowdog\Academy\Core\Database;
use Snowdog\Academy\Model\BookManager;

class Version2
{
    private Database $database;
    private BookManager $bookManager;

    public function __construct(Database $database, BookManager $bookManager)
    {
        $this->database = $database;
        $this->bookManager = $bookManager;
    }

    public function __invoke()
    {
        $this->createBooksTable();
        $this->addBooks();
    }

    private function createBooksTable(): void
    {
        $createQuery = <<<SQL
CREATE TABLE `books` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `isbn` varchar(13) NOT NULL,
  `borrowed` boolean NOT NULL default 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `isbn` (`isbn`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SQL;
        $this->database->exec($createQuery);
    }

    private function addBooks(): void
    {
        $insertQuery =
            'INSERT INTO `books` (`title`, `author`, `isbn`) VALUES
            ("Harry Potter and the Chamber of Secrets", "J. K. Rowling", "9780439064873"), 
            ("It: A Novel", "Stephen King", "9781501142970"),
            ("The Da Vinci Code", "Dan Brown", "9780307474278"),
            ("Wiedźmin. Ostatnie życzenie", "Andrzej Sapkowski", "9788375780635")';
        $this->database->exec($insertQuery);
    }
}
