<?php

namespace Core\DI\Exceptions;

use Core\DI\Interfaces\NotFoundExceptionInterface;

class ProviderNotFoundException extends ContainerException implements NotFoundExceptionInterface
{}
