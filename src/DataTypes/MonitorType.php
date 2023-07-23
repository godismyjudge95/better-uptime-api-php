<?php

namespace BetterUptime\DataTypes;

enum MonitorType: string
{
    /** We will check your website for a 2XX HTTP status code. */
    case STATUS = 'status';

    /** We will check if your website returned one of the values in expected_status_codes. */
    case EXPECTED_STATUS_CODE = 'expected_status_code';

    /** We will check if your website contains the required_keyword. */
    case KEYWORD = 'keyword';

    /** We will check if your website doesn't contain the required_keyword. */
    case KEYWORD_ABSENCE = 'keyword_absence';

    /** We will ping your host specified in the url parameter. */
    case PING = 'ping';

    /** We will test a TCP port at your host specified in the url parameter (port is required). */
    case TCP = 'tcp';

    /** We will test a UDP port at your host specified in the url parameter (port and required_keyword are required). */
    case UDP = 'udp';

    /**
     * We will check for a SMTP server at the host specified in the url parameter
     * (port is required, and can be one of these: 25, 465, 587, or a combination of those ports separated by comma).
     */
    case SMTP = 'smtp';

    /** We will check for a POP3 server at the host specified in the url parameter (port is required, and can be 110, 995, or both). */
    case POP = 'pop';

    /** We will check for an IMAP server at the host specified in the url parameter (port is required, and can be 143, 993, or both). */
    case IMAP = 'imap';
}
