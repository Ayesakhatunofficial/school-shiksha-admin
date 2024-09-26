<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\OrganizationBannerModel;

class OrganizationBannerController extends BaseController
{
    protected $OrganizationBannerModel;

    public function __construct()
    {
        // Load OrganizationBannerModel using dependency injection
        $this->OrganizationBannerModel = new OrganizationBannerModel();
    }
    public function organizationBanner($id = NULL)
    {
        $data['organization_banners'] = $this->OrganizationBannerModel->table('tbl_organization_banners')
            ->where('tbl_organization_banners.organization_id', $id)
            ->get()
            ->getResultArray();

        $data['organization_id'] = $id;

        return view(
            'organization/banner_view',
            $data
        );
    }

    public function editOrganizationBanner($id = NULL, $orgid = NULL)
    {
        $Organisationbanner = $this->OrganizationBannerModel->find($id);

        if (!$Organisationbanner) {
            return redirect()->to('organization/' . $orgid . '/banner')->with('error', 'Data not found.');
        }

        return view('organization/banner_edit', [
            'bannerOrg' => $Organisationbanner,
        ]);
    }


    public function addOrganizationBanner($id = NULL)
    {
        if ($this->request->getMethod() === 'POST') {
            $data = $this->request->getPost();
            $img = $this->request->getFile('banner_image');
            $data['banner_image'] = $img && $img->isValid() ? uploadFile($img) : "";
            if ($this->OrganizationBannerModel->insert($data)) {
                return redirect()->to('organization/' . $id . '/banner')->with('msg', 'Organization Banner inserted successfully!');
            } else {
                return redirect()->back()->with('error', 'Something went wrong !');
            }
        }
        return view('organization/banner_add', [
            'organization_id' => $id ?? "",
        ]);
    }

    public function update()
    {
        if ($this->request->getMethod() === 'POST') {
            $id = $this->request->getPost('hidden_id');
            $org_id = $this->request->getPost('org_id');
            $data = $this->request->getPost();
            $img = $this->request->getFile('banner_image');

            $img  && $img->isValid() ? $data['banner_image'] = uploadFile($img) : "";

            if ($this->OrganizationBannerModel->update($id, $data)) {
                return redirect()->to('organization/' . $org_id . '/banner')->with('msg', 'Organization Banner updated successfully!');
            } else {
                return redirect()->back()->with('error', 'Something went wrong !');
            }
        }
    }


    public function delete($id = NULL, $orgid = NULL)
    {

        $msg = 'Failed to delete record';

        $result = $this->OrganizationBannerModel->delete($id);

        if ($result) {
            $msg = 'Record deleted successfully';
        }

        return redirect()->to('organization/' . $orgid . '/banner')->with('msg', $msg);
    }
}
