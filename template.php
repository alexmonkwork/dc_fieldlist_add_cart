<?php

 function theme_form_commerce_cart_add_to_cart_form_alter(&$form, &$form_state){

    //wrapper add cart form
	  $form['quantity']['#weight']= 44;  
	  $form['quantity']['#prefix']='<div class="basket">'; 

  if (isset($form_state['default_product']->commerce_price) || isset($form_state['default_product']->product_id)){   

	//get product_id 
       $product_id = $form_state['default_product']->product_id;
    //get commerce stock value  used module commerce_stock 
       $query = db_select('field_data_commerce_stock', 's');
       $query->fields('s', array('commerce_stock_value'));
       $query->condition('s.entity_id', $product_id, '=');
       $stock = $query->execute()->fetchField();

  $form['commerce_stock'] = array(
      '#title' => t(''),
      '#type' => 'item',
      '#markup' => (float)$stock,
      '#prefix' => '',
      '#suffix' => '',
      '#weight' =>45,
    );

  //get product price witch currency_code
    $price = commerce_product_calculate_sell_price($form_state['default_product']);
    $form['display_price'] = array(
      '#title' => t(''),
      '#type' => 'item',
      '#markup' => commerce_currency_format($price['amount'], $price['currency_code']),
      '#prefix' => '',
      '#suffix' => '',
      '#weight' =>46,
    );

  // get custom field value 
   $query = db_select('field_data_field_oldprice', 'o');
       $query->fields('o', array('field_oldprice_value'));
       $query->condition('o.entity_id', $product_id, '=');
       $old = $query->execute()->fetchField();

    $form['field_oldprice'] = array(
      '#title' => t(''),
      '#type' => 'item',
      '#markup' => $old,
      '#prefix' => '',
      '#suffix' => '',
      '#weight' =>47,
    );

 }   

   $form['commerce_cart_add_to_cart_form']['#weight']= 60;  
   $form['commerce_cart_add_to_cart_form']['#suffix']='</div>';

}



?>