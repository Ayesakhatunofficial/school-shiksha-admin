<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\BannerModel;

class BannerController extends BaseController
{
    protected $BannerModel;

    public function __construct()
    {
        $this->BannerModel = new BannerModel();
    }
    public function banner()
    {
        $data['banner'] = $this->BannerModel
            ->join('tbl_banner_types', 'tbl_banner_types.id = tbl_banners.type_id', 'inner')
            ->select('tbl_banner_types.type, tbl_banners.*')
            ->orderBy('tbl_banners.id', 'DESC')
            ->get()
            ->getResultArray();
        return view(
            'banner/view',
            $data
        );
    }

    public function editBanner($id = NULL)
    {
        if ($id === NULL || !is_numeric($id)) {
            return redirect()->to('banner')->with('error', 'Invalid Banner ID.');
        }

        $banner = $this->BannerModel->find($id);

        if (!$banner) {
            return redirect()->to('banner')->with('error', 'Banner not found.');
        }
        return view('banner/edit', [
            'banner' => $banner,
            'type' => $this->BannerModel->fetchTypes()
        ]);
    }


    public function addBanner()
    {
        if ($this->request->getMethod() === 'POST') {
            $data = $this->request->getPost();
            $img = $this->request->getFile('image');
            $data['image'] = $img && $img->isValid() ? uploadFile($img) : "";
            if ($this->BannerModel->insert($data)) {
                return redirect()->to('banner')->with('msg', 'Banner inserted successfully!');
            } else {
                return redirect()->back()->with('error', 'Something went wrong !');
            }
        }
        return view('banner/add', ['roles' => $this->BannerModel->fetchTypes()]);
    }

    public function update()
    {
        if ($this->request->getMethod() === 'POST') {
            $id = $this->request->getPost('hidden_id');
            $img = $this->request->getFile('banner');
            $data = $this->request->getPost();

            $img  && $img->isValid() ? $data['banner'] = uploadFile($img) : "";

            if ($this->BannerModel->update($id, $data)) {
                return redirect()->to('banner')->with('msg', 'Banner updated successfully!');
            } else {
                return redirect()->back()->with('error', 'Something went wrong !');
            }
        }

        return view('banner/edit');
    }


    public function delete($id)
    {

        $msg = 'Failed to delete record';

        $result = $this->BannerModel->delete($id);

        if ($result) {
            $msg = 'Record deleted successfully';
        }

        return redirect()->to('banner')->with('msg', $msg);
    }
}
