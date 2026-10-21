<?php

namespace App\Enums;

enum AdminTypeisEnum: int
{
    case Developer = 1;
    case GlobalManger = 2;
    case BranchManger = 3;
    case DepartmentManger = 4;
    case HrEmployee = 5;
    case Employee = 6;
}
