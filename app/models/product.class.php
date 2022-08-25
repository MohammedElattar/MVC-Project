<?php

class Product
{
    /**
     * Category Class
     *
     * Controll operation done on categories
     * 
     */
    private $db;
    function __construct()
    {
        $this->db = db::get_instance();
    }
    public function add(array $data, array $FILES)
    {
        /**
         * Add Function which add a new category
         * 
         * @param array $data Which have the name of the cateory to be inserted
         * 
         * @param array $FILES which contains uploaded files like images , etc
         * 
         * @return array $res Results of inserting operation
         * 
         */

        $res = [];

        $product_name = htmlspecialchars(trim($data['name']));
        $description = htmlspecialchars(trim($data['name']));
        $quantity = $data['quantity'];
        $price = $data['price'];
        $category_id = $data['category_id'];

        // photos

        $photos_keys = array_keys($FILES);


        if (!$product_name || !preg_match("/^[a-zA-Z]+$/", $product_name))
            $res['name'] = '1';
        if (!$description)
            $res['description'] = '1';
        if ($quantity <= 0)
            $res['quantity'] = '1';
        if ($price <= 0)
            $res['price'] = '1';

        // Handling Photos :(

        if (isset($FILES['main_image']['name']) && $FILES['main_image']['name']) {

            $main_image_name = $FILES['main_image']['name'];
            $allowed_extensions = ['jpg', 'jpeg', 'png'];
            $main_image_extension = explode(".", $main_image_name)[1];

            if (!is_numeric(array_search($main_image_extension, $allowed_extensions)))
                $res['main-image-extension'] = '1';
            for ($i = 1; $i < count($photos_keys); $i++) {
                if ($i == 4)
                    break;
                if ($FILES[$photos_keys[$i]]['error']) {
                    if (!isset($res['image-error']))
                        $res['image-error'] = '';
                    $res['image-error'] .= "photo_$photos_keys[$i] ";
                }
                else {
                    if ($FILES[$photos_keys[$i]]['size'] > 4194304) {
                        if (!isset($res['image-size']))
                            $res['image-size'] = '';
                        $res['image-size'] .= "photo_$photos_keys[$i] ";
                    }
                    if (is_numeric(array_search(explode(".", $FILES[$photos_keys[$i]]['name'][1]), $allowed_extensions))) {
                        if (!isset($res['valid-image']))
                            $res['valid-image'] = '';
                        $res['valid-image'] .= "photo_$photos_keys[$i] ";
                    }
                }
            }
        }
        else
            $res['main-image'] = '1';

        if (!$res) {

            // upload images first 

            $main_image_name = '';
            for ($i = 0; $i < count($FILES); $i++) {
                $tmp_name = $FILES[$photos_keys[$i]]['tmp_name'];
                $name = explode(".", $FILES[$photos_keys[$i]]['name']);
                $src = $name[0];
                $src = rand(1, 1e10) . $src . rand(1, 1e10);
                $name = $src . "." . $name[1];
                move_uploaded_file($tmp_name, "../public/uploads/$name");
                $photos_keys[$i] = $name;
            }
            $main_image = $photos_keys[0];
            unset($photos_keys[0]);

            $this->db->write(
                "INSERT INTO
                    products
                    (name , description , userid , category_id , quantity , price , main_image , other_images)
                VALUES 
                    (?,?,?,?,?,?,?,?)",
            [$product_name, $description, $_SESSION['data']['id'], $category_id, $quantity, $price, $main_image, json_encode($photos_keys)]
            );
            $str = '';
            foreach ($this->show() as $i) {
                $str .= sprintf(
                    '<tr node-%s>
                                <td>%s</td>
                                <td>%s</td>
                                <td>%s</td>
                                <td>%s</td>
                                <td>%s</td>
                                <td>%s</td>
                                <td class="text-center">
                                    <a href="%sajax/products/edit_info" class="btn btn-primary btn-xs edit" id="%s" onclick="editProductInfo(event)"><i class="fa fa-edit"></i></a>
                                    <a href="%sajax/products/delete" class="btn btn-danger btn-xs delete" id="%s" onclick="deleteProduct(event)"><i class="fa fa-trash-o "></i></a>
                                </td>
                            </tr>
                    ',
                    $i['id'],
                    $i['name'],
                    $i['quantity'],
                    $i['price'],
                    sprintf("<img src='%s' style='width:100px ; height:50px'>", ROOT . "uploads/" . $i['main_image']),
                    $i['cat_name'],
                    sprintf(
                    "<a href='%s' class='btn %s status' data-id='%s' onclick='editProductStatus(event)'>%s</a>",

                    ROOT . "ajax/categories/edit_status",
                    $i['status'] == 0 ? "btn-primary" : ($i['status'] == 1 ? "btn-success" : "btn-danger"),
                    $i['id'],
                    $i['status'] == 0 ? "Normal" : ($i['status'] == 1 ? "Sale" : "New"),
                ),
                    ROOT,
                    $i['id'],
                    ROOT,
                    $i['id']
                );
            }
        }
        $res['success'] = '1';
        $res['product'] = $str;
        return $res;
    }
    public function edit_status(array $data)
    {
        /** 
         * Edit Status Function is used to edit Category Status
         *
         * @param array $data Which Have 2 properties [Status , id]
         * 
         * @return array $res The Result of editing category Status
         */

        $this->db->write("UPDATE categories set `disabled`=? WHERE id=?", [$data['status'], $data['id']]);
        $res = [];
        $res['data'] = $this->show();
        $res['success'] = '1';
        return $res;
    }
    public function edit_name(array $data)
    {
        /**
         * Edit Name Function
         * 
         * This function is used to edit category name
         * 
         * @param array $data Which have 2 properties [$name , $id]
         * 
         * @return array $res Results of editing operation
         */

        $res = [];
        $name = trim($data['name']);
        $id = $data['id'];
        if (!$name || !preg_match("/^[a-zA-Z]+$/", $name))
            $res['valid-name'] = '1';
        if (!$res) {
            if ($this->db->read("SELECT name FROM categories WHERE name=? AND id != ?", [$name, $id])[0])
                $res['exists'] = '1';
            else {
                $this->db->write("UPDATE categories SET name=? WHERE id =?", [$name, $id]);
                $res['success'] = '1';
                $res['data'] = $this->show();
            }
        }
        $res = json_encode($res);
        return $res;
    }
    public function delete(array $data)
    {
        $res = $this->db->remove("SELECT id FROM categories WHERE id=?", [$data['id']], "DELETE FROM categories WHERE id=?", [$data['id']]);
        $res['data'] = $this->show();
        $res = json_encode($res);
        echo $res;
    }
    public function show(string $query = "SELECT products.* , categories.name as cat_name FROM products JOIN categories ON categories.id=products.category_id", array $executeData = [])
    {
        /**
         * Show Products Function is used to show cateogires
         */
        $res = $this->db->read($query, $executeData, true)[0];
        if ($executeData) {
            return $res[0];
        }
        return $res;
    }
}
