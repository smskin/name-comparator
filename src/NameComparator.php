<?php

namespace SMSkin\NameComparator;

class NameComparator implements INameComparator
{
    /**
     * @var string
     */
    protected $name1;

    /**
     * @var array
     */
    protected $name1Words;

    /**
     * @var string
     */
    protected $name2;

    /**
     * @var array
     */
    protected $name2Words;

    public function __construct(string $name1, string $name2)
    {
        $this->name1 = strtolower($name1);
        $this->name2 = strtolower($name2);
    }

    public function isEqual(): bool
    {
        if ($this->isEqualStrings()){
            return true;
        }

        $this->name1Words = $this->getWordsFromName($this->name1);
        $this->name2Words = $this->getWordsFromName($this->name2);

        if ($this->isEqualArrays()){
            return true;
        }

        if ($this->isName2IsPartOfName1()){
            return true;
        }

        $matchPercentage = $this->getMatchPercentage();
        if ($matchPercentage > 0.66){
            return true;
        }
        return false;
    }

    private function isEqualStrings(): bool
    {
        return $this->name1 === $this->name2;
    }

    private function getWordsFromName(string $name){
        preg_match_all('/(\w+)/i', $name, $matches);
        return $matches[0];
    }

    private function isEqualArrays(): bool
    {
        $diff1 = count(array_diff($this->name1Words, $this->name2Words));
        $diff2 = count(array_diff($this->name2Words, $this->name1Words));
        return (!$diff1 && !$diff2);
    }

    private function isName2IsPartOfName1(): bool
    {
        if (count($this->name2Words) >= count($this->name1Words)){
            return false;
        }
        $diff = count(array_diff($this->name2Words, $this->name1Words));
        return !$diff;
    }

    private function getMatchPercentage(): float
    {
        $intersect = count(array_intersect($this->name1Words, $this->name2Words));
        $max = (count($this->name1Words) > count($this->name2Words)) ? count($this->name1Words) : count($this->name2Words);
        return $intersect/$max;
    }
}