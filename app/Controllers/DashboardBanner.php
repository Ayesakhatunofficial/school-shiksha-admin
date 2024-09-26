<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\DashboardBannerModel;

class DashboardBanner extends BaseController
{
    protected $BannerModel;

    public function __construct()
    {
        $this->BannerModel = new DashboardBannerModel();
    }
    public function dashboardBanner()
    {
        $data['banner'] = $this->BannerModel
            ->join('tbl_roles', 'tbl_roles.id = tbl_dashboard_banners.role_id', 'inner')
            ->select('tbl_roles.role_name, tbl_dashboard_banners.*')
            ->orderBy('tbl_dashboard_banners.id', 'DESC')
            ->get()
            ->getResultArray();
        return view(
            'dashboardbanner/view',
            $data
        );
    }

    public function editDashboardBanner($id = NULL)
    {
        if ($id === NULL || !is_numeric($id)) {
            return redirect()->to('dashboard/banner')->with('error', 'Invalid Banner ID.');
        }

        $banner = $this->BannerModel->find($id);

        if (!$banner) {
            return redirect()->to('dashboard/banner')->with('error', 'Banner not found.');
        }
        return view('dashboardbanner/edit', [
            'banner' => $banner,
            'roles' => $this->BannerModel->fetchRoles()
        ]);
    }


    public function addDashboardBanner()
    {
        if ($this->request->getMethod() === 'POST') {
            $data = $this->request->getPost();
            $img = $this->request->getFile('banner');
            $data['banner'] = $img && $img->isValid() ? uploadFile($img) : "";
            if ($this->BannerModel->insert($data)) {
                return redirect()->to('dashboard/banner')->with('msg', 'Banner inserted successfully!');
            } else {
                return redirect()->back()->with('error', 'Something went wrong !');
            }
        }
        return view('dashboardbanner/add', ['roles' => $this->BannerModel->fetchRoles()]);
    }

    public function update()
    {
        if ($this->request->getMethod() === 'POST') {
            $id = $this->request->getPost('hidden_id');
            $img = $this->request->getFile('banner');
            $data = $this->request->getPost();

            $img  && $img->isValid() ? $data['banner'] = uploadFile($img) : "";

            if ($this->BannerModel->update($id, $data)) {
                return redirect()->to('dashboard/banner')->with('msg', 'Banner updated successfully!');
            } else {
                return redirect()->back()->with('error', 'Something went wrong !');
            }
        }

        return view('dashboardbanner/edit');
    }


    public function delete($id)
    {

        $msg = 'Failed to delete record';

        $result = $this->BannerModel->delete($id);

        if ($result) {
            $msg = 'Record deleted successfully';
        }

        return redirect()->to('dashboard/banner')->with('msg', $msg);
    }
}
