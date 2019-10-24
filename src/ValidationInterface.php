<?php

namespace Repo;


interface ValidationInterface
{
    public function errors(): array;

    public function isValid(): bool;

    public function getFirstError(): ?string;
}