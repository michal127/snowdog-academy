<?php

namespace Snowdog\Academy\Migration;

use Snowdog\Academy\Core\Database;

class Version5
{
    private Database $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function __invoke(): void
    {
        $this->addBooksForAdultsColumn();
        $this->addUsersBirthDateColumn();
    }


    private function addBooksForAdultsColumn(): void
    {
        $query = 'ALTER TABLE books ADD forAdults BOOL DEFAULT 0';
        $this->database->exec($query);
    }

    private function addUsersBirthDateColumn(): void
    {
        $query = 'ALTER TABLE users ADD birthdate DATE';
        $this->database->exec($query);
    }
}