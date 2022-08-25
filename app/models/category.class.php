<?php

class Category
{
    /**
     * Category Class
     *
     *   Controll operation done on categories
     * 
     */
    private $db;
    function __construct()
    {
        $this->db = db::get_instance();
    }
    public function add(array $data)
    {
        /**
         * Add Function which add a new category
         * 
         * @param array $data Which have the name of the cateory to be inserted
         * 
         * @return array $res Results of inserting operation
         * 
         */
        $name = trim($data['name']);
        $category_id = $data['sub_category'];
        $res = [];

        if (!$name || !preg_match("/^[a-zA-Z]+$/", $name))
            $res['name'] = '1';
        if (!$res) {
            if ($this->db->read('SELECT id FROM categories WHERE name=?', [$name])[0])
                $res['exists'] = '1';
            else {
                $this->db->write("INSERT INTO categories (name , sub_category_of) VALUES (?,?)", [$name, $category_id]);
                $res['success'] = '1';
                $res['category'] = $this->show();
            }
        }
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
        $category_id = $data['sub_category'];
        $id = $data['id'];
        if (!$name || !preg_match("/^[a-zA-Z]+$/", $name))
            $res['valid-name'] = '1';
        if (!$res) {
            if ($this->db->read("SELECT name FROM categories WHERE name=? AND id != ?", [$name, $id])[0])
                $res['exists'] = '1';
            else {
                $this->db->write("UPDATE categories SET name=? , sub_category_of=? WHERE id =?", [$name, $category_id, $id]);
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
    public function show(string $query = "SELECT * FROM Categories", array $executeData = [], bool $return_original_data = false)
    {
        $res = $this->db->read($query, $executeData, true)[0];

        if ($return_original_data)
            return $res;
        $str = '';
        foreach ($res as $i) {
            $sub_category = $this->db->read("SELECT name FROM categories WHERE id =? LIMIT 1", [$i['sub_category_of']], true);
            $sub_category = isset($sub_category[0][0]['name']) ? $sub_category[0][0]['name'] : "Main Category";
            $str .= sprintf(
                '<tr id=node-%s>
                                <td><a href="basic_table.html#">%s</a></td>
                                <td>%s</td>
                                <td class="text-center">%s</td>
                                <td class="text-center">
                                    <a href="%sajax/categories/edit_name" class="btn btn-primary btn-xs edit" id="%s" onclick="editCategoryName(event)"><i class="fa fa-edit"></i></a>
                                    <a href="%sajax/categories/delete" class="btn btn-danger btn-xs delete" id="%s" onclick="deleteCategory(event)"><i class="fa fa-trash-o "></i></a>
                                </td>
                            </tr>
                    ',
                $i['id'],
                $i['name'],
                $sub_category,
                sprintf($i['disabled'] ? "<a href='%s' class='btn btn-danger status' data-id='%s' onclick='editCategoryStatus(event)'>Disabled</a>" : "<a href='%s' class='btn btn-success status' data-id='%s' onclick='editCategoryStatus(event)'>Enabled</a>", ROOT . "ajax/categories/edit_status", $i['id']),
                ROOT,
                $i['id'],
                ROOT,
                $i['id'],
                ROOT,
                $i['id']
            );
        }
        return $str;
    }
}
