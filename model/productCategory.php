<?php 
include_once(dirname(__FILE__)."/../model/lib/util.php");
// a two level product category
class ProductCategory
{
	public $name = '';
	public $parent = '';
	public $parentIndex = 0;

	public $index = 0;

	function __construct($name="",$parent="",$parentIndex = 0)
	{
		$this->name = trim($name);
		$this->parent = trim($parent);
		$this->parentIndex = $parentIndex;

		$this->index = $this->findNewIndex();
	}

	function create()
	{
		$this->checkIfRootElement();
		db("insert into product_category (name,parent,parentIndex) values ('$this->name','$this->parent','$this->parentIndex')");
	}

	function ifRoot(){$this->checkIfRootElement();}//alias of checkIfRootElement()

	function checkIfRootElement()
	{
		if($this->parent == "")
		{
			$this->parent = "root";
			$this->parentIndex = 0;

			return true;
		}
		else
		{
			return false;
		}
	}

	function findIndexOf($category)
	{
		$categ = db("select * from product_category where name = '$category' and rank = 'category' limit 1 ");
		return $categ["tableIndex"];
	}

	function findNewIndex()
	{
		$newIndex = 1;
		$lastEntry = db("select * from product_category order by tableIndex desc limit 1 ");
		if($lastEntry ==  [])
		{
			$lastEntry = 0;
		}
		else
		{
			$newIndex = $lastEntry["tableIndex"]+1;
		}
		$this->index = $newIndex;
		//echo "the newIndex is $newIndex";
		return $newIndex;
	}
	static function showTreeR() //revised with recursive character, for scalablity //works like a charm :)
								//next is to make the input part scalable also using, hasChild thing
	{
		$rootCateg = dbEach("select * from product_category where parent = 'root' ");
		echo "<ul>";
		foreach ($rootCateg as $category) 
		{
			static::printCategory($category);
		}
		static::showAddBtn();
		echo "</ul>";
	}
	static function printCategory($info)
	{
		echo "<li>";
		static::printElementWith($info['name'],$info['tableIndex'],0,$info['parent'],"info");
		if(static::ifHasChild($info['name']))
		{
			$rootCateg = dbEach("select * from product_category where parent = '$info[name]' ");
			echo "<ul>";
			foreach ($rootCateg as $category) 
			{
				static::printCategory($category);
			}
			static::showAddBtn();
			echo "</ul>";
		}
		echo "</li>";
	}
	static function showTree()
	{
		$rootCateg = dbEach("select * from product_category where parent = 'root' ");
		echo "<ul>";
		foreach ($rootCateg as $category) { // no need for recursion, but reverse recursion can be done though
			echo "<li>";
			static::printElementWith($category['name'],$category['tableIndex'],0,'root',"info");

			$subcategArr = dbEach("select * from product_category where parentIndex = '$category[tableIndex]' ");
			if($subcategArr)
			{
				echo "<ul>";
				foreach ($subcategArr as $subcateg) { // no need for recursion atm
					echo "<li>";
					static::printElementWith($subcateg['name'],$subcateg['tableIndex'],$category['tableIndex'],$category['name'],"success");
					echo "</li>";
				}
				static::showAddBtn();
				echo "</ul>";
			}
			echo "</li>";
		}
		static::showAddBtn();
		echo "</ul>";
	}

	static function ifHasChild($name)
	{
		$child = db("select * from product_category where parent = '$name' ");
		if($child==[])
		{
			return false;
		}
			return true;
	}

	static function printElementWith($name,$index,$parentIndex,$parent,$btnType)
	{
		echo "      
					<span class=\"lead btn btn-$btnType\" data-tableIndex=\"$index\" data-parent=\"$parent\" data-parentIndex=\"$parentIndex\">$name</span>
					<span class=\"divider-vertical\"></span>
			        <span class=\"edit fa fa-edit fa-2 cur\"></span>
			        <span class=\"delete fa fa-trash-o fa-2 cur\"></span>
			        <span class=\"addSub fa fa-cogs fa-2 cur\"></span>
			    ";
	}
	static function showAddBtn()
	{
		echo "
			<li>
	            <input class=\"input\" type=\"text\">
	            <span class=\"addEntry fa fa-plus-square fa-2x cur\"></span>
	        </li>";
	}

	static function getCategOptions()//can be generalizes. marked as core
	{
		$categs = dbEach("select * from product_category where parent = 'root' ");
		echo "<datalist id=\"categNames\">";
		foreach ($categs as $categ) 
		{
			echo "<option value=\"$categ[name]\">$categ[name]</option>";
		}		
		echo "</datalist>";
	}
	static function getSubCategOptions($categ)//can be generalizes. marked as core
	{
		$categs = dbEach("select * from product_category where parent = '$categ' ");
		//echo "<datalist id=\"subcategNames\">";
		foreach ($categs as $categ) 
		{
			echo "<option value=\"$categ[name]\">$categ[name]</option>";
		}		
		//echo "</datalist>";
	}

	//======================================
	//colors
	//======================================
	static function getColorOptions()//can be generalizes. marked as core
	{
		$colors = dbEach("select * from colors");
		echo "<datalist id=\"colorNames\">";
		foreach ($colors as $color) 
		{
			echo "<option value=\"$color[name]\">$color[name]</option>";
		}		
		echo "</datalist>";
	}

	static function createNewColor($colorName)
	{
		$colorName = trim($colorName);
		db("insert into colors (name) values ('$colorName')");
	}
	static function getLastColorIndex()
	{
		$lastRow = db("select * from colors order by tableIndex desc limit 1");
		$lastIndex = $lastRow["tableIndex"];
		return $lastIndex;
	}
	static function showColors()
	{
		$colors = dbEach("select * from colors order by tableIndex");
		foreach ($colors as $color) {
			echo "<li>
                        <span class=\"lead\" data-colorIndex=\"$color[tableIndex]\">$color[name]</span>
                        <span class=\"divider-vertical\"></span>
                        <span class=\"editColor fa fa-edit fa-2 cur\"></span>
                        <span class=\"deleteColor fa fa-trash-o fa-2 cur\"></span>
                    </li>";
		}
	}
}

?>