<div class="descrGen col-lg-12">
  <input type="text" class="input input-sm pCateg pull-left" list="categNames" >
  <?php productCategory::getCategOptions(); ?>
  <input type="text" class="input input-sm pSubcateg pull-left" list="subcategNames" >
  <datalist id="subcategNames" class="subcategNames"> <!-- class name provided just for modularity, id name is the required spec -->
  </datalist>
  <input type="text" class="input input-sm pColor pull-left" list="colorNames" >
  <?php productCategory::getColorOptions(); ?>
  <input type="text" class="btn btn-primary descr" name="descr[]" readonly>
</div>