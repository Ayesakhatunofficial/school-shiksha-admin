<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ServiceBannerModel;

class ServiceBannerController extends BaseController
{
    protected $ServiceBannerModel;
    protected $CourseModel;

    public function __construct()
    {
        // Load ServiceBannerModel using dependency injection
        $this->ServiceBannerModel = new ServiceBannerModel();
    }
    public function serviceBanner($id = NULL)
    {
        $data['service_banner'] = $this->ServiceBannerModel->table('tbl_service_banners')
            ->where('tbl_service_banners.service_id', $id)
            ->get()
            ->getResultArray();

        $data['service_id'] = $id;

        return view(
            'category/banner_view',
            $data
        );
    }

    public function editServiceBanner($id = NULL, $ser_id = NULL)
    {
        $ServiceCourse = $this->ServiceBannerModel->find($id);

        if (!$ServiceCourse) {
            return redirect()->to('service/' . $ser_id . '/banner')->with('error', 'Data not found.');
        }

        return view('category/banner_edit', [
            'bannerSer' => $ServiceCourse,
        ]);
    }


    public function addServiceBanner($id = NULL)
    {
        if ($this->request->getMethod() === 'POST') {
            $data = $this->request->getPost();
            $img = $this->request->getFile('banner_image');
            $data['banner_image'] = $img && $img->isValid() ? uploadFile($img) : "";
            if ($this->ServiceBannerModel->insert($data)) {
                return redirect()->to('service/' . $id . '/banner')->with('msg', 'Service Banner inserted successfully!');
            } else {
                return redirect()->back()->with('error', 'Something went wrong !');
            }
        }
        return view('category/banner_add', [
            'service_id' => $id ?? "",
        ]);
    }

    public function update()
    {
        if ($this->request->getMethod() === 'POST') {
            $id = $this->request->getPost('hidden_id');
            $ser_id = $this->request->getPost('ser_id');
            $data = $this->request->getPost();
            $img = $this->request->getFile('banner_image');

            $img  && $img->isValid() ? $data['banner_image'] = uploadFile($img) : "";

            if ($this->ServiceBannerModel->update($id, $data)) {
                return redirect()->to('service/' . $ser_id . '/banner')->with('msg', 'Service Banner updated successfully!');
            } else {
                return redirect()->back()->with('error', 'Something went wrong !');
            }
        }
    }


    public function delete($id = NULL, $ser_id = NULL)
    {

        $msg = 'Failed to delete record';

        $result = $this->ServiceBannerModel->delete($id);

        if ($result) {
            $msg = 'Record deleted successfully';
        }

        return redirect()->to('service/' . $ser_id . '/banner')->with('msg', $msg);
    }
}
