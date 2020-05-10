<?php

namespace SMSkin\NameComparator;

class NameComparator implements INameComparator
{
    public function isEqual(string $name1, string $name2): bool
    {
        if ($this->isEqualStrings($name1,$name2)){
            return true;
        }

        $name1Words = $this->getWordsFromName($name1);
        $name2Words = $this->getWordsFromName($name2);

        if ($this->isEqualArrays($name1Words, $name2Words)){
            return true;
        }

        if ($this->isName2IsPartOfName1($name1Words, $name2Words)){
            return true;
        }

        $matchPercentage = $this->getMatchPercentage($name1Words, $name2Words);
        if ($matchPercentage > 0.66){
            return true;
        }
        return false;
    }

    private function isEqualStrings(string $name1, string $name2): bool
    {
        return $name1 === $name2;
    }

    private function getWordsFromName(string $name){
        preg_match_all('/(\w+)/i', $name, $matches);
        return $matches[0];
    }

    private function isEqualArrays(array $name1Words, array $name2Words): bool
    {
        $diff1 = count(array_diff($name1Words, $name2Words));
        $diff2 = count(array_diff($name2Words, $name1Words));
        return (!$diff1 && !$diff2);
    }

    private function isName2IsPartOfName1(array $name1Words, array $name2Words): bool
    {
        if (count($name2Words) >= count($name1Words)){
            return false;
        }
        $diff = count(array_diff($name2Words, $name1Words));
        return !$diff;
    }

    private function getMatchPercentage(array $name1Words, array $name2Words): float
    {
        $intersect = count(array_intersect($name1Words, $name2Words));
        $name1WordsCount = count($name1Words);
        $name2WordsCount = count($name2Words);
        $max = ($name1WordsCount > $name2WordsCount) ? $name1WordsCount : $name2WordsCount;
        return $intersect/$max;
    }
}