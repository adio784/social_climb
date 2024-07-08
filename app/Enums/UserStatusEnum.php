<?php

namespace Modules\Users\Database\Enums;

enum UserStatusEnum
{
    const REGISTERED = 'registered';
    const VERIFIED = 'verified';
    const APPROVED = 'approved';
    const DEACTIVATED = 'deactivated';
    const SUSPENDED = 'suspended';
}
