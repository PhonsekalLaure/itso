<?php
namespace App\Controllers;

class Products extends BaseController {
    public function index() {
        $productmodel = model('Products_model');

        $data = array(
            'title' => 'Products List',
            'products' => $productmodel->where('is_deleted', 0)->findAll()
        );

        return view('include\head_view', $data)
            .view('include\nav_view')
            .view('products_view', $data)
            .view('include\foot_view');
    }
    public function add(){
        $data = array(
            'title' => 'Add Product',
        );
        return view('include\head_view', $data)
            .view('include\nav_view')
            .view('products\add_view')
            .view('include\foot_view');
    }
    public function edit($id){
        $productmodel = model('Products_model');
        $data = array(
            'title' => 'Edit Product',
            'product' => $productmodel->find($id)
        );
        return view('include\head_view', $data)
            .view('include\nav_view')
            .view('products\edit_view', $data)
            .view('include\foot_view');
    }
    public function view($id){
        $productmodel = model('Products_model');
        $data = array(
            'title' => 'View Product',
            'product' => $productmodel->find($id)
        );
        return view('include\head_view', $data)
            .view('include\nav_view')
            .view('products\view_view', $data)
            .view('include\foot_view');
    }

    public function insert() {
        $productmodel = model('Products_model');

        $img = $this->request->getFile('image');
        $imageName = null;

        if ($img && $img->isValid() && !$img->hasMoved()) {
            $imageName = $img->getRandomName();
            $img->move(ROOTPATH . 'public/assets/images/products', $imageName);
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'price' => $this->request->getPost('price'),
            'description' => $this->request->getPost('description'),
            'image' => $imageName,
            'is_deleted' => 0,
        ];

        $productmodel->insert($data);
        return redirect()->to('/products');
    }

    public function update($id) {
        $productmodel = model('Products_model');
        $product = $productmodel->find($id);

        $img = $this->request->getFile('image');
        $imageName = $product['image']; // Keep old image if no new one is uploaded

        if ($img && $img->isValid() && !$img->hasMoved()) {
            // Delete the old image if it exists
            if ($product['image'] && file_exists(ROOTPATH . 'public/assets/images/products/' . $product['image'])) {
                unlink(ROOTPATH . 'public/assets/images/products/' . $product['image']);
            }

            // Upload the new image
            $imageName = $img->getRandomName();
            $img->move(ROOTPATH . 'public/assets/images/products', $imageName);
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'price' => $this->request->getPost('price'),
            'description' => $this->request->getPost('description'),
            'image' => $imageName,
        ];

        $productmodel->update($id, $data);

        return redirect()->to('/products');
    }

    public function delete($id) {
        $productmodel = model('Products_model');

        $data = [
            'is_deleted' => 1,
        ];

        $productmodel->update($id, $data);

        return redirect()->to('products');
    }
}
?>