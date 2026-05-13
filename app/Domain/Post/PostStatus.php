<?php

namespace App\Domain\Post;

enum PostStatus: string
{
    Case DRAFT = 'rascunho';
    Case PUBLISHED = 'publicado';
    Case ARCHIVED = 'arquivado';
}
