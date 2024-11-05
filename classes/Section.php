<?php

namespace app\modules\specialsection\classes;
class Section {  
    public const  PAIDEDU = 'paidedu';
    public const  GRANTS = 'grants';
    public const  DOCUMENT = 'document';
    public const  COMMON = 'common';
    public const  EDUSTANDARTS = 'edustandarts';
    public const  INTER = 'inter';
    public const  BUDGET = 'budget';
    public const  OBJECTS = 'objects';
    public const  CATERING = 'catering';
    public const  EDUCATION = 'education';


    public static function getSections(){
        return [
           self::PAIDEDU,
           self::GRANTS,
           self::DOCUMENT,
           self::COMMON,
           self::EDUSTANDARTS,
           self::INTER,
           self::BUDGET,
           self::OBJECTS,
           self::CATERING,
           self::EDUCATION
        ];
    }
}
