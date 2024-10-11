<?php

namespace App;

enum MetodeBayar: string
{
    case cash = 'Cash';
    case transfer = 'Transfer';
}
