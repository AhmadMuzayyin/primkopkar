<?php

namespace App;

enum Role: string
{
    case Admin = 'Admin';
    case Bendahara = 'Bendahara';
    case Kasir = 'Kasir';
}
