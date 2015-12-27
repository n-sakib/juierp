<?php 
include_once(dirname(__FILE__)."/../model/lib/util.php");
// a two level product category
class ProductCategory
{
	public $category = '';
	public $subCategory = '';

	public $name = '';
	public $parent = '';
	public $parentIndex = 0;
	public $rank = ''; //enumerated = [category, subCategory]

	function __construct($category="",$subCategory="")
	{
		$this->category = $category;
		$this->subCategory = $subCategory;

		if($subCategory != "") //is a subcategory
		{
			$this->name = $subCategory;
			$this->parent =  $category;
			$this->rank = "subCategory";
		}
		else
		{
			$this->name = $category;
			$this->rank = "category";
		}
	}

	function create()
	{
		if($this->rank == "category")
		{
			db("insert into product_category (name,rank,parent) values ('$this->name','$this->rank',parent)");	
		}
		else
		{
			db("insert into product_category (name,rank,parent) values ('$this->name','$this->rank','$this->parent')");	
		}
	}

	function findIndexOf($category)
	{
		$categ = db("select * from product_category where name = '$category' and rank = 'category' limit 1 ");
		return $categ["tableIndex"];
	}


}

?>