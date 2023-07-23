<?php

namespace BetterUptime\DataTypes;

enum Region: string
{
    case US = 'us';
    case EU = 'eu';
    case AS = 'as';
    case AU = 'au';
}
