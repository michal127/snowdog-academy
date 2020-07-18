<?php

namespace Snowdog\Academy\Controller\Admin;

use Snowdog\Academy\Model\BookManager;

class Csv extends AdminAbstract
{
    private const VALID_CSV_MIMETYPES = [
        'text/csv',
        'text/plain',
        'application/csv',
        'text/comma-separated-values',
        'application/excel',
        'application/vnd.ms-excel',
        'application/vnd.msexcel',
        'text/anytext',
        'application/octet-stream',
        'application/txt'
    ];

    private BookManager $bookManager;

    /**
     * Csv constructor.
     * @param BookManager $bookManager
     */
    public function __construct(BookManager $bookManager)
    {
        parent::__construct();
        $this->bookManager = $bookManager;
    }

    public function index(): void
    {
        require __DIR__ . '/../../view/admin/csv/index.phtml';
    }

    public function import(): void
    {
        $file = $_FILES['csvFile'];
        if ($this->isValidCsv($file)) {
            $savedBooks = $this->readFileContent($file);
            $success = true;
            $statusMessage = 'Loaded ' . $savedBooks . ' books. <a href="/admin">Go to book list</a>';
        } else {
            $success = false;
            $statusMessage = 'Select valid CSV file';
        }

        require __DIR__ . '/../../view/admin/csv/index.phtml';
    }

    /**
     * Csv file validation
     * @param $file
     * @return bool
     */
    private function isValidCsv($file): bool
    {
        return (
            pathinfo($file['name'])['extension'] === 'csv' &&
            !empty($file["size"]) &&
            in_array($file['type'], self::VALID_CSV_MIMETYPES)
        );
    }

    /**
     * Reading file content with save to database
     * @param $file
     * @return int
     */
    private function readFileContent($file): int
    {
        $fileResource = fopen($file["tmp_name"], "r");
        $result = 0;

        while (($row = fgetcsv($fileResource, 10000, ";")) !== FALSE) {
            $title = $row[0];
            $author = $row[1];
            $isbn = $row[2];
            if (!empty($title) && !empty($author) && !empty($isbn)) {
                if ($this->bookManager->create($title, $author, $isbn) > 0) {
                    $result++;
                }
            }
        }
        return $result;
    }
}