#!/bin/bash
# CICRUD 0.1 By Vladimir Grubor (grubor@gmail.com)
# 2008.12.08
# Usage: cicrud.sh [CodeIgniter folder] [table name] [fields (field1 field2 field3...)]
# ./cicrud.sh /home/vlado/web/ci test username email password status
#  or if your application folder is in system ./cicrud.sh /home/vlado/web/ci/system test username email password status
# Script will generate in this case modtest.php model
# If modtest.php existing this script will overwrite it. So...
# cat file | xargs ./cicrud.sh /home/vlado/web/CodeIgniter test

#Configuration
AUTHOR="Vladimir Grubor (grubor@gmail.com)"
DATE=$(date '+%d.%m.%Y %R')
#
FOLDER=$1
if [ ! -x $FOLDER ]; then  
    echo 'Error: wrong directory name. Use ./cicrud dirname table field1 field2...'; exit 1
fi
TABLE=$2
MODELNAME="mod$TABLE"
MODEL="$FOLDER/application/models/$MODELNAME.php"
echo "Starting CI-Bash CRUD $DATE"
echo "Table: $TABLE CI Folder: $FOLDER"

#Creating model
echo "<?php if (!defined('BASEPATH')) exit('No direct script access allowed');" > $MODEL
echo "/**
 * $TABLE model
 *
 * @author $AUTHOR
 * @date $DATE
 */" >> $MODEL
echo "class mod$TABLE extends Model {" >> $MODEL
echo '' >> $MODEL
echo '    var $id;' >> $MODEL

for thing in "$@"
do
    if [ ${thing} != $FOLDER ] && [ ${thing} != $TABLE ] ; then 
        echo "    var $"${thing}";" >> $MODEL
    fi
done

echo '' >> $MODEL
echo '    var $select;' >> $MODEL
echo '    var $limit;' >> $MODEL
echo '    var $limit2;' >> $MODEL
echo '    var $order;' >> $MODEL

#GET Function
echo '' >> $MODEL
echo "    function $MODELNAME(){
         parent::Model();
    }">>$MODEL
echo '' >> $MODEL
echo "    /**
    * Return filtered $TABLE
    *
    * @access public
    * @param void
    * @return $TABLE
    */" >> $MODEL
echo '    function get(){' >> $MODEL
for thing in "$@"
do
    if [ ${thing} != $FOLDER ] && [ ${thing} != $TABLE ]; then
        echo "        if (\$this->"${thing}") \$this->db->where('${thing}',\$this->${thing});" >> $MODEL
    fi
done
echo '        if ($this->select) $this->db->select($this->select);' >> $MODEL
echo '        if ($this->limit) $this->db->limit($this->limit);' >> $MODEL
echo '        if ($this->limit2) $this->db->limit($this->limit,$this->limit2);' >> $MODEL
echo '        if ($this->order) $this->db->order_by($this->order);' >> $MODEL
echo "        \$kveri = \$this->db->get('$TABLE');" >> $MODEL
echo '        if ($this->id) return $kveri->row();' >> $MODEL
echo '        else return $kveri->result();' >> $MODEL
echo '    }' >> $MODEL
echo '' >> $MODEL
echo '    // --------------------------------------------------------------------' >> $MODEL
echo '' >> $MODEL


#SAVE Function
echo "    /**
    * Save $TABLE
    *
    * @access public
    * @param void
    * @return integer
    */" >> $MODEL
echo '    function save(){' >> $MODEL
for thing in "$@"
do
    if [ ${thing} != $FOLDER ] && [ ${thing} != $TABLE ]; then
        echo "        if (\$this->"${thing}") \$this->db->set('${thing}',\$this->${thing});" >> $MODEL
    fi
done

echo '        if ($this->id) {' >> $MODEL
echo "            \$this->db->where('id',\$this->id);" >> $MODEL
echo "            \$this->db->update('$TABLE');" >> $MODEL
echo "            return \$this->id;" >> $MODEL
echo '        }' >> $MODEL
echo '        else {' >> $MODEL
echo "            \$this->db->update('$TABLE');" >> $MODEL
echo '            return $this->db->insert_id();' >> $MODEL
echo '        }' >> $MODEL
echo '    }' >> $MODEL
echo '' >> $MODEL
echo '    // --------------------------------------------------------------------' >> $MODEL
echo '' >> $MODEL

#DELETE
echo "    /**
    * Delete row from $TABLE
    *
    * @access public
    * @param integer
    * @return void
    */" >> $MODEL
echo '    function del($id){' >> $MODEL
echo '        $this->db->where('id',$id);' >> $MODEL
echo '        $this->db->limit(1);' >> $MODEL
echo "        \$this->db->delete('$TABLE')" >> $MODEL
echo '    }' >> $MODEL
echo '' >> $MODEL

#Finishing model
echo '}' >> $MODEL
#echo '?>' >> $MODEL
echo "/* End of file $MODELNAME.php */" >> $MODEL
echo "/* Location: ./application/models/$MODELNAME.php */" >> $MODEL 
cicrud.php
#!/usr/bin/php -q
<?
# CICrud 0.1
# Author Vladimir Grubor (grubor@gmail.com)
# Use ./cicrud.php  [(m)odel|(c)ontroller|(v)iew|(a)ll] [CI project folder] [table] [fields]
# or php cicrud.php  [(m)odel|(c)ontroller|(v)iew|(a)ll] [CI project folder] [table] [fields]
# cat textfile | xargs ./cicrud.php  [(m)odel|(c)ontroller|(v)iew|(a)ll] [CI project folder] [table] 
# Script will overwrite existing file....

#Configuration

$author = 'Vladimir Grubor (grubor@gmail.com)';
$cifolder = 'application/'; // or 'system/application/'
$date = date('d.m.Y H:i'); // Date time format

#Parms
$mvc = $_SERVER['argv'][1];
$folder = $_SERVER['argv'][2];
$folder = $folder.$cifolder;
$table = $_SERVER['argv'][3];


function model()
{
    global $folder,$table,$author,$date;
    $modelname = 'mod'.$table.'.php';
    $model = $folder.'/models/'.$modelname;
    echo "Generating model...\n";
    $fp = fopen($model, 'w');
    fwrite($fp, "<?php if (!defined('BASEPATH')) exit('No direct script access allowed');\n");
    fwrite($fp, "/**\n");
    fwrite($fp, "* $table model\n");
    fwrite($fp, "*\n");
    fwrite($fp, "* @author $author\n");
    fwrite($fp, "* @date $date\n");
    fwrite($fp, "*/\n");
    fwrite($fp, "class mod$table extends Model {\n");
    fwrite($fp, '    var $id'.";\n");
    for($i=4;$i<count($_SERVER['argv']);$i++)
    {
        fwrite($fp, '    var $'.$_SERVER['argv'][$i].";\n");
    }
    fwrite($fp, "\n");
    fwrite($fp, '    var $select'.";\n");
    fwrite($fp, '    var $order'.";\n");
    fwrite($fp, '    var $limit'.";\n");
    fwrite($fp, '    var $limit2'.";\n");
    fwrite($fp, "\n");
    fwrite($fp, "    function mod$table(){\n");
    fwrite($fp, "        parent::Model();\n");
    fwrite($fp, "    }\n\n");
    fwrite($fp, "    // --------------------------------------------------------------------\n\n");
    fwrite($fp,"    /**
    * Get rows from $table
    *
    * @access public
    * @param none
    * @return object
    */\n" );
    fwrite($fp, "    function get(){\n");
    fwrite($fp, "        if (\$this->id) \$this->db->where('id',\$this->id);\n");
    for($i=4;$i<count($_SERVER['argv']);$i++)
    {
        $var = $_SERVER['argv'][$i];
        fwrite($fp, "        if (\$this->$var) \$this->db->where('$var',\$this->$var);\n");
    }
    fwrite($fp, "        if (\$this->select) \$this->db->select(\$this->select);\n");
    fwrite($fp, "        if (\$this->order) \$this->db->order_by(\$this->order);\n");
    fwrite($fp, "        if (\$this->limit) \$this->db->limit(\$this->limit);\n");
    fwrite($fp, "        if (\$this->limit2) \$this->db->limit(\$this->limit,\$this->limit2);\n");
    fwrite($fp, "        \$query = \$this->db->get('$table');\n");
    fwrite($fp, "        if (\$this->id) return \$query->row();\n");
    fwrite($fp, "        else return \$query->result();\n");
    fwrite($fp, "    }\n\n");
    fwrite($fp, "    // --------------------------------------------------------------------\n\n");
    fwrite($fp,"    /**
    * Update or insert to $table
    *
    * @access public
    * @param none
    * @return integer
    */\n" );
    fwrite($fp, "    function save(){\n");
    for($i=4;$i<count($_SERVER['argv']);$i++)
    {
        $var = $_SERVER['argv'][$i];
        fwrite($fp, "        if (\$this->$var) \$this->db->set('$var',\$this->$var);\n");
    }
    fwrite($fp, "        if (\$this->id)\n        {\n");
    fwrite($fp, "            \$this->db->where('id',\$this->id);\n");
    fwrite($fp, "            \$this->db->update('$table');\n");
    fwrite($fp, "            return \$this->id;\n");
    fwrite($fp, "        }\n");
    fwrite($fp, "        else\n        {\n");
    fwrite($fp, "            \$this->db->insert('$table');\n");
    fwrite($fp, "            return \$this->db->insert_id();\n");
    fwrite($fp, "        }\n");
    fwrite($fp, "    }\n\n");
    fwrite($fp, "    // --------------------------------------------------------------------\n\n");
    fwrite($fp,"    /**
    * Delete row from $table
    *
    * @access public
    * @param integer
    * @return void
    */\n" );
    fwrite($fp, "    function del(\$id){\n");
    fwrite($fp, "        \$this->db->where('id',\$id);\n");
    fwrite($fp, "        \$this->db->limit(1);\n");
    fwrite($fp, "        \$this->db->delete('$table');\n");
    fwrite($fp, "    }\n");
    fwrite($fp, "}\n");
    fwrite($fp, "/* End of file $modelname */\n");
    fwrite($fp, "/* Location: ./application/models/$modelname */\n");
    fclose($fp);
    
}

function controller()
{
    global $folder,$table,$author,$date;
    $controllername = $table;
    $controller = $folder.'/controllers/'.$controllername.'.php';
    $model = 'mod'.$table;
    echo "Generating controller...\n";
    $fp = fopen($controller, 'w');
    fwrite($fp,"<?php if (!defined('BASEPATH')) exit('No direct script access allowed');\n");
    
    fwrite($fp, "/**\n");
    fwrite($fp, "* $table controller\n");
    fwrite($fp, "*\n");
    fwrite($fp, "* @author $author\n");
    fwrite($fp, "* @date $date\n");
    fwrite($fp, "*/\n");
    
    fwrite($fp,"class $controllername extends Controller {\n\n");
    fwrite($fp,"    function $controllername(){\n");
    fwrite($fp,"        parent::Controller();\n");
    fwrite($fp,"        \$this->load->model('mod$table');\n");
    fwrite($fp,"    }\n\n");
    
    fwrite($fp,"    function index(){\n");
    fwrite($fp,"        \$data['$table'] = \$this->".$model."->get()\n");
    fwrite($fp,"    }\n\n");
    
    fwrite($fp,"    function add(){\n");
    fwrite($fp,"    }\n\n");
    
    fwrite($fp,"    function edit(\$id){\n");
    fwrite($fp,"        \$editable = \$this->".$model."->id = \$id;\n");
    fwrite($fp,"        \$editable = \$this->".$model."->get();\n");
    fwrite($fp,"    }\n\n");
    
    fwrite($fp,"    function del(\$id){\n");
    fwrite($fp,'        $this->mod'.$table."->del(\$id);\n");
    fwrite($fp,"        redirect('$controllername');\n");
    fwrite($fp,"    }\n\n");
    fwrite($fp,"}\n");
    fwrite($fp, "/* End of file $controllername */\n");
    fwrite($fp, "/* Location: ./application/controllers/$controllername.php */\n");
    fclose($fp);
}

function view()
{

}

if ($mvc && $folder && $table)
{
    if (!is_dir($folder)) die("Error: Wrong CI Project folder. Use php cicrud.php [(m)odel|(c)ontroller|(v)iew|(a)ll] [CI project folder] [table] [fields]\n");
    if ($mvc == 'm' or $mvc == 'model') model(); 
    else if ($mvc == 'c' or $mvc == 'controller') controller();
    else if ($mvc == 'v' or $mvc == 'view') view();
    else if ($mvc == 'a' or $mvc == 'all') 
    {
        model();
        controller();
        view();
    }
    else die("Error: wrong argument (m) (v) (c) or (a)ll. Use php cicrud.php [(m)odel|(c)ontroller|(v)iew|(a)ll] [CI project folder] [table] [fields]\n");
}
else die("Error: no arguments. Use php cicrud.php [(m)odel|(c)ontroller|(v)iew|(a)ll] [CI project folder] [table] [fields]\n");
?>