<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\OrganisationCourseModel;
use App\Models\CourseModel;

class OrganisationCourseController extends BaseController
{
    protected $OrganisationCourseModel;
    protected $CourseModel;

    public function __construct()
    {
        // Load OrganisationCourseModel using dependency injection
        $this->OrganisationCourseModel = new OrganisationCourseModel();
        $this->CourseModel = new CourseModel();
    }
    public function organizationCourse($id = NULL)
    {
        $data['organization_course'] = $this->OrganisationCourseModel->table('tbl_organizations_course')
            ->join('tbl_courses', 'tbl_courses.id = tbl_organizations_course.course_id', 'inner')
            ->join('tbl_organizations', 'tbl_organizations.id = tbl_organizations_course.organization_id', 'inner')
            ->select('tbl_courses.id AS courses_id, tbl_courses.name as courses_name ,tbl_organizations.id AS organization_id, tbl_organizations.name as organization_name , tbl_organizations_course.course_fees, tbl_organizations_course.id, tbl_organizations_course.last_submission_date,tbl_organizations_course.register_through')
            ->where('tbl_organizations_course.organization_id', $id)
            ->orderBy('tbl_organizations_course.id', 'DESC')
            ->get()
            ->getResultArray();

        $data['organization_id'] = $id;

        return view(
            'organization_course/view',
            $data
        );
    }

    public function editOrganizationCourse($id = NULL, $orgid = NULL)
    {
        $OrganisationCourse = $this->OrganisationCourseModel->find($id);

        if (!$OrganisationCourse) {
            return redirect()->to('organization/' . $orgid . '/course')->with('error', 'Data not found.');
        }

        $course = $this->CourseModel->getData();
        return view('organization_course/edit', [
            'courseOrg' => $OrganisationCourse,
            'course' => $course,
        ]);
    }


    public function addOrganizationCourse($id = NULL)
    {

        if ($this->request->getMethod() === 'POST') {
            $data = $this->request->getPost();
            // $resultArray = [];

            if (isset($data['keys']) && isset($data['values']) && is_array($data['keys']) && is_array($data['values'])) {
                foreach ($data['keys'] as $index => $key) {
                    if (isset($key) && $key != '' && isset($data['values'][$index])) {
                        $resultArray[$key] = $data['values'][$index];
                    }
                }
            }

            $data['extra_data'] = !empty($resultArray) ? json_encode($resultArray) : NULL;
            $call = [
                'is_call_required' => $this->request->getVar('call')
            ];

            $data['required_field'] = json_encode($call);

            // print_r($data); die;
            $check = $this->OrganisationCourseModel->where('organization_id', $id)->where('course_id', $data['course_id'])->first();
            if (!empty($check)) {
                return redirect()->back()->with('error', 'Course already Exist for this Organization!');
            }
            if ($this->OrganisationCourseModel->insert($data)) {
                return redirect()->to('organization/' . $id . '/course')->with('msg', 'Organization Course inserted successfully!');
            } else {
                return redirect()->back()->with('error', 'Something went wrong !');
            }
        }
        return view('organization_course/add', [
            'organization_id' => $id ?? "",
            'course' => $this->CourseModel->getData()
        ]);
    }

    public function update()
    {
        if ($this->request->getMethod() === 'POST') {
            $id = $this->request->getPost('hidden_id');
            $org_id = $this->request->getPost('org_id');
            $data = $this->request->getPost();
            $data['register_through'] == 'internal_form_submit' ? $data['url'] = null : "";
            // Initialize resultArray
            $resultArray = [];

            if (isset($data['keys']) && isset($data['values'])) {
                foreach ($data['keys'] as $index => $key) {
                    if (isset($key) && $key != '') {
                        $resultArray[$key] = $data['values'][$index];
                    }
                }
            }

            // Convert extra data to JSON
            $data['extra_data'] = !empty($resultArray) ? json_encode($resultArray) : NULL;

            $call = [
                'is_call_required' => $this->request->getVar('call')
            ];

            $data['required_field'] = json_encode($call);

            $check = $this->OrganisationCourseModel->where('id !=', $id)->where('organization_id', $org_id)->where('course_id', $data['course_id'])->first();
            if (!empty($check)) {
                return redirect()->back()->with('error', 'Course already Exist for Organization!');
            }
            if ($this->OrganisationCourseModel->update($id, $data)) {
                return redirect()->to('organization/' . $org_id . '/course')->with('msg', 'Organization Course updated successfully!');
            } else {
                return redirect()->back()->with('error', 'Something went wrong !');
            }
        }
    }


    public function delete($id = NULL, $orgid = NULL)
    {

        $msg = 'Failed to delete record';

        $result = $this->OrganisationCourseModel->delete($id);

        if ($result) {
            $msg = 'Record deleted successfully';
        }

        return redirect()->to('organization/' . $orgid . '/course')->with('msg', $msg);
    }
}
