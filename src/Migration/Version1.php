<?php

namespace Snowdog\Academy\Migration;

use Snowdog\Academy\Core\Database;
use Snowdog\Academy\Model\UserManager;

class Version1
{
    private Database $database;
    private UserManager $userManager;

    public function __construct(Database $database, UserManager $userManager)
    {
        $this->database = $database;
        $this->userManager = $userManager;
    }

    public function __invoke()
    {
        $this->createUsersTable();
        $this->addUsers();
    }

    private function createUsersTable(): void
    {
        $createQuery = <<<SQL
CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `password` varchar(128) NOT NULL,
  `is_admin` boolean NOT NULL default 0,
  `is_active` boolean NOT NULL default 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SQL;
        $this->database->exec($createQuery);
    }

    private function addUsers(): void
    {
        $insertQuery =
            'INSERT INTO `users` (`login`, `password`, `is_admin`, `is_active`) VALUES
            ("admin", SHA2("admin", 512), 1, 1), 
            ("baca", SHA2("zaq12wsx", 512), 0, 1), 
            ("maca", SHA2("xsw23edc", 512), 0, 1),
            ("onuca", SHA2("cde34rfv", 512), 0, 0)';
        $this->database->exec($insertQuery);
    }
}
