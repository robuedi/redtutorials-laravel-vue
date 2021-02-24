<?php


namespace App\Services\SEO;


class MetaDescriptionService implements MetaDescriptionServiceInterface
{
    public function getCourseDescription(?string $course_name, ?string $course_meta_description = '', ?array $chapters_name = []) : string
    {
        //set meta
        $meta_description = '';

        if(!$course_name&&!$course_meta_description)
        {
            return $meta_description;
        }

        //set course name
        if($course_name)
        {
            $meta_description = app()->getLocale('seo_meta.description_one').$course_name.'. ';
        }

        //put in meta description the description or the chapters
        if($course_meta_description)
        {
            $meta_description .= $course_meta_description;
        }
        else if($chapters_name)
        {
            //add chapters
            $meta_description .= app()->getLocale('seo_meta.description_two').implode(', ', $chapters_name).'.';
        }

        return strip_tags($meta_description);
    }

}
