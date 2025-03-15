<?php

namespace app\Domains\User;

enum Role: string
{
    case HeadNurse = 'HeadNurse';
    case Chief = 'Chief';
    case Nurse = 'Nurse';
    case AssociateNurse = 'AssociateNurse';
    case Part = 'Part';
    case Arbeit = 'Arbeit';

    public function label(): string
    {
        return match ($this) {
            Role::HeadNurse => '看護師長',
            Role::Chief => '主任',
            Role::Nurse => '看護師',
            Role::AssociateNurse => '准看護師',
            Role::Part => 'パート',
            default => 'アルバイト',
        };
    }
}
