<?php

namespace BetterUptime\DataTypes;

/**
 * Available ssl expiration options (in days)
 */
enum SslExpiration: int
{
    case ONE = 1;
    case TWO = 2;
    case THREE = 3;
    case SEVEN = 7;
    case FOURTEEN = 14;
    case THIRTY = 30;
    case SIXTY = 60;
}
