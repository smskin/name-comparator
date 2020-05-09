![PHP Composer](https://github.com/smskin/name-comparator/workflows/PHP%20Composer/badge.svg)

Simple name comparator library for compare two full name records and determine if it's the same person.

Full name can have different length and words count (1-4 words) and words order (first/middle/last name) and can contain commas/dots/extra spaces.

We expect to have a class and a unit test to cover all possible cases.

Examples of names:
ADLINE
OLISEMEKA ADLINE
ADLINE AGU OLISEMEKA
ZAINAB, OLABISI ABDULSALAM
Agu Adline
ZAINAB OLABISI, Abdulsalam

Examples of valid names:
IDOWU = IDOWU
IDOWU EBUNOLUWA = EBUNOLUWA IDOWU
IDOWU EBUNOLUWA = IDOWU EBUNOLUWA
IDOWU SARAH EBUNOLUWA = EBUNOLUWA IDOWU
IDOWU EBUNOLUWA SARAH = SARAH, EBUNOLUWA IDOWU