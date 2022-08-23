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
        $res = [];

        if (!$name || !preg_match("/^[a-zA-Z]+$/", $name)) $res['name'] = '1';
        if (!$res) {
            if ($this->db->read('SELECT id FROM categories WHERE name=?', [$name])[0]) $res['exists'] = '1';
            else {
                $this->db->write("INSERT INTO categories (name) VALUES (?)", [$name]);
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
        $id = $data['id'];
        if (!$name || !preg_match("/^[a-zA-Z]+$/", $name)) $res['valid-name'] = '1';
        if (!$res) {
            if ($this->db->read("SELECT name FROM categories WHERE name=? AND id != ?", [$name, $id])[0]) $res['exists'] = '1';
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
    public function show(string $query = "SELECT * FROM Categories", array $executeData = [])
    {
        $res  =  $this->db->read($query, $executeData, true)[0];
        if ($executeData) {
            return $res[0];
        }
        $str = '';
        foreach ($res as $i) {
            $str .= sprintf(
                '<tr id=node-%s>
                                <td><a href="basic_table.html#">%s</a></td>
                                <td class="text-center">%s</td>
                                <td class="text-center">
                                    <a href="%sajax/categories/edit_name" class="btn btn-primary btn-xs edit" id="%s" onclick="editCategoryName(event)"><i class="fa fa-edit"></i></a>
                                    <a href="%sajax/categories/delete" class="btn btn-danger btn-xs delete" id="%s" onclick="deleteCategory(event)"><i class="fa fa-trash-o "></i></a>
                                </td>
                            </tr>
                    ',
                $i['id'],
                $i['name'],
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
