<?php

namespace Core\Database;

use Core\DI\Attributes\Inject;

class Repository
{
    protected const TABLE = '';
    public function __construct(
        #[Inject(DATABASE)] protected readonly Database $database
    ) {
        $this->initialize();
    }

    protected function initialize(): void
    {}
}
