<?php

class JsonHandler {
    private $connection;
    private $query;

    public function __construct($h,$u,$p,$db){
        $this->connection = mysqli_connect($h, $u, $p, $db);
        $this->connection->set_charset("utf8");
        $this->history = array();
    }

    public function getJson($table,$data = "*",$join = "",$where = "",$order){
        $this->query = "SELECT $data FROM $table $join $where $order";
        $stmt = $this->connection->query($this->query);
        $json = array();
        while($row = $stmt->fetch_assoc()){
            array_push($json,$row);
        }
        //array_push($this->history,$json);
        return json_encode($json);
    }

    public function get_category($id_parent,$lang){
        $this->query = "SELECT id_category as id, name_category as title from category where id_parent = '$id_parent'";
        $stmt = $this->connection->query($this->query);
        $json = array();
        $cats = array();

        while ($row = $stmt->fetch_assoc()) {
            array_push($cats,$row);
        }

        $this->query = "SELECT id_category as id, name_category as title from category where id_category = '$id_parent'";
        $stmt = $this->connection->query($this->query);
        $original = $stmt->fetch_row();

        if($id_parent == '0'){
            $json[] = array("category" => $cats);
        }else{
            $this->query = "SELECT efficiency, baleni as volume, davkovani as davkovani, interval_ as 'interval', material,
            DESCRIPTION as description,IMGURL as image,id_product as id,ITEM_ID as idd,PRODUCTNAME as title,PRICE_VAT as price,IMGURL_ALTERNATIVE as alternative
            from products
            left join category_product using(id_product)
            left join category using(id_category)
            where category.id_category = '$id_parent'";
            $query = $this->connection->query($this->query);

            $pom = [];
            if ($query->num_rows > 0) {
                while ($row = $query->fetch_assoc()) {
                    $mat = "SELECT shotcut FROM units where id_unit = '".$row['material']."'";
                    $mat = $this->connection->query($mat);
                    $res = $mat->fetch_row();

                    $matros = ($row['material'] == 'ks') ? 'tablets' : (($row['material']=='l') ? 'liquid' : 'powder');

                    $alt = explode("|",$row['alternative']);
                    array_unshift($alt,$row['image']);
                    $pom[] = array(
                        'id'=>$row['idd']
                    ,'name'=>$row['title']
                    ,'price'=>$row['price']
                    ,'image'=>$alt
                    ,'description'=>$row['description']
                    ,'material'=>$matros
                    ,'volume'=>(($matros == 'tablets' || $matros == 'powder') ? $row['volume'] : $row['volume']/1000)
                    ,'usage'=>array('volume'=>$row['davkovani'],'interval'=>$row['interval'],'efficiency'=>$row['efficiency'])
                    );
                }
            }

            $json[] = array("id" => $original[0],"title"=>$original[1],"category" => $cats,"products"=>$pom);
        }

        return json_encode($json);
    }

    public function get_problems($lang = 'en'){
        $this->query = "SELECT id_problem,pool,whirlpool,chlorine, header, content from problem left join translations USING(id_problem) WHERE lang='$lang'";
        $stmt = $this->connection->query($this->query);
        $json = array();

        while ($row = $stmt->fetch_assoc()) {
            $targets = array();
            if($row['pool'] == '1'){
                array_push($targets,'pool');
            }
            if($row['whirlpool'] == '1'){
                array_push($targets,'whirlpool');
            }
            $category = "SELECT id_category as id from problem_category left join category using(id_category) WHERE id_problem = $row[id_problem]";
            $category = $this->connection->query($category);
            $cats = array();
            while($cat = $category->fetch_row()){
                array_push($cats,$cat[0]);
            }
            $json[] = array(
                'id' => $row['id_problem'],
                'targets' => $targets,
                'title' => $row['header'],
                'description' => $row['content'],
                'category' => $cats,
                'chlorine' => $row['chlorine']
            );
        }
        return json_encode($json);
    }
} 
