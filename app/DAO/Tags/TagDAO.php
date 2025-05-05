<?php

namespace DAO\Tags;

interface TagDAO
{
    public function getTagId($tagName);
    public function getAllTags();
}