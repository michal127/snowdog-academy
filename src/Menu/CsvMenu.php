<?php


namespace Snowdog\Academy\Menu;


class CsvMenu extends AbstractMenu
{

    public function getHref(): string
    {
        return '/admin/csv';
    }

    public function getLabel(): string
    {
        return 'CSV Import';
    }

    public function isVisible(): bool
    {
        return $_SESSION['login'] && $_SESSION['is_admin'];
    }
}