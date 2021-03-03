<?php


namespace App\Services\Progress\Decorator;

abstract class ProgressDecorator implements Progress
{
    protected Progress $sub_section;
    protected array $ids;

    public function __construct(Progress $sub_section)
    {
        $this->sub_section = $sub_section;
    }

    public function setIDs(array $ids): Progress
    {
        $this->ids = $ids;
        return $this;
    }

    public function setUsersIDs(array $users_id): Progress
    {
        $this->sub_section->setUsersIDs($users_id);
        return $this;
    }

    protected function setChildrenIDs(array $users_id): Progress
    {
        $this->sub_section->setIDs($users_id);
        return $this;
    }

    public function getIDs() : array
    {
        return $this->sub_section->getIDs();
    }

    public function getUsersIDs(): array
    {
        return $this->sub_section->getUsersIDs();
    }

    protected function getChildrenProgress(): array
    {
        return $this->sub_section->getProgress();
    }

    abstract protected function getChildrenByParent();

    public function getProgress(bool $floor = false): array
    {
        $lesson_subsections = $this->getChildrenByParent();

        //transform array
        array_walk($lesson_subsections, function (&$lesson){
            array_walk($lesson, function (&$section){
                $section = $section['id'];
            });
        });

        //get subsections ids
        $subsections_ids = array_reduce($lesson_subsections, function ($value1, $value2){
            return array_merge($value1, $value2);
        }, []);

        //get child progress
        self::setChildrenIDs($subsections_ids);
        $subsection_status = self::getChildrenProgress();

        $response = [];
        $users_id = self::getUsersIDs();
        //transform array
        array_walk( $users_id, function ($user_id) use (&$response, &$subsection_status, &$lesson_subsections, &$floor){
            array_walk($this->ids, function ($lesson_id) use (&$response, &$user_id, &$subsection_status, &$lesson_subsections, &$floor){
                $extract_user_sections = array_intersect_key($subsection_status[$user_id],array_flip($lesson_subsections[$lesson_id] ??[]));
                //check if any lesson sections
                if(!count($extract_user_sections))
                {
                    $response[$user_id][$lesson_id] = 0;
                    return;
                }

                //floor the value?
                if($floor)
                {
                    $result = array_sum($extract_user_sections)/count($extract_user_sections);
                    $response[$user_id][$lesson_id] =  floor($result * 100) / 100;
                }

                $response[$user_id][$lesson_id] = array_sum($extract_user_sections)/count($extract_user_sections);
            });
        });

        return $response;
    }

}
