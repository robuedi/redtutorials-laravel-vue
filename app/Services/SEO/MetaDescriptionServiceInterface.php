<?php

namespace App\Services\SEO;

interface MetaDescriptionServiceInterface
{
    public function getCourseDescription(?string $course_name, ?string $course_description = '', ?array $chapters_name = []): string;
}
