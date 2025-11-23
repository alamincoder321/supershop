<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Blogs extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->brunch = $this->session->userdata('BRANCHid');
        $access = $this->session->userdata('userId');
        if ($access == '') {
            redirect("Login");
        }
        $this->load->model("Model_myclass", "mmc", TRUE);
        $this->load->model('Model_table', "mt", TRUE);
        $this->load->model('Billing_model');
    }
    public function index()
    {


        $access = $this->mt->userAccess();
        if (!$access) {
            redirect(base_url());
        }
        $data['title'] = "Blogs";
        $data['content'] = $this->load->view('Administrator/blogs/add_blog', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }



    public function addBlog()
    {

        return $this->updateBlog();

    }

    public function updateBlog()
    {
        $res = ['success' => false, 'message' => ''];
        try {
            $productObj = json_decode($this->input->post('data'));

            $product = (array) $productObj;
            if ($product['id'] == null || $product['id'] == '') {
                $product['created_at'] = date('Y-m-d H:i:s');
                unset($product['id']);
                $productId = $this->mt->save_data('blogs', $product);
            } else {
                $productId = $productObj->id;
                $product['updated_at'] = date('Y-m-d H:i:s');
                unset($product['id']);

            }



            $this->db->where('id', $productObj->id)->update('blogs', $product);

            if (!empty($_FILES['image'])) {
                $oldImage = $this->db->query("select upload_id from blogs where id = ?", $productId)->row()->upload_id;

                $config['upload_path'] = './uploads/blogs/';
                $config['allowed_types'] = '*';

                $imageName = trim($productId) . time();

                $config['file_name'] = $imageName;
                $this->load->library('upload', $config);

                if ($this->upload->do_upload('image')) {

                    $uploadData = $this->upload->data();
                    $imageName = $uploadData['file_name'];
                    $this->db->query("update blogs set upload_id = ? where id = ?", [$imageName, $productId]);
                    if (file_exists('./uploads/blogs/' . $oldImage) && $oldImage != null && $oldImage != '') {
                        unlink('./uploads/blogs/' . $oldImage);
                    }
                }
            }
            if ($productObj->id == null || $productObj->id == '') {
                $res = ['success' => true, 'message' => 'Blog added successfully'];
            } else {
                $res = ['success' => true, 'message' => 'Blog updated successfully'];
            }

        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }
    public function deleteBlog()
    {
        $res = ['success' => false, 'message' => ''];
        try {
            $data = json_decode($this->input->raw_input_stream);

            $this->db->query("delete from blogs where id = ?", $data->blogId);

            $res = ['success' => true, 'message' => 'Product deleted successfully'];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }


    public function getBlogs()
    {
        $data = json_decode($this->input->raw_input_stream);

        $clauses = "";
        $limit = "";

        if (isset($data->forSearch) && $data->forSearch != '') {
            $limit .= "limit 20";
        }
        if (isset($data->name) && $data->name != '') {
            $clauses .= " and (b.title like '$data->name%' or b.short_description like '$data->name%')";
        }

        $products = $this->db->query(" select * from blogs as b where 1 = 1  $clauses order by id desc $limit")->result();
        echo json_encode($products);
    }



}
