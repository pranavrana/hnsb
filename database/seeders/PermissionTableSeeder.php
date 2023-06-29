<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            //roles & Permission
            array("group_name" => "Roles", "name" => "role-list"),
            array("group_name" => "Roles", "name" => "role-create"),
            array("group_name" => "Roles", "name" => "role-edit"),
            array("group_name" => "Roles", "name" => "role-delete"),
            //user
            array("group_name" => "User", "name" => "user-list"),
            array("group_name" => "User", "name" => "user-create"),
            array("group_name" => "User", "name" => "user-edit"),
            array("group_name" => "User", "name" => "user-delete"),
            //student master
            array("group_name" => "Student Master", "name" => "student-list"),
            array("group_name" => "Student Master", "name" => "student-create"),
            array("group_name" => "Student Master", "name" => "student-edit"),
            array("group_name" => "Student Master", "name" => "student-delete"),
            array("group_name" => "Student Master", "name" => "admission-request-list"),
            array("group_name" => "Student Master", "name" => "rejected-admission-list"),
            //academic year
            array("group_name" => "Academic Year", "name" => "academic-year-list"),
            array("group_name" => "Academic Year", "name" => "academic-year-create"),
            array("group_name" => "Academic Year", "name" => "academic-year-edit"),
            array("group_name" => "Academic Year", "name" => "academic-year-delete"),
            //course
            array("group_name" => "Course", "name" => "course-list"),
            array("group_name" => "Course", "name" => "course-create"),
            array("group_name" => "Course", "name" => "course-edit"),
            array("group_name" => "Course", "name" => "course-delete"),
            //group
            array("group_name" => "Group", "name" => "group-list"),
            array("group_name" => "Group", "name" => "group-create"),
            array("group_name" => "Group", "name" => "group-edit"),
            array("group_name" => "Group", "name" => "group-delete"),
            //semester
            array("group_name" => "Semester", "name" => "semester-list"),
            array("group_name" => "Semester", "name" => "semester-create"),
            array("group_name" => "Semester", "name" => "semester-edit"),
            array("group_name" => "Semester", "name" => "semester-delete"),
            //fees master
            array("group_name" => "Fees Master", "name" => "fees-master-list"),
            array("group_name" => "Fees Master", "name" => "fees-master-create"),
            array("group_name" => "Fees Master", "name" => "fees-master-edit"),
            array("group_name" => "Fees Master", "name" => "fees-master-delete"),
            //Paid Admission Fees
            array("group_name" => "Paid Admission Fees", "name" => "paid-admission-fees-list"),
            array("group_name" => "Paid Admission Fees", "name" => "paid-admission-fees-export"),

            //setting
            array("group_name" => "Setting", "name" => "setting-list"),
            array("group_name" => "Setting", "name" => "setting-create"),
            array("group_name" => "Setting", "name" => "setting-edit"),
            array("group_name" => "Setting", "name" => "setting-delete"),

            array("group_name" => "Transactions", "name" => "admission-fees-transactions-list"),
            array("group_name" => "Transactions", "name" => "admission-fees-transactions-export"),
            array("group_name" => "Transactions", "name" => "college-fees-transactions-list"),
            array("group_name" => "Transactions", "name" => "college-fees-transactions-export"),

            array("group_name" => "Reports", "name" => "student-list-enrolment-report-semester-and-group-wise"),
            array("group_name" => "Reports", "name" => "student-list-semester-report"),
            array("group_name" => "Reports", "name" => "consolidated-report"),
            array("group_name" => "Reports", "name" => "semester-and-group-fees-collection-report"),
            array("group_name" => "Reports", "name" => "semester-and-group-fees-collection-all-user-report"),
            array("group_name" => "Reports", "name" => "group-and-semester-wise-caste-report-all-student"),
            array("group_name" => "Reports", "name" => "group-and-semester-wise-caste-report-all-student-admitted-only"),
            array("group_name" => "Reports", "name" => "forfeit-report-1"),
            array("group_name" => "Reports", "name" => "due-fee"),
            array("group_name" => "Reports", "name" => "fee-head-degree-audit-report"),
            array("group_name" => "Reports", "name" => "fee-head-degree-audit-report-without-cancel"),
            //Admission Fees
            array("group_name" => "Admission Fees", "name" => "admission-fees-list"),
            array("group_name" => "Admission Fees", "name" => "admission-fees-create"),
            array("group_name" => "Admission Fees", "name" => "admission-fees-edit"),
            array("group_name" => "Admission Fees", "name" => "admission-fees-delete"),

            //College Fees
            array("group_name" => "College Fees", "name" => "college-fees-list"),
            array("group_name" => "College Fees", "name" => "college-fees-create"),
            array("group_name" => "College Fees", "name" => "college-fees-edit"),
            array("group_name" => "College Fees", "name" => "college-fees-delete"),

        ];


        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['guard_name' => 'admin', 'name' => $permission['name'], 'group_name' => $permission['group_name']]);
        }
    }
}
